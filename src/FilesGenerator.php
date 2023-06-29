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

use ApiPlatform\SchemaGenerator\Model\Class_;
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
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\String\Inflector\InflectorInterface;
use Twig\Environment;

final class FilesGenerator
{
    use LoggerAwareTrait;

    private InflectorInterface $inflector;
    private Printer $printer;
    private Environment $twig;
    private Filesystem $filesystem;
    private SymfonyStyle $io;

    public function __construct(InflectorInterface $inflector, Printer $printer, Environment $twig, SymfonyStyle $io)
    {
        $this->inflector = $inflector;
        $this->printer = $printer;
        $this->twig = $twig;
        $this->filesystem = new Filesystem();
        $this->io = $io;
    }

    /**
     * Generates files.
     *
     * @param Class_[]      $classes
     * @param Configuration $config
     */
    public function generate(array $classes, array $config): void
    {
        $interfaceMappings = [];
        $generatedFiles = [];

        foreach ($classes as $className => $class) {
            $classDir = $this->namespaceToDir($class->namespace, $config);
            $this->filesystem->mkdir($classDir);

            $path = sprintf('%s%s.php', $classDir, $className);

            $file = null;
            if (file_exists($path) && is_file($path) && is_readable($path) && $fileContent = file_get_contents($path)) {
                $choice = $this->io->askQuestion(new ChoiceQuestion(sprintf('File "%s" already exists, keep your changes and update it (use) or overwrite it (overwrite)?', $path), ['use', 'overwrite'], 0));
                if ('use' === $choice) {
                    $file = PhpFile::fromCode($fileContent);
                    $this->logger ? $this->logger->info(sprintf('Using "%s" as base file.', $path)) : null;
                }
            }

            try {
                file_put_contents($path, $this->printer->printFile($class->toNetteFile($config, $this->inflector, $file)));
            } catch (NetteInvalidArgumentException $exception) {
                $this->logger ? $this->logger->warning($exception->getMessage()) : null;
            }

            $generatedFiles[] = $path;

            if (null !== $class->interfaceNamespace()) {
                $interfaceDir = $this->namespaceToDir($class->interfaceNamespace(), $config);
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
     * Converts a namespace to a directory path according to PSR-4.
     *
     * @param Configuration $config
     */
    private function namespaceToDir(string $namespace, array $config): string
    {
        if (null !== ($prefix = $config['namespaces']['prefix'] ?? null) && str_starts_with($namespace, $prefix)) {
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
                '@PhpCsFixer' => true,
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
