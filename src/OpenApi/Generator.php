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

namespace ApiPlatform\SchemaGenerator\OpenApi;

use ApiPlatform\SchemaGenerator\FilesGenerator;
use ApiPlatform\SchemaGenerator\Printer;
use ApiPlatform\SchemaGenerator\TwigBuilder;
use cebe\openapi\Reader as OpenApiReader;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\String\Inflector\EnglishInflector;

final class Generator
{
    /**
     * @param Configuration $configuration
     */
    public function generate(array $configuration, string $configurationPath, OutputInterface $output, SymfonyStyle $io): void
    {
        if (!$openApiFile = $configuration['openApi']['file']) {
            return;
        }
        $configurationDirectory = Path::getDirectory($configurationPath);
        $openApiFilePath = Path::join($configurationDirectory, $openApiFile);
        if (!$openApiFileRealPath = realpath($openApiFilePath)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" isn\'t readable.', $openApiFilePath));
        }
        $extension = Path::getExtension($openApiFileRealPath);
        if ('json' === $extension) {
            $openApi = OpenApiReader::readFromJsonFile($openApiFileRealPath);
        } else {
            $openApi = OpenApiReader::readFromYamlFile($openApiFileRealPath);
        }

        $inflector = new EnglishInflector();

        $logger = new ConsoleLogger($output);

        $classGenerator = new ClassGenerator($inflector, new PhpTypeConverter());
        $classGenerator->setLogger($logger);
        $classes = $classGenerator->generate($openApi, $configuration);

        $twig = (new TwigBuilder())->build($configuration);

        $filesGenerator = new FilesGenerator($inflector, new Printer(), $twig, $io);
        $filesGenerator->setLogger($logger);
        $filesGenerator->generate($classes, $configuration);
    }
}
