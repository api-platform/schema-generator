<?php

namespace ApiPlatform\SchemaGenerator\Model;

final class Interface_
{
    private string $name;
    private ?string $namespace;
    private array $annotations = [];

    public function __construct(string $name, string $namespace)
    {
        $this->name = $name;
        $this->namespace = $namespace;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function namespace(): ?string
    {
        return $this->namespace;
    }

    public function addAnnotation(string $annotation): self
    {
        if (\in_array($annotation, $this->annotations, true)) {
            $this->annotations[] = $annotation;
        }

        return $this;
    }

    public function annotations(): array
    {
        return $this->annotations;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'namespace' => $this->namespace,
            'annotations' => $this->annotations,
        ];
    }
}
