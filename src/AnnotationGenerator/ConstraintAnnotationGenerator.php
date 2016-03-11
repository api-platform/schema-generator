<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

/**
 * Constraint annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ConstraintAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        $field = $this->classes[$className]['fields'][$fieldName];

        if ($field['isId']) {
            return [];
        }

        $asserts = [];
        if (!$field['isArray']) {
            switch ($field['range']) {
                case 'URL':
                    $asserts[] = '@Assert\Url';
                    break;

                case 'Date':
                    $asserts[] = '@Assert\Date';
                    break;

                case 'DateTime':
                    $asserts[] = '@Assert\DateTime';
                    break;

                case 'Time':
                    $asserts[] = '@Assert\Time';
                    break;
            }

            if (isset($field['resource']) && 'email' === $field['resource']->localName()) {
                $asserts[] = '@Assert\Email';
            }

            if (empty($asserts)) {
                $phpType = $this->toPhpType($field);
                if (in_array($phpType, ['boolean', 'float', 'integer', 'string'])) {
                    $asserts[] = sprintf('@Assert\Type(type="%s")', $phpType);
                }
            }
        }

        if (!$field['isNullable']) {
            $asserts[] = '@Assert\NotNull';
        }

        if ($field['isEnum']) {
            $assert = sprintf('@Assert\Choice(callback={"%s", "toArray"}', $field['range']);

            if ($field['isArray']) {
                $assert .= ', multiple=true';
            }

            $assert .= ')';

            $asserts[] = $assert;
        }

        return $asserts;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        if ($this->classes[$className]['isEnum']) {
            return [];
        }

        $uses = [];
        $uses[] = 'Symfony\Component\Validator\Constraints as Assert';
        $uses[] = 'Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity';

        foreach ($this->classes[$className]['fields'] as $field) {
            if ($field['isEnum']) {
                $enumClass = $this->classes[$field['range']];
                $enumNamespace = isset($enumClass['namespaces']['class']) && $enumClass['namespaces']['class'] ? $enumClass['namespaces']['class'] : $this->config['namespaces']['enum'];
                $use = sprintf('%s\%s', $enumNamespace, $field['range']);

                if (!in_array($use, $uses)) {
                    $uses[] = $use;
                }
            }
        }

        return $uses;
    }

    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations($className)
    {
        if ($this->classes[$className]['isEnum']) {
            return [];
        }

        $annotation = [];
        $uniqueFields = [];

        foreach ($this->classes[$className]['fields'] as $field) {
            if (false === $field['isUnique']) {
                continue;
            }

            $uniqueFields[] = $field['name'];
        }

        if (0 === count($uniqueFields)) {
            return [];
        }

        if (1 === count($uniqueFields)) {
            $annotation[] = sprintf('@UniqueEntity("%s")', $uniqueFields[0]);
        } else {
            $annotation[] = sprintf('@UniqueEntity(fields={"%s"})', implode('","', $uniqueFields));
        }

        return $annotation;
    }
}
