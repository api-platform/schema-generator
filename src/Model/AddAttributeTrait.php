<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator\Model;

trait AddAttributeTrait
{
    public function addAttribute(Attribute $attribute): self
    {
        if (!\in_array($attribute, $this->attributes, true)) {
            if (empty(array_filter(
                $this->attributes,
                fn (Attribute $attr) => $attr->name() === $attribute->name()
            ))) {
                $this->attributes[] = $attribute;
            } else {
                $this->attributes = array_map(
                    fn (Attribute $attr) => $attr->name() === $attribute->name()
                        ? new Attribute($attr->name(), array_merge($attribute->args(), $attr->args()))
                        : $attr,
                    $this->attributes
                );
            }
        }

        return $this;
    }
}
