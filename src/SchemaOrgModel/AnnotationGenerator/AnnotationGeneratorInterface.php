<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\AnnotationGenerator;

use Psr\Log\LoggerInterface;

/**
 * Annotation generator interface
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AnnotationGeneratorInterface
{
    /**
     * @param LoggerInterface $logger
     * @param \EasyRdf_Graph  $schemaOrg
     * @param array           $cardinalities
     * @param array           $config
     */
    public function __construct(LoggerInterface $logger, \EasyRdf_Graph $schemaOrg, array $cardinalities, array $config);

    /**
     * Generates class's annotation
     *
     * @param  \EasyRdf_Resource $class
     * @return array
     */
    public function generateClassAnnotations(\EasyRdf_Resource $class);

    /**
     * @param  \EasyRdf_Resource $class
     * @param  \EasyRdf_Resource $instance
     * @param  string            $name
     * @return array
     */
    public function generateConstantAnnotations(\EasyRdf_Resource $class, \EasyRdf_Resource $instance, $name);

    /**
     * Generates field's annotation
     *
     * @param  \EasyRdf_Resource $class
     * @param  \EasyRdf_Resource $field
     * @param  string            $range
     * @return array
     */
    public function generateFieldAnnotations(\EasyRdf_Resource $class, \EasyRdf_Resource $field, $range);

    /**
     * Generates uses
     *
     * @param  \EasyRdf_Resource $class
     * @return array
     */
    public function generateUses(\EasyRdf_Resource $class);
}
