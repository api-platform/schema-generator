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
        $uses = [];

        foreach($this->getTypeProperties($className) as $property => $values) {
            if ($values['range']) {
                if ($this->isTypeNamespaceClassDefined($values['range'])) {
                    $uses[] = $this->getTypeNamespaceClass($values['range']).'\\'.$values['range'];
                } else {
                    $uses[] = $this->getGlobalNamespaceClass().'\\'.$values['range'];
                }
            }
        }

        return $uses;
    }

    /**
     * Returns global PHP namespace of generated entities
     *
     * @return null
     */
    private function getGlobalNamespaceClass()
    {
        if (isset($this->config['namespaces']['entity'])) {
            return $this->config['namespaces']['entity'];
        }

        return null;
    }

    /**
     * Whether or not a namespace's class is defined for the current type
     *
     * @param string $type
     *
     * @return bool
     */
    private function isTypeNamespaceClassDefined($type)
    {
        if (isset($this->config['types'][$type]['namespaces']['class'])) {
            return true;
        }

        return false;
    }

    /**
     * Returns the defined namespace of the current type
     *
     * @param string $type
     *
     * @return string|null
     */
    private function getTypeNamespaceClass($type)
    {
        if ($this->isTypeNamespaceClassDefined($type)) {
            return $this->config['types'][$type]['namespaces']['class'];
        }

        return null;
    }

    /**
     * Returns the properties of the current type
     *
     * @param string $type
     *
     * @return array
     */
    private function getTypeProperties($type)
    {
        if (isset($this->config['types'][$type]['properties'])) {
            return $this->config['types'][$type]['properties'];
        }

        return [];
    }
}
