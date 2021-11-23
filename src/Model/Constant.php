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

use EasyRdf\Resource as RdfResource;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Constant as NetteConstant;

final class Constant
{
    private string $name;
    private RdfResource $resource;
    /** @var array<string> */
    private array $annotations = [];

    public function __construct(string $name, RdfResource $resource)
    {
        $this->name = $name;
        $this->resource = $resource;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function comment(): string
    {
        return (string) $this->resource->get('rdfs:comment');
    }

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
            ->setValue($this->resource->getUri())
            ->setVisibility(ClassType::VISIBILITY_PUBLIC);

        foreach ($this->annotations as $annotation) {
            $constant->addComment($annotation);
        }

        return $constant;
    }
}
