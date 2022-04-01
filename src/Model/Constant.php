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

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Constant as NetteConstant;

abstract class Constant
{
    private string $name;
    /** @var array<string> */
    private array $annotations = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    abstract public function value(): string;

    abstract public function comment(): string;

    public function addAnnotation(string $annotation): self
    {
        if (!\in_array($annotation, $this->annotations, true)) {
            $this->annotations[] = $annotation;
        }

        return $this;
    }

    public function toNetteConstant(): NetteConstant
    {
        $constant = (new NetteConstant($this->name))
            ->setValue($this->value())
            ->setVisibility(ClassType::VISIBILITY_PUBLIC);

        foreach ($this->annotations as $annotation) {
            $constant->addComment($annotation);
        }

        return $constant;
    }
}
