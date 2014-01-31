#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use SchemaOrgModel\Command\ExtractCardinalityCommand;


define('SCHEMA_ORG_JSON_ALL_URL', 'http://schema.rdfs.org/all.json');
define('GOOD_RELATIONS_OWL_URL', 'http://purl.org/goodrelations/v1.owl');

$application = new Application();
$application->add(new ExtractCardinalityCommand());
$application->run();
