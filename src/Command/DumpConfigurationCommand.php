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

use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Dump configuration command.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class DumpConfigurationCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('dump-configuration')
            ->setDescription('Dump configuration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configuration = new SchemaGeneratorConfiguration();
        $dumper = new YamlReferenceDumper();
        $output->writeln($dumper->dump($configuration));

        return 0;
    }
}
