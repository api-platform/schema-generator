<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\AnnotationGenerator;

use SchemaOrgModel\CardinalitiesExtractor;

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
    public function generateClassAnnotations($className)
    {
        return empty($this->config['types']) || null === $this->config['types'][$className]['doctrine']['inheritanceMapping'] ? $this->guessInheritanceMapping($className) : $this->config['types'][$className]['doctrine']['inheritanceMapping'];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName, $range)
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
            switch ($this->cardinalities[$fieldName]) {
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
    public function generateUses($className)
    {
        return ['use Doctrine\ORM\Mapping as ORM;'];
    }

    /**
     * Guesses inheritance mapping
     *
     * @param  string $className
     * @return array
     */
    private function guessInheritanceMapping($className)
    {
        return empty($this->schemaOrg->types->$className->subtypes) ? ['@ORM\Entity'] : ['@ORM\MappedSuperclass'];
    }
}
