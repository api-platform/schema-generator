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

namespace ApiPlatform\SchemaGenerator\OpenApi\Model;

use ApiPlatform\SchemaGenerator\Model\Class_ as BaseClass_;

final class Class_ extends BaseClass_
{
    private ?string $description = null;

    private ?string $rdfType = null;

    public function description(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function rdfType(): ?string
    {
        return $this->rdfType;
    }

    public function setRdfType(string $rdfType): void
    {
        $this->rdfType = $rdfType;
    }

    public function shortName(): string
    {
        return $this->name;
    }

    public function isEnum(): bool
    {
        return false;
    }
}
