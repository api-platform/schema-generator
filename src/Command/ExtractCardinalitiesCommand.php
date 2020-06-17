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
use ApiPlatform\SchemaGenerator\TypesGeneratorConfiguration;
use EasyRdf\Graph;
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
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('extract-cardinalities')
            ->setDescription('Extract properties\' cardinality')
            ->addOption('schemaorg-file', 's', InputOption::VALUE_REQUIRED, 'The path or URL of the Schema.org RDF file to use.', TypesGeneratorConfiguration::SCHEMA_ORG_URI)
            ->addOption('goodrelations-file', 'g', InputOption::VALUE_REQUIRED, 'The path or URL of the GoodRelations OWL file to use.', TypesGeneratorConfiguration::GOOD_RELATIONS_URI)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schemaOrgFile = $input->getOption('schemaorg-file');

        $relations = [];
        $schemaOrg = new Graph();

        $format = pathinfo($schemaOrgFile, PATHINFO_EXTENSION) ?: 'guess';
        if (0 === strpos($schemaOrgFile, 'http://') || 0 === strpos($schemaOrgFile, 'https://')) {
            $schemaOrg->load($input->getOption('schemaorg-file'), $format);
        } else {
            $schemaOrg->parseFile($input->getOption('schemaorg-file'), $format);
        }

        $relations[] = $schemaOrg;

        $goodRelations = [new \SimpleXMLElement($input->getOption('goodrelations-file'), 0, true)];

        $goodRelationsBridge = new GoodRelationsBridge($goodRelations);
        $cardinalitiesExtractor = new CardinalitiesExtractor($relations, $goodRelationsBridge);
        $result = $cardinalitiesExtractor->extract();

        $output->writeln(json_encode($result, JSON_PRETTY_PRINT));

        return 0;
    }
}
