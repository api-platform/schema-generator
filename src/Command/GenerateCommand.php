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

use ApiPlatform\SchemaGenerator\OpenApi\Generator as OpenApiGenerator;
use ApiPlatform\SchemaGenerator\Schema\Generator as SchemaGenerator;
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

/**
 * Generate entities command.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class GenerateCommand extends Command
{
    private const DEFAULT_CONFIG_FILE = 'schema.yaml';

    private ?string $namespacePrefix = null;
    private ?string $defaultOutput = null;

    protected function configure(): void
    {
        $this->readComposer();

        $this
            ->setName('generate')
            ->setDescription('Generate the PHP code')
            ->addArgument('output', $this->defaultOutput ? InputArgument::OPTIONAL : InputArgument::REQUIRED, 'The output directory', $this->defaultOutput)
            ->addArgument('config', InputArgument::OPTIONAL, 'The config file to use (default to "schema.yaml" in the current directory, will generate all types if no config file exists)');
    }

    private function readComposer(): void
    {
        if (file_exists('composer.json') && is_file('composer.json') && is_readable('composer.json')) {
            if (false === ($composerContent = file_get_contents('composer.json'))) {
                throw new \RuntimeException('Cannot read composer.json content.');
            }
            $composer = json_decode($composerContent, true, 512, \JSON_THROW_ON_ERROR);
            foreach ($composer['autoload']['psr-4'] ?? [] as $prefix => $output) {
                if ('' === $prefix) {
                    continue;
                }

                $this->namespacePrefix = $prefix;
                $this->defaultOutput = $output;

                break;
            }
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $defaultOutput = $this->defaultOutput ? realpath($this->defaultOutput) : null;
        $outputDir = $input->getArgument('output');
        $configArgument = $input->getArgument('config');

        if ($dir = realpath($outputDir)) {
            if (!is_dir($dir)) {
                if (!$defaultOutput) {
                    throw new \InvalidArgumentException(sprintf('The file "%s" is not a directory.', $dir));
                }

                $dir = $defaultOutput;
                $configArgument = $outputDir;
            }

            if (!is_writable($dir)) {
                throw new \InvalidArgumentException(sprintf('The "%s" directory is not writable.', $dir));
            }

            $outputDir = $dir;
        } else {
            (new Filesystem())->mkdir($outputDir);
            $outputDir = realpath($outputDir);
            if (!$outputDir) {
                throw new \InvalidArgumentException(sprintf('The "%s" directory cannot be created.', $outputDir));
            }
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

            if (false === ($configContent = file_get_contents($configArgument))) {
                throw new \RuntimeException(sprintf('Cannot read "%s" content.', $configArgument));
            }
        } elseif (is_readable(self::DEFAULT_CONFIG_FILE)) {
            if (false === ($configContent = file_get_contents(self::DEFAULT_CONFIG_FILE))) {
                throw new \RuntimeException(sprintf('Cannot read "%s" content.', self::DEFAULT_CONFIG_FILE));
            }
        } else {
            if (!$io->askQuestion(new ConfirmationQuestion('Your project has no config file. The entire vocabulary will be imported.'.\PHP_EOL.'Continue?', false))) {
                return Command::SUCCESS;
            }
            $configContent = 'allTypes: true';
        }

        $configuration = $this->processConfiguration($configContent, $outputDir, $dir === $defaultOutput ? $this->namespacePrefix : null);

        (new SchemaGenerator())->generate($configuration, $output, $io);
        (new OpenApiGenerator())->generate($configuration, $configArgument ?? self::DEFAULT_CONFIG_FILE, $output, $io);

        return Command::SUCCESS;
    }

    /**
     * @return Configuration
     */
    private function processConfiguration(string $configContent, string $outputDir, ?string $defaultNamespacePrefix): array
    {
        $parser = new Parser();
        $config = $parser->parse($configContent);
        unset($parser);

        $processor = new Processor();
        $configuration = new SchemaGeneratorConfiguration($defaultNamespacePrefix);
        /** @var Configuration $processedConfiguration */
        $processedConfiguration = $processor->processConfiguration($configuration, [$config]);
        $processedConfiguration['output'] = $outputDir;
        if (!$processedConfiguration['output']) {
            throw new \RuntimeException('The specified output is invalid.');
        }

        return $processedConfiguration;
    }
}
