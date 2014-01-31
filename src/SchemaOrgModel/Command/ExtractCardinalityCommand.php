<?php

namespace SchemaOrgModel\Command;

use SchemaOrgModel\CardinalityExtractor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Extract cardinality command
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ExtractCardinalityCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('schema:extract-cardinality')
            ->setDescription('Extract properties\' cardinality')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $schemaOrg = json_decode(file_get_contents(SCHEMA_ORG_JSON_ALL_URL));
        $goodRelations = new \SimpleXMLElement(GOOD_RELATIONS_OWL_URL, 0, true);

        $cardinalityExtractor = new CardinalityExtractor($schemaOrg, $goodRelations);
        $result = $cardinalityExtractor->extract();

        $output->write(json_encode($result, JSON_PRETTY_PRINT));
    }
} 