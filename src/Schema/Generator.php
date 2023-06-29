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

namespace ApiPlatform\SchemaGenerator\Schema;

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\FilesGenerator;
use ApiPlatform\SchemaGenerator\GoodRelationsBridge;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Printer;
use ApiPlatform\SchemaGenerator\TwigBuilder;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use EasyRdf\Graph as RdfGraph;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Inflector\EnglishInflector;

final class Generator
{
    /**
     * @param Configuration $configuration
     */
    public function generate(array $configuration, OutputInterface $output, SymfonyStyle $io): void
    {
        $graphs = [];
        foreach ($configuration['vocabularies'] as $uri => $vocab) {
            $graph = new RdfGraph($uri);
            if (str_starts_with($uri, 'http://') || str_starts_with($uri, 'https://')) {
                $graph->load($uri, $vocab['format']);
            } else {
                $graph->parseFile($uri, $vocab['format']);
            }

            $graphs[] = $graph;
        }

        $relationsUris = $configuration['relations']['uris'];
        $relations = [];
        foreach ($relationsUris as $relation) {
            $relations[] = new \SimpleXMLElement($relation, 0, true);
        }

        $goodRelationsBridge = new GoodRelationsBridge($relations);
        $cardinalitiesExtractor = new CardinalitiesExtractor($goodRelationsBridge);

        $inflector = new EnglishInflector();

        $logger = new ConsoleLogger($output);

        $entitiesGenerator = new TypesGenerator(
            $inflector,
            new PhpTypeConverter(),
            $cardinalitiesExtractor,
            $goodRelationsBridge
        );
        $entitiesGenerator->setLogger($logger);

        $classes = $entitiesGenerator->generate($graphs, $configuration);

        $twig = (new TwigBuilder())->build($configuration);

        $filesGenerator = new FilesGenerator($inflector, new Printer(), $twig, $io);
        $filesGenerator->setLogger($logger);
        $filesGenerator->generate($classes, $configuration);
    }
}
