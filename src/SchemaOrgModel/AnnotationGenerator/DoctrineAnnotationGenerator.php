<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\AnnotationGenerator;

use SchemaOrgModel\CardinalitiesExtractor;
use SchemaOrgModel\TypesGenerator;

/**
 * Doctrine annotation generator
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DoctrineAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations(\EasyRdf_Resource $class)
    {
        return empty($this->config['types']) || null === $this->config['types'][$class->localName()]['doctrine']['inheritanceMapping'] ? $this->guessInheritanceMapping($class) : $this->config['types'][$class->localName()]['doctrine']['inheritanceMapping'];
    }

    /**
     * {@inheritdoc}
     */
    public function generateConstantAnnotations(\EasyRdf_Resource $class, \EasyRdf_Resource $instance, $name)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations(\EasyRdf_Resource $class, \EasyRdf_Resource $field, $range)
    {
        $annotations = [];

        switch ($range) {
            case 'Boolean':
                $type = 'boolean';
                break;
            case 'Date':
                $type = 'date';
                break;
            case 'DateTime':
                $type = 'datetime';
                break;
            case 'Time':
                $type = 'time';
                break;
            case 'Number':
                // No break
            case 'Float':
                $type = 'float';
                break;
            case 'Integer':
                $type = 'integer';
                break;
            case 'Text':
                // No break
            case 'URL':
                $type = 'string';
                break;
        }

        if (isset($type)) {
            $annotation = '@ORM\Column';

            if ($type !== 'string') {
                $annotation .= sprintf('(type="%s")', $type);
            }

            $annotations[] = $annotation;
        } else {
            switch ($this->cardinalities[$field->localName()]) {
                case CardinalitiesExtractor::CARDINALITY_0_1:
                    $annotations[] = sprintf('@ORM\OneToOne(targetEntity="%s")', $range);
                    break;

                case CardinalitiesExtractor::CARDINALITY_0_N:
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $range);
                    break;

                case CardinalitiesExtractor::CARDINALITY_1_1:
                    $annotations[] = sprintf('@ORM\OneToOne(targetEntity="%s")', $range);
                    $annotations[] = '@ORM\JoinColumn(nullable=false)';
                    break;

                case CardinalitiesExtractor::CARDINALITY_1_N:
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $range);
                    $annotations[] = '@ORM\JoinColumn(nullable=false)';
                    break;
            }
        }

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(\EasyRdf_Resource $class)
    {
        $subClassOf = $class->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && $subClassOf->getUri() === TypesGenerator::SCHEMA_ORG_ENUMERATION;

        return $typeIsEnum ? [] : ['Doctrine\ORM\Mapping as ORM'];
    }

    /**
     * Guesses inheritance mapping
     *
     * @param  \EasyRdf_Resource $class
     * @return array
     */
    private function guessInheritanceMapping(\EasyRdf_Resource $class)
    {
        // TODO : check if the given class has subtypes
        return false ? ['@ORM\Entity'] : ['@ORM\MappedSuperclass'];
    }
}
