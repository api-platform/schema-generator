<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\Command;

use SchemaOrgModel\EntitiesGenerator;
use SchemaOrgModel\Logger\ConsoleLogger;
use SchemaOrgModel\Config\EntitiesGeneratorConfiguration;
use SchemaOrgModel\GoodRelationsBridge;
use SchemaOrgModel\CardinalitiesExtractor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;

/**
 * Generate entities command
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class GenerateEntitiesCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('schema:generate-entities')
            ->setDescription('Generate entities')
            ->addArgument('output', InputArgument::REQUIRED, 'The output directory')
            ->addArgument('config', InputArgument::OPTIONAL, 'The config file to use')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $input->getArgument('config') ? Yaml::parse($input->getArgument('config')) : [];

        $processor = new Processor();
        $configuration = new EntitiesGeneratorConfiguration();
        $processedConfiguration = $processor->processConfiguration($configuration, [$config]);
        $processedConfiguration['output'] = realpath($input->getArgument('output'));
        if (!$processedConfiguration['output']) {
            throw new \RuntimeException('The specified output is invalid');
        }

        $schemaOrg = json_decode(file_get_contents(SCHEMA_ORG_JSON_ALL_URL));
        $goodRelations = new \SimpleXMLElement(GOOD_RELATIONS_OWL_URL, 0, true);

        $goodRelationsBridge = new GoodRelationsBridge($goodRelations);
        $cardinalitiesExtractor = new CardinalitiesExtractor($schemaOrg, $goodRelationsBridge);

        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../../templates/');
        $twig = new \Twig_Environment($loader, ['autoescape' => false, 'debug' => $processedConfiguration['debug']]);
        if ($processedConfiguration['debug']) {
            $twig->addExtension(new \Twig_Extension_Debug());
        }

        $logger = new ConsoleLogger($output);

        $entitiesGenerator = new EntitiesGenerator($twig, $logger, $schemaOrg, $cardinalitiesExtractor, $goodRelationsBridge, $processedConfiguration);
        $entitiesGenerator->generate();
    }
}
