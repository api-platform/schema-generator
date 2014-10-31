<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\Command;

use SchemaOrgModel\TypesGenerator;
use SchemaOrgModel\Config\TypesGeneratorConfiguration;
use SchemaOrgModel\GoodRelationsBridge;
use SchemaOrgModel\CardinalitiesExtractor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;

/**
 * Generate entities command.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class GenerateTypesCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('schema:generate-types')
            ->setDescription('Generate types')
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
        $configuration = new TypesGeneratorConfiguration();
        $processedConfiguration = $processor->processConfiguration($configuration, [$config]);
        $processedConfiguration['output'] = realpath($input->getArgument('output'));
        if (!$processedConfiguration['output']) {
            throw new \RuntimeException('The specified output is invalid');
        }

        $graphs = [];
        foreach ($processedConfiguration['rdfa'] as $rdfa) {
            $graph = new \EasyRdf_Graph();
            $graph->load($rdfa, 'rdfa');

            $graphs[] = $graph;
        }

        $relations = [];
        foreach ($processedConfiguration['relations'] as $relation) {
            $relations[] = new \SimpleXMLElement($relation, 0, true);
        }

        $goodRelationsBridge = new GoodRelationsBridge($relations);
        $cardinalitiesExtractor = new CardinalitiesExtractor($graphs, $goodRelationsBridge);

        $ucfirstFilter = new \Twig_SimpleFilter('ucfirst', 'ucfirst');
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../../templates/');
        $twig = new \Twig_Environment($loader, ['autoescape' => false, 'debug' => $processedConfiguration['debug']]);
        $twig->addFilter($ucfirstFilter);

        if ($processedConfiguration['debug']) {
            $twig->addExtension(new \Twig_Extension_Debug());
        }

        $logger = new ConsoleLogger($output);

        $entitiesGenerator = new TypesGenerator($twig, $logger, $graphs, $cardinalitiesExtractor, $goodRelationsBridge);
        $entitiesGenerator->generate($processedConfiguration);
    }
}
