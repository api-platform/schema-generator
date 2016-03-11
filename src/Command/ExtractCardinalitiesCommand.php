<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator\Command;

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\GoodRelationsBridge;
use ApiPlatform\SchemaGenerator\TypesGeneratorConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Extract cardinality command.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ExtractCardinalitiesCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('extract-cardinalities')
            ->setDescription('Extract properties\' cardinality');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $relations = [];
        $schemaOrg = new \EasyRdf_Graph();
        $schemaOrg->load(TypesGeneratorConfiguration::SCHEMA_ORG_RDFA_URL, 'rdfa');
        $relations[] = $schemaOrg;

        $goodRelations = [new \SimpleXMLElement(TypesGeneratorConfiguration::GOOD_RELATIONS_OWL_URL, 0, true)];

        $goodRelationsBridge = new GoodRelationsBridge($goodRelations);
        $cardinalitiesExtractor = new CardinalitiesExtractor($relations, $goodRelationsBridge);
        $result = $cardinalitiesExtractor->extract();

        $output->writeln(json_encode($result, JSON_PRETTY_PRINT));
    }
}
