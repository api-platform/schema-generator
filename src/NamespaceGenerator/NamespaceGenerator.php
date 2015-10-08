<?php

/*
 * (c) Sidney Curron <ceednee@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace ApiPlatform\SchemaGenerator\NamespaceGenerator;

use Psr\Log\LoggerInterface;

/**
 * Namespace Generator
 *
 * @author Sidney Curron <ceednee@gmail.com>
 */
class NamespaceGenerator extends AbstractNamespaceGenerator
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        LoggerInterface $logger,
        array $graphs,
        array $cardinalities,
        array $config,
        array $classes
    ) {
        parent::__construct($logger, $graphs, $cardinalities, $config, $classes);
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        echo 'classname => ' . $className . "\n";

        $uses = [];

        foreach($this->getClassProperties($className) as $property => $values) {
            if ($values['range']) {
                $uses[] = $this->getClassNameSpace($values['range']);
            }
        }

        return $uses;
    }

    /**
     * @param $className
     *
     * @return mixed
     */
    private function getClassNameSpace($className)
    {
        return $this->config['types'][$className]['namespaces']['class'].'\\'.$className;;
    }

    /**
     * @param $className
     *
     * @return mixed
     */
    private function getClassProperties($className)
    {
        return $this->config['types'][$className]['properties'];
    }
}
