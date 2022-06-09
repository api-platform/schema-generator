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

use ApiPlatform\SchemaGenerator\Model\Constant as BaseConstant;

final class Constant extends BaseConstant
{
    private ?string $comment = null;
    private string $value;

    public function __construct(string $name, string $value)
    {
        parent::__construct($name);

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function comment(): string
    {
        return (string) $this->comment;
    }
}
