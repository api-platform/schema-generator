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

namespace ApiPlatform\SchemaGenerator\Model;

use Doctrine\Inflector\Inflector;
use EasyRdf\Resource as RdfResource;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;

final class Class_
{
    private string $name;
    private string $namespace = '';
    private ?Interface_ $interface = null;
    private array $uses = [];
    /** @var Property[] */
    private array $properties = [];
    /** @var array|Constant[] */
    private array $constants = [];
    private array $annotations = [];
    private array $operations = [];
    private bool $hasConstructor = false;
    private bool $parentHasConstructor = false;
    private bool $isAbstract = false;
    private bool $hasChild = false;
    private bool $embeddable = false;
    /** @var bool|string|null */
    private $parent;
    private RdfResource $resource;

    private const SCHEMA_ORG_ENUMERATION = 'https://schema.org/Enumeration';

    public function __construct(string $name, RdfResource $resource, $parent = null)
    {
        $this->name = $name;
        $this->resource = $resource;
        $this->parent = $parent;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function interfaceName(): ?string
    {
        return $this->interface ? $this->interface->name() : null;
    }

    public function interfaceNamespace(): ?string
    {
        return $this->interface ? $this->interface->namespace() : null;
    }

    public function interfaceToNetteFile(string $fileHeader = null): PhpFile
    {
        if (!$this->interface) {
            throw new \LogicException(sprintf("'%s' has no interface attached.", $this->name));
        }

        return $this->interface->toNetteFile($fileHeader);
    }

    public function withNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function withParent($parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function withInterface(Interface_ $interface): self
    {
        $this->interface = $interface;

        return $this;
    }

    public function addProperty(Property $property): self
    {
        $this->properties[$property->name] = $property;

        return $this;
    }

    public function removePropertyByName(string $name): self
    {
        unset($this->properties[$name]);

        return $this;
    }

    public function getPropertyByName(string $name): ?Property
    {
        return $this->properties[$name] ?? null;
    }

    public function hasProperty(string $propertyName): bool
    {
        return isset($this->properties[$propertyName]);
    }

    public function addUse(string $use): self
    {
        if (!\in_array($use, $this->uses, true)) {
            $this->uses[] = $use;
        }

        return $this;
    }

    public function addAnnotation(string $annotation): self
    {
        if ('' === $annotation || !\in_array($annotation, $this->annotations, true)) {
            $this->annotations[] = $annotation;
        }

        return $this;
    }

    public function addInterfaceAnnotation(string $annotation): self
    {
        if (null !== $this->interface) {
            $this->interface->addAnnotation($annotation);
        }

        return $this;
    }

    public function addConstant(string $key, Constant $constant): self
    {
        $this->constants[$key] = $constant;

        return $this;
    }

    /** @return Constant[] */
    public function constants(): array
    {
        return $this->constants;
    }

    public function operations(): array
    {
        return $this->operations;
    }

    public function setOperations(array $operations): self
    {
        $this->operations = $operations;

        return $this;
    }

    public function resource(): RdfResource
    {
        return $this->resource;
    }

    public function resourceUri(): string
    {
        return $this->resource->getUri();
    }

    public function resourceComment(): ?string
    {
        return (string) $this->resource->get('rdfs:comment');
    }

    public function resourceLocalName(): string
    {
        return $this->resource->localName();
    }

    public function parent(): ?string
    {
        if (false === $this->parent) {
            return '';
        }

        return $this->parent;
    }

    public function setParent(?string $parent): void
    {
        $this->parent = $parent;
    }

    public function hasParent(): bool
    {
        return '' !== $this->parent && null !== $this->parent && false !== $this->parent;
    }

    public function markWithConstructor(): self
    {
        $this->hasConstructor = true;

        return $this;
    }

    public function setIsAbstract(bool $isAbstract): self
    {
        $this->isAbstract = $isAbstract;

        return $this;
    }

    public function isAbstract(): bool
    {
        return $this->isAbstract;
    }

    public function getSubClassOf(): array
    {
        return array_filter($this->resource->all('rdfs:subClassOf', 'resource'), static fn (RdfResource $resource) => !$resource->isBNode());
    }

    public function isEnum(): bool
    {
        $subClassOf = $this->resource->get('rdfs:subClassOf');

        return $subClassOf && self::SCHEMA_ORG_ENUMERATION === $subClassOf->getUri();
    }

    public function isParentEnum(): bool
    {
        if (!$this->hasParent()) {
            return false;
        }

        return 'Enum' === $this->parent;
    }

    public function isInNamespace(string $namespace): bool
    {
        return $this->namespace === $namespace;
    }

    public function namespace(): string
    {
        return $this->namespace;
    }

    /** @return Property[] */
    public function properties(): array
    {
        return $this->properties;
    }

    /** @return Property[] */
    public function uniqueProperties(): array
    {
        return array_filter($this->properties, static fn (Property $property) => $property->isUnique);
    }

    /** @return string[] */
    public function uniquePropertyNames(): array
    {
        return array_map(static fn (Property $property) => $property->name, $this->uniqueProperties());
    }

    public function toNetteFile(array $config, Inflector $inflector): PhpFile
    {
        $useDoctrineCollections = $config['doctrine']['useCollection'] ?? true;
        $useAccessors = $config['accessorMethods'] ?? true;
        $useFluentMutators = $config['fluentMutatorMethods'] ?? false;
        $fileHeader = $config['header'] ?? null;
        $fieldVisibility = $config['fieldVisibility'] ?? ClassType::VISIBILITY_PRIVATE;

        $file = new PhpFile();
        if (null !== $fileHeader && false !== $fileHeader) {
            // avoid nested doc-block for configurations that already have * as delimiter
            $file->setComment(Helpers::unformatDocComment($fileHeader));
        }

        $namespace = $file->addNamespace($this->namespace);
        foreach ($this->uses as $use) {
            $namespace->addUse($use);
        }

        $class = $namespace->addClass($this->name);

        foreach ($this->annotations as $annotation) {
            $class->addComment($annotation);
        }

        $class->setAbstract($this->isAbstract);

        if (null !== $this->interface) {
            $class->setImplements([$this->interfaceName()]);
        }

        if ($this->hasParent()) {
            $class->setExtends($this->parent());
        }

        $sortedProperties = isset($this->properties['id']) ? ['id' => $this->properties['id']] + $this->properties : $this->properties;

        $class->setConstants(array_map(static fn (Constant $constant) => $constant->toNetteConstant(), $this->constants));
        $class->setProperties(array_map(
            static function (Property $property) use ($useDoctrineCollections, $fieldVisibility) {
                return $property->toNetteProperty($fieldVisibility, $useDoctrineCollections);
            },
            $sortedProperties
        ));

        if ($useDoctrineCollections && $this->hasConstructor) {
            $constructor = new Method('__construct');
            if ($this->parentHasConstructor) {
                $constructor->addBody('parent::__construct();');
            }

            foreach ($sortedProperties as $property) {
                if ($property->isArray && 'array' !== $property->typeHint && !$property->isEnum) {
                    $constructor->addBody('$this->? = new ArrayCollection();', [$property->name()]);
                }
            }

            if ('' !== $constructor->getBody()) {
                $class->addMember($constructor);
            }
        }

        if ($useAccessors) {
            foreach ($sortedProperties as $property) {
                foreach ($property->generateNetteMethods(static function ($string) use ($inflector) {
                    return $inflector->singularize($string);
                }, $useDoctrineCollections, $useFluentMutators) as $method) {
                    $class->addMember($method);
                }
            }
        }

        return $file;
    }

    public function isEmbeddable(): bool
    {
        return $this->embeddable;
    }

    public function setEmbeddable(bool $embeddable): self
    {
        $this->embeddable = $embeddable;

        return $this;
    }

    public function hasChild(): bool
    {
        return $this->hasChild;
    }

    public function hasConstructor(): bool
    {
        return $this->hasConstructor;
    }

    public function markAsHasChild(): self
    {
        $this->hasChild = true;

        return $this;
    }

    public function setParentHasConstructor(bool $parentHasConstructor): self
    {
        $this->parentHasConstructor = $parentHasConstructor;

        return $this;
    }
}
