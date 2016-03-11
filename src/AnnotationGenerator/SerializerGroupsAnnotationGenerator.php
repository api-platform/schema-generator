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

        if (false === $this->classes[$className]['fields'][$fieldName]['isId'] && $groups = $properties[$fieldName]['groups']) {
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
