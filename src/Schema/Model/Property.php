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

use ApiPlatform\SchemaGenerator\Model\Property as BaseProperty;
use EasyRdf\Resource as RdfResource;

final class Property extends BaseProperty
{
    public ?RdfResource $resource = null;

    public ?RdfResource $range = null;

    public ?string $rangeName = null;

    public function description(): ?string
    {
        if ($this->resource && $comment = $this->resource->get('rdfs:comment')) {
            return (string) $comment;
        }

        return null;
    }

    public function rdfType(): ?string
    {
        if ($this->resource) {
            return $this->resource->getUri();
        }

        return null;
    }
}
