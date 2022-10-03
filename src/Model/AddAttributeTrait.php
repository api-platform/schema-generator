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
            $previousAttribute = $this->getAttributeWithName($attribute->name());
            if (!$previousAttribute || !$previousAttribute->mergeable) {
                if ($attribute->append) {
                    $this->attributes[] = $attribute;
                }
            } else {
                $this->attributes = array_map(
                    fn (Attribute $attr) => $attr->name() === $attribute->name()
                        ? new Attribute($attr->name(), array_merge(
                            $attr->args(),
                            $attribute->args(),
                            ['mergeable' => $attribute->mergeable]
                        ))
                        : $attr,
                    $this->attributes
                );
            }
        }

        return $this;
    }

    public function getAttributeWithName(string $name): ?Attribute
    {
        return array_values(array_filter(
            $this->attributes,
            fn (Attribute $attr) => $attr->name() === $name
        ))[0] ?? null;
    }
}
