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
     * @param \stdClass       $schemaOrg
     * @param array           $cardinalities
     * @param array           $config
     */
    public function __construct(LoggerInterface $logger, \stdClass $schemaOrg, array $cardinalities, array $config);

    /**
     * Generates class's annotation
     *
     * @param  string $className
     * @return array
     */
    public function generateClassAnnotations($className);

    /**
     * Generates field's annotation
     *
     * @param  string $className
     * @param  string $fieldName
     * @param  string $range
     * @return array
     */
    public function generateFieldAnnotations($className, $fieldName, $range);

    /**
     * Generates uses
     *
     * @param  string $className
     * @return array
     */
    public function generateUses($className);
}
