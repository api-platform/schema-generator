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

namespace ApiPlatform\SchemaGenerator\Schema\Model;

use ApiPlatform\SchemaGenerator\Model\Class_ as BaseClass_;
use EasyRdf\Resource as RdfResource;

final class Class_ extends BaseClass_
{
    private RdfResource $resource;

    private const SCHEMA_ORG_ENUMERATION = 'https://schema.org/Enumeration';

    /**
     * @param false|string|null $parent
     */
    public function __construct(string $name, RdfResource $resource, $parent = null)
    {
        parent::__construct($name, $parent);

        $this->resource = $resource;
    }

    public function resource(): RdfResource
    {
        return $this->resource;
    }

    public function rdfType(): string
    {
        return $this->resource->getUri();
    }

    public function description(): ?string
    {
        $comment = $this->resource->get('rdfs:comment');

        return $comment ? (string) $comment : null;
    }

    public function shortName(): string
    {
        if (\is_string($shortName = $this->resource->localName())) {
            return $shortName;
        }

        return $this->name();
    }

    /**
     * @return RdfResource[]
     */
    public function getSubClassOf(): array
    {
        return array_filter($this->resource->all('rdfs:subClassOf', 'resource'), static fn (RdfResource $resource) => !$resource->isBNode());
    }

    public function isEnum(RdfResource $resource = null): bool
    {
        $parentClass = ($resource ?? $this->resource)->get('rdfs:subClassOf');

        return $parentClass && (self::SCHEMA_ORG_ENUMERATION === $parentClass->getUri() || $this->isEnum($parentClass));
    }
}
