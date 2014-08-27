<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use SchemaOrgModel\Command\ExtractCardinalitiesCommand;
use SchemaOrgModel\Command\DumpConfigurationCommand;
use SchemaOrgModel\Command\GenerateTypesCommand;

define('SCHEMA_ORG_RDFA_URL', 'https://raw.githubusercontent.com/rvguha/schemaorg/master/data/schema.rdfa');
define('GOOD_RELATIONS_OWL_URL', 'http://purl.org/goodrelations/v1.owl');

$application = new Application();
$application->add(new ExtractCardinalitiesCommand());
$application->add(new DumpConfigurationCommand());
$application->add(new GenerateTypesCommand());
$application->run();
