<?php

/*
 * This file is part of the schema-generator.
 *
 * (c) Youssef El Montaser <youssef@elmontaser.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

/**
 * Symfony Serializer Groups annotation generator.
 *
 * @author Youssef El Montaser <youssef@elmontaser.com>
 *
 * @link https://symfony.com/doc/master/components/serializer.html
 */
class SerializerGroupsAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        $annotations = [];

        $properties = $this->config['types'][$className]['properties'];

        if ($this->classes[$className]['fields'][$fieldName]['isId'] == false && $groups = $properties[$fieldName]['groups']) {
            $annotations[] = sprintf('@Groups({"%s"})', implode('","', $groups));
        }

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        return ['Symfony\Component\Serializer\Annotation\Groups'];
    }
}
