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
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use EasyRdf\Graph as RdfGraph;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Extracts cardinalities.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class ExtractCardinalitiesCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('extract-cardinalities')
            ->setDescription('Extract properties\' cardinality')
            ->addOption('vocabulary-file', 's', InputOption::VALUE_REQUIRED, 'The path or URL of the vocabulary RDF file to use.', SchemaGeneratorConfiguration::SCHEMA_ORG_URI)
            ->addOption('cardinality-file', 'g', InputOption::VALUE_REQUIRED, 'The path or URL of the OWL file containing the cardinality definitions.', SchemaGeneratorConfiguration::GOOD_RELATIONS_URI)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $vocabFile = $input->getOption('vocabulary-file');

        $relations = [];
        $graph = new RdfGraph();

        $format = pathinfo($vocabFile, \PATHINFO_EXTENSION) ?: 'guess';
        if (str_starts_with($vocabFile, 'http://') || str_starts_with($vocabFile, 'https://')) {
            $graph->load($input->getOption('vocabulary-file'), $format);
        } else {
            $graph->parseFile($input->getOption('vocabulary-file'), $format);
        }

        $relations[] = $graph;

        $cardinality = [new \SimpleXMLElement($input->getOption('cardinality-file'), 0, true)];

        $goodRelationsBridge = new GoodRelationsBridge($cardinality);
        $cardinalitiesExtractor = new CardinalitiesExtractor($goodRelationsBridge);
        $result = $cardinalitiesExtractor->extract($relations);

        $output->writeln(json_encode($result, \JSON_THROW_ON_ERROR | \JSON_PRETTY_PRINT));

        return 0;
    }
}
