<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\Command;

use SchemaOrgModel\Config\EntitiesGeneratorConfiguration;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Dump configuration command
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DumpConfigurationCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('schema:dump-configuration')
            ->setDescription('Dump configuration')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configuration = new EntitiesGeneratorConfiguration();
        $dumper = new YamlReferenceDumper();
        $output->writeln($dumper->dump($configuration));
    }
}
