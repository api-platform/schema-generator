<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
