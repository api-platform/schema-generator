<?php

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
        if (!in_array($annotation, $this->annotations, true)) {
            $this->annotations[] = $annotation;
        }

        return $this;
    }

    public function toNetteConstant(): NetteConstant
    {
        $netteConstant = (new NetteConstant($this->name))
            ->setValue($this->resource->getUri())
            ->setVisibility(ClassType::VISIBILITY_PUBLIC);

        foreach ($this->annotations as $annotation) {
            $netteConstant->addComment($annotation);
        }

        return $netteConstant;
    }
}
