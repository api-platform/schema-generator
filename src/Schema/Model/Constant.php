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

use ApiPlatform\SchemaGenerator\Model\Constant as BaseConstant;
use EasyRdf\Resource as RdfResource;

final class Constant extends BaseConstant
{
    private RdfResource $resource;

    public function __construct(string $name, RdfResource $resource)
    {
        parent::__construct($name);

        $this->resource = $resource;
    }

    public function comment(): string
    {
        return (string) $this->resource->get('rdfs:comment');
    }

    public function value(): string
    {
        return $this->resource->getUri();
    }
}
