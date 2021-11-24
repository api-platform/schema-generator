<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator;

use ApiPlatform\SchemaGenerator\ClassMutator\AnnotationsAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\AttributeAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassIdAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassInterfaceMutator;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassParentMutator;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassPropertiesAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassPropertiesTypehintMutator;
use ApiPlatform\SchemaGenerator\ClassMutator\EnumClassMutator;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGenerator;
use Doctrine\Inflector\Inflector;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\RdfNamespace;
use EasyRdf\Resource as RdfResource;
use Nette\InvalidArgumentException as NetteInvalidArgumentException;
use Nette\PhpGenerator\PhpFile;
use PhpCsFixer\Cache\NullCacheManager;
use PhpCsFixer\Differ\NullDiffer;
use PhpCsFixer\Error\ErrorsManager;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\Linter\Linter;
use PhpCsFixer\RuleSet as LegacyRuleSet;
use PhpCsFixer\RuleSet\RuleSet;
use PhpCsFixer\Runner\Runner;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

/**
 * Generates entity files.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class TypesGenerator
{
    /**
     * @var string
     *
     * @internal
     */
    public const SCHEMA_ORG_ENUMERATION = 'https://schema.org/Enumeration';

    /**
     * @var string[] the RDF types of classes in the vocabs
     */
    public static array $classTypes = [
      'rdfs:Class',
      'owl:Class',
    ];

    /**
     * @var string[] the RDF types of properties in the vocabs
     */
    public static array $propertyTypes = [
        'rdf:Property',
        'owl:ObjectProperty',
        'owl:DatatypeProperty',
    ];

    /**
     * @var string[] the RDF types of domains in the vocabs
     */
    public static array $domainProperties = [
      'schema:domainIncludes',
      'rdfs:domain',
    ];

    private Environment $twig;
    private LoggerInterface $logger;
    /** @var RdfGraph[] */
    private array $graphs;
    private PhpTypeConverterInterface $phpTypeConverter;
    private GoodRelationsBridge $goodRelationsBridge;
    /** @var array<string, string> */
    private array $cardinalities;
    private Inflector $inflector;
    private Filesystem $filesystem;
    private PropertyGenerator $propertyGenerator;
    private Printer $printer;
    private SymfonyStyle $io;

    /**
     * @param RdfGraph[] $graphs
     */
    public function __construct(Inflector $inflector, Environment $twig, LoggerInterface $logger, array $graphs, PhpTypeConverterInterface $phpTypeConverter, CardinalitiesExtractor $cardinalitiesExtractor, GoodRelationsBridge $goodRelationsBridge, Printer $printer, SymfonyStyle $io)
    {
        if (!$graphs) {
            throw new \InvalidArgumentException('At least one graph must be injected.');
        }

        $this->inflector = $inflector;
        $this->twig = $twig;
        $this->logger = $logger;
        $this->graphs = $graphs;
        $this->phpTypeConverter = $phpTypeConverter;
        $this->goodRelationsBridge = $goodRelationsBridge;
        $this->filesystem = new Filesystem();
        $this->cardinalities = $cardinalitiesExtractor->extract();
        $this->propertyGenerator = new PropertyGenerator($this->goodRelationsBridge, $this->phpTypeConverter, $this->cardinalities, $this->logger);
        $this->printer = $printer;
        $this->io = $io;

        RdfNamespace::set('schema', 'https://schema.org/');
    }

    /**
     * Generates files.
     *
     * @param Configuration $config
     */
    public function generate(array $config): void
    {
        $typesToGenerate = $this->defineTypesToGenerate($config);

        $classes = [];
        $propertiesMap = $this->createPropertiesMap($typesToGenerate, $config);

        foreach ($typesToGenerate as $typeName => $type) {
            if ($type->isBNode()) {
                // Ignore blank nodes
                continue;
            }

            $typeName = $this->phpTypeConverter->escapeIdentifier(\is_string($typeName) ? $typeName : $type->localName());
            if ($type->isA('owl:DeprecatedClass')) {
                if (!isset($config['types'][$typeName])) {
                    continue;
                }

                $this->logger->warning('The type "{type}" is deprecated', ['type' => $type->getUri()]);
            }

            $typeConfig = $config['types'][$typeName] ?? null;
            $parent = $typeConfig['parent'] ?? null;
            $class = new Class_($typeName, $type, $parent);
            $class->operations = $typeConfig['operations'] ?? [];
            $class->security = $typeConfig['security'] ?? null;

            if ($class->isEnum()) {
                $class = (new EnumClassMutator(
                    $this->phpTypeConverter,
                    $this->graphs,
                    $config['namespaces']['enum']
                ))($class);
            } else {
                $class->namespace = $typeConfig['namespaces']['class'] ?? $config['namespaces']['entity'];

                // Interfaces
                if ($config['useInterface']) {
                    $interfaceNamespace = isset($typeConfig['namespaces']['interface']) && $typeConfig['namespaces']['interface'] ? $typeConfig['namespaces']['interface'] : $config['namespaces']['interface'];
                    $class = (new ClassInterfaceMutator($interfaceNamespace))($class);
                }

                $class = (new ClassParentMutator($config, $this->phpTypeConverter, $this->logger))($class);
            }

            $class = (new ClassPropertiesAppender($this->propertyGenerator, $this->logger, $config, $propertiesMap, $this->graphs))($class);
            $class->isEmbeddable = $typeConfig['embeddable'] ?? false;

            $classes[$typeName] = $class;
        }

        // Second pass
        foreach ($classes as &$class) {
            /** @var $class Class_ */
            if ($class->hasParent() && !$class->isParentEnum()) {
                $parentClass = $classes[$class->parent()] ?? null;
                if (isset($parentClass)) {
                    $parentClass->hasChild = true;
                    $class->parentHasConstructor = $parentClass->hasConstructor;
                } else {
                    $this->logger->error(sprintf('The type "%s" (parent of "%s") doesn\'t exist', $class->parent(), $class->resourceUri()));
                }
            }

            $class = (new ClassPropertiesTypehintMutator($this->phpTypeConverter, $config, $classes))($class);
        }

        // Third pass
        foreach ($classes as &$class) {
            /* @var $class Class_ */
            $class->isAbstract = $config['types'][$class->name()]['abstract'] ?? $class->hasChild;

            // When including all properties, ignore properties already set on parent
            if (($config['types'][$class->name()]['allProperties'] ?? true) && isset($classes[$class->parent()])) {
                $type = $class->resource();
                foreach ($propertiesMap[$type->getUri()] as $property) {
                    $propertyName = $property->localName();
                    if (!$class->hasProperty($propertyName)) {
                        continue;
                    }

                    $parentConfig = $config['types'][$class->parent()] ?? null;
                    /** @var Class_|null $parentClass */
                    $parentClass = $classes[$class->parent()];

                    while ($parentClass) {
                        if (\array_key_exists($propertyName, $parentConfig['properties'] ?? []) || \in_array($property, $propertiesMap[$parentClass->resourceUri()], true)) {
                            $class->removePropertyByName($propertyName);
                            continue 2;
                        }

                        $parentConfig = $parentClass->parent() ? ($config['types'][$parentClass->parent()] ?? null) : null;
                        $parentClass = $parentClass->parent() && isset($classes[$parentClass->parent()]) ? $classes[$parentClass->parent()] : null;
                    }
                }
            }
        }

        // Generate ID
        if ($config['id']['generate']) {
            foreach ($classes as &$class) {
                $class = (new ClassIdAppender($config))($class);
            }
        }

        // Initialize annotation generators
        $annotationGenerators = [];
        foreach ($config['annotationGenerators'] as $annotationGenerator) {
            $generator = new $annotationGenerator($this->phpTypeConverter, $this->logger, $this->inflector, $this->graphs, $this->cardinalities, $config, $classes);

            $annotationGenerators[] = $generator;
        }

        // Initialize attribute generators
        $attributeGenerators = [];
        foreach ($config['attributeGenerators'] as $attributeGenerator) {
            $generator = new $attributeGenerator($this->phpTypeConverter, $this->logger, $this->inflector, $this->graphs, $this->cardinalities, $config, $classes);

            $attributeGenerators[] = $generator;
        }

        $interfaceMappings = [];
        $generatedFiles = [];

        foreach ($classes as $className => &$class) {
            $class = (new AnnotationsAppender($classes, $annotationGenerators, $typesToGenerate))($class);
            $class = (new AttributeAppender($classes, $attributeGenerators))($class);

            $classDir = $this->namespaceToDir($config, $class->namespace);
            $this->filesystem->mkdir($classDir);

            $path = sprintf('%s%s.php', $classDir, $className);

            $file = null;
            if (file_exists($path) && is_file($path) && is_readable($path) && $fileContent = file_get_contents($path)) {
                $confirmation = $this->io->askQuestion(new ConfirmationQuestion(sprintf('File "%s" already exists, use it (if no it will be overwritten)?', $path)));
                if ($confirmation) {
                    $file = PhpFile::fromCode($fileContent);
                    $this->logger->info(sprintf('Using "%s" as base file.', $path));
                }
            }

            try {
                file_put_contents($path, $this->printer->printFile($class->toNetteFile($config, $this->inflector, $file)));
            } catch (NetteInvalidArgumentException $exception) {
                $this->logger->warning($exception->getMessage());
            }

            $generatedFiles[] = $path;

            if (null !== $class->interfaceNamespace()) {
                $interfaceDir = $this->namespaceToDir($config, $class->interfaceNamespace());
                $this->filesystem->mkdir($interfaceDir);

                $path = sprintf('%s%s.php', $interfaceDir, $class->interfaceName());
                $generatedFiles[] = $path;
                file_put_contents($path, $this->printer->printFile($class->interfaceToNetteFile($config['header'] ?? null)));

                if ($config['doctrine']['resolveTargetEntityConfigPath'] && !$class->isAbstract) {
                    $interfaceMappings[$class->interfaceNamespace().'\\'.$class->interfaceName()] = $class->namespace.'\\'.$className;
                }
            }
        }

        if ($config['doctrine']['resolveTargetEntityConfigPath'] && \count($interfaceMappings) > 0) {
            $file = $config['output'].'/'.$config['doctrine']['resolveTargetEntityConfigPath'];
            $dir = \dirname($file);
            $this->filesystem->mkdir($dir);

            $fileType = $config['doctrine']['resolveTargetEntityConfigType'];

            $mappingTemplateFile = 'doctrine.xml.twig';
            if ('yaml' === $fileType) {
                $mappingTemplateFile = 'doctrine.yaml.twig';
            }

            file_put_contents(
                $file,
                $this->twig->render($mappingTemplateFile, ['mappings' => $interfaceMappings])
            );

            $generatedFiles[] = $file;
        }

        $this->fixCs($generatedFiles);
    }

    /**
     * Gets the parent classes of the current one and add them to $parentClasses array.
     *
     * @param RdfResource[] $parentClasses
     *
     * @return RdfResource[]
     */
    private function getParentClasses(RdfResource $resource, array $parentClasses = []): array
    {
        if ([] === $parentClasses) {
            return $this->getParentClasses($resource, [$resource]);
        }

        $filterBNodes = fn ($parentClasses) => array_filter($parentClasses, fn ($parentClass) => !$parentClass->isBNode());
        if (!$subclasses = $resource->all('rdfs:subClassOf', 'resource')) {
            return $filterBNodes($parentClasses);
        }

        $parentClassUri = $subclasses[0]->getUri();
        $parentClasses[] = $subclasses[0];

        foreach ($this->graphs as $graph) {
            foreach (self::$classTypes as $classType) {
                foreach ($graph->allOfType($classType) as $type) {
                    if ($type->getUri() === $parentClassUri) {
                        return $this->getParentClasses($type, $parentClasses);
                    }
                }
            }
        }

        return $filterBNodes($parentClasses);
    }

    /**
     * Creates a map between classes and properties.
     *
     * @param RdfResource[] $types
     * @param Configuration $config
     *
     * @return array<string, RdfResource[]>
     */
    private function createPropertiesMap(array $types, array $config): array
    {
        $typesResources = [];
        $map = [];
        foreach ($types as $type) {
            // get all parent classes until the root
            $parentClasses = $this->getParentClasses($type);
            $typesResources[] = [
                'resources' => $parentClasses,
                'uris' => array_map(static fn (RdfResource $parentClass) => $parentClass->getUri(), $parentClasses),
                'names' => array_map(fn (RdfResource $parentClass) => $this->phpTypeConverter->escapeIdentifier($parentClass->localName()), $parentClasses),
            ];
            $map[$type->getUri()] = [];
        }

        foreach ($this->graphs as $graph) {
            foreach (self::$propertyTypes as $propertyType) {
                /** @var RdfResource $property */
                foreach ($graph->allOfType($propertyType) as $property) {
                    if ($property->isBNode()) {
                        continue;
                    }

                    foreach (self::$domainProperties as $domainPropertyType) {
                        foreach ($property->all($domainPropertyType, 'resource') as $domain) {
                            $this->addPropertyToMap($property, $domain, $typesResources, $config, $map);
                        }
                    }
                }
            }
        }

        return $map;
    }

    /**
     * @param array{resources: RdfResource[], uris: string[], names: string[]}[] $typesResources
     * @param Configuration                $config
     * @param array<string, RdfResource[]> $map
     */
    private function addPropertyToMap(RdfResource $property, RdfResource $domain, array $typesResources, array $config, array &$map): void
    {
        $propertyName = $property->localName();
        $deprecated = $property->isA('owl:DeprecatedProperty');

        if ($domain->isBNode()) {
            if (null !== ($unionOf = $domain->get('owl:unionOf'))) {
                $this->addPropertyToMap($property, $unionOf, $typesResources, $config, $map);

                return;
            }

            if (null !== ($rdfFirst = $domain->get('rdf:first'))) {
                $this->addPropertyToMap($property, $rdfFirst, $typesResources, $config, $map);
                if (null !== ($rdfRest = $domain->get('rdf:rest'))) {
                    $this->addPropertyToMap($property, $rdfRest, $typesResources, $config, $map);
                }
            }

            return;
        }

        foreach ($typesResources as $typesResourceHierarchy) {
            foreach ($typesResourceHierarchy['uris'] as $k => $typeUri) {
                if ($domain->getUri() !== $typeUri) {
                    continue;
                }

                $propertyConfig = $config['types'][$typesResourceHierarchy['names'][$k]]['properties'][$propertyName] ?? null;

                if ($propertyConfig['exclude'] ?? false) {
                    continue;
                }

                if ($deprecated) {
                    if (null === $propertyConfig) {
                        continue;
                    }

                    $this->logger->warning('The property "{property}" of the type "{type}" is deprecated', ['property' => $property->getUri(), 'type' => $typeUri]);
                }

                $map[$typeUri][] = $property;
            }
        }
    }

    /**
     * @param Configuration $config
     *
     * @return RdfResource[]
     */
    private function defineTypesToGenerate(array $config): array
    {
        $typesToGenerate = [];
        if ($config['allTypes'] || !$config['types']) {
            foreach ($this->graphs as $graph) {
                foreach (self::$classTypes as $classType) {
                    foreach ($graph->allOfType($classType) as $type) {
                        if (!($config['types'][$this->phpTypeConverter->escapeIdentifier($type->localName())]['exclude'] ?? false)) {
                            $typesToGenerate[] = $type;
                        }
                    }
                }
            }
        } else {
            foreach ($config['types'] as $typeName => $typeConfig) {
                $vocabularyNamespace = $typeConfig['vocabularyNamespace'] ?? $config['vocabularyNamespace'];

                $resource = null;
                foreach ($this->graphs as $graph) {
                    $resources = $graph->resources();

                    $typeIri = $vocabularyNamespace.$typeName;
                    if (isset($resources[$typeIri])) {
                        $resource = $graph->resource($typeIri);
                        break;
                    }
                }

                if ($resource) {
                    $typesToGenerate[$typeName] = $resource;
                } else {
                    $this->logger->warning('Type "{typeName}" cannot be found. Using "{guessFrom}" type to generate entity.', ['typeName' => $typeName, 'guessFrom' => $typeConfig['guessFrom']]);
                    if (isset($graph)) {
                        $type = $graph->resource($vocabularyNamespace.$typeConfig['guessFrom']);
                        $typesToGenerate[$typeName] = $type;
                    }
                }
            }
        }

        return $typesToGenerate;
    }

    /**
     * Converts a namespace to a directory path according to PSR-4.
     *
     * @param Configuration $config
     */
    private function namespaceToDir(array $config, string $namespace): string
    {
        if (null !== ($prefix = $config['namespaces']['prefix'] ?? null) && 0 === strpos($namespace, $prefix)) {
            $namespace = substr($namespace, \strlen($prefix));
        }

        return sprintf('%s/%s/', $config['output'], str_replace('\\', '/', $namespace));
    }

    /**
     * Uses PHP CS Fixer to make generated files following PSR and Symfony Coding Standards.
     *
     * @param string[] $files
     */
    private function fixCs(array $files): void
    {
        $fileInfos = [];
        foreach ($files as $file) {
            $fileInfos[] = new \SplFileInfo($file);
        }

        // to keep compatibility with both versions of php-cs-fixer: 2.x and 3.x
        // ruleset object must be created depending on which class is available
        $rulesetClass = class_exists(LegacyRuleSet::class) ? LegacyRuleSet::class : Ruleset::class;
        $fixers = (new FixerFactory())
            ->registerBuiltInFixers()
            ->useRuleSet(new $rulesetClass([ // @phpstan-ignore-line
                '@Symfony' => true,
                'array_syntax' => ['syntax' => 'short'],
                'phpdoc_order' => true,
                'declare_strict_types' => true,
            ]))
            ->getFixers();

        $runner = new Runner(
            new \ArrayIterator($fileInfos),
            $fixers,
            new NullDiffer(),
            null,
            new ErrorsManager(),
            new Linter(),
            false,
            new NullCacheManager()
        );
        $runner->fix();
    }
}
