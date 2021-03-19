<?php

namespace ApiPlatform\SchemaGenerator\Model;

use EasyRdf\Resource as RdfResource;

final class Constant
{
    private string $name;
    private RdfResource $resource;
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

    public function resourceUri(): string
    {
        return $this->resource->getUri();
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

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'resource' => $this->resource,
            'value' => $this->resourceUri(),
            'annotations' => [...$this->annotations],
        ];
    }
}
