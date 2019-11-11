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

namespace ApiPlatform\SchemaGenerator\Command;

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\GoodRelationsBridge;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use ApiPlatform\SchemaGenerator\TypesGeneratorConfiguration;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

/**
 * Generate entities command.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class GenerateTypesCommand extends Command
{
    private const DEFAULT_CONFIG_FILE = 'schema.yaml';

    private $namespacePrefix;
    private $defaultOutput;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        if (file_exists('composer.json') && is_file('composer.json') && is_readable('composer.json')) {
            $composer = json_decode(file_get_contents('composer.json'), true);
            foreach ($composer['autoload']['psr-4'] ?? [] as $prefix => $output) {
                if ('' === $prefix) {
                    continue;
                }

                $this->namespacePrefix = $prefix;
                $this->defaultOutput = $output;

                break;
            }
        }

        $this
            ->setName('generate-types')
            ->setDescription('Generate types')
            ->addArgument('output', $this->defaultOutput ? InputArgument::OPTIONAL : InputArgument::REQUIRED, 'The output directory', $this->defaultOutput)
            ->addArgument('config', InputArgument::OPTIONAL, 'The config file to use (default to "schema.yaml" in the current directory, will generate all types if no config file exists)');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $defaultOutput = $this->defaultOutput ? realpath($this->defaultOutput) : null;
        $outputDir = $input->getArgument('output');
        $configArgument = $input->getArgument('config');

        if ($dir = realpath($input->getArgument('output'))) {
            if (!is_dir($dir)) {
                if (!$this->defaultOutput) {
                    throw new \InvalidArgumentException(sprintf('The file "%s" is not a directory.', $dir));
                }

                $dir = $defaultOutput;
                $configArgument = $outputDir;
            }

            if (!is_writable($dir)) {
                throw new \InvalidArgumentException(sprintf('The "%s" directory is not writable.', $dir));
            }

            $outputDir = $dir;
        } elseif (!@mkdir($outputDir, 0777, true)) {
            throw new \InvalidArgumentException(sprintf('Cannot create the "%s" directory. Check that the parent directory is writable.', $outputDir));
        } else {
            $outputDir = realpath($outputDir);
        }

        if ($configArgument) {
            if (!file_exists($configArgument)) {
                throw new \InvalidArgumentException(sprintf('The file "%s" doesn\'t exist.', $configArgument));
            }

            if (!is_file($configArgument)) {
                throw new \InvalidArgumentException(sprintf('"%s" isn\'t a file.', $configArgument));
            }

            if (!is_readable($configArgument)) {
                throw new \InvalidArgumentException(sprintf('The file "%s" isn\'t readable.', $configArgument));
            }

            $parser = new Parser();
            $config = $parser->parse(file_get_contents($configArgument));
            unset($parser);
        } elseif (is_readable(self::DEFAULT_CONFIG_FILE)) {
            $parser = new Parser();
            $config = $parser->parse(file_get_contents(self::DEFAULT_CONFIG_FILE));
            unset($parser);
        } else {
            $config = [];
        }

        $processor = new Processor();
        $configuration = new TypesGeneratorConfiguration($dir === $defaultOutput ? $this->namespacePrefix : null);
        $processedConfiguration = $processor->processConfiguration($configuration, [$config]);
        $processedConfiguration['output'] = $outputDir;
        if (!$processedConfiguration['output']) {
            throw new \RuntimeException('The specified output is invalid');
        }

        $graphs = [];
        foreach ($processedConfiguration['rdfa'] as $rdfa) {
            $graph = new \EasyRdf_Graph();
            if (0 === strpos($rdfa['uri'], 'http://') || 0 === strpos($rdfa['uri'], 'https://')) {
                $graph->load($rdfa['uri'], $rdfa['format']);
            } else {
                $graph->parseFile($rdfa['uri'], $rdfa['format']);
            }

            $graphs[] = $graph;
        }

        $relations = [];
        foreach ($processedConfiguration['relations'] as $relation) {
            $relations[] = new \SimpleXMLElement($relation, 0, true);
        }

        $goodRelationsBridge = new GoodRelationsBridge($relations);
        $cardinalitiesExtractor = new CardinalitiesExtractor($graphs, $goodRelationsBridge);

        $templatePaths = $processedConfiguration['generatorTemplates'];
        $templatePaths[] = __DIR__.'/../../templates/';

        $loader = new FilesystemLoader($templatePaths);
        $twig = new Environment($loader, ['autoescape' => false, 'debug' => $processedConfiguration['debug']]);
        $twig->addFilter(new TwigFilter('ucfirst', 'ucfirst'));
        $twig->addFilter(new TwigFilter('pluralize', [Inflector::class, 'pluralize']));
        $twig->addFilter(new TwigFilter('singularize', [Inflector::class, 'singularize']));

        if ($processedConfiguration['debug']) {
            $twig->addExtension(new DebugExtension());
        }

        $logger = new ConsoleLogger($output);

        $entitiesGenerator = new TypesGenerator($twig, $logger, $graphs, $cardinalitiesExtractor, $goodRelationsBridge);
        $entitiesGenerator->generate($processedConfiguration);

        return 0;
    }
}
