<?php

namespace ApiPlatform\SchemaGenerator\Model;

use EasyRdf\Resource as RdfResource;

final class Property
{
    //TODO-WRLSS iterate on public properties and missing typehints
    public string $name;
    public ?RdfResource $resource = null;
    public string $cardinality;
    public $range;
    public $rangeName;
    public $ormColumn = null;
    public bool $isArray = false;
    public bool $isReadable = true;
    public bool $isWritable;
    public bool $isNullable;
    public bool $isUnique = false;
    public bool $isCustom = false;
    public bool $isEmbedded = false;
    public $mappedBy;
    public $inversedBy;
    public $columnPrefix = false;
    public bool $isId = false;
    public ?string $typeHint = null;
    public ?string $relationTableName = null;
    public bool $isEnum = false;
    public ?string $adderRemoverTypeHint = null;
    private array $annotations = [];
    private array $getterAnnotations = [];
    private array $setterAnnotations = [];
    private array $adderAnnotations = [];
    private array $removerAnnotations = [];
    private array $groups = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function addAnnotation(string $annotation): self
    {
        if ($annotation === '' || !in_array($annotation, $this->annotations, true)) {
            $this->annotations[] = $annotation;
        }

        return $this;
    }

    public function addGetterAnnotation(string $annotation): self
    {
        if ($annotation === '' || !in_array($annotation, $this->getterAnnotations, true)) {
            $this->getterAnnotations[] = $annotation;
        }

        return $this;
    }

    public function addSetterAnnotation(string $annotation): self
    {
        if ($annotation === '' || !in_array($annotation, $this->setterAnnotations, true)) {
            $this->setterAnnotations[] = $annotation;
        }

        return $this;
    }

    public function addAdderAnnotation(string $annotation): self
    {
        if ($annotation === '' || !in_array($annotation, $this->adderAnnotations, true)) {
            $this->adderAnnotations[] = $annotation;
        }

        return $this;
    }

    public function addRemoverAnnotation(string $annotation): self
    {
        if ($annotation === '' || !in_array($annotation, $this->removerAnnotations, true)) {
            $this->removerAnnotations[] = $annotation;
        }

        return $this;
    }

    public function groups(): array
    {
        return $this->groups;
    }

    public function resourceUri(): ?string
    {
        return $this->resource ? $this->resource->getUri() : null;
    }

    public function markAsCustom(): self
    {
        $this->isCustom = true;

        return $this;
    }

    public function asTwigParameters(): array
    {
        return [
            'name' => $this->name,
            'resource' => $this->resource,
            'rangeName' => $this->rangeName,
            'range' => $this->range,
            'cardinality' => $this->cardinality,
            'ormColumn' => $this->ormColumn,
            'isArray' => $this->isArray,
            'annotations' => [...$this->annotations],
            'getterAnnotations' => [...$this->getterAnnotations],
            'setterAnnotations' => [...$this->setterAnnotations],
            'adderAnnotations' => [...$this->adderAnnotations],
            'removerAnnotations' => [...$this->removerAnnotations],
            'isReadable' => $this->isReadable,
            'isWritable' => $this->isWritable,
            'isNullable' => $this->isNullable,
            'isUnique' => $this->isUnique,
            'isCustom' => $this->isCustom,
            'isEmbedded' => $this->isEmbedded,
            'columnPrefix' => $this->columnPrefix,
            'mappedBy' => $this->mappedBy,
            'inversedBy' => $this->inversedBy,
            'isId' => $this->isId,
            'isEnum' => $this->isEnum,
            'typeHint' => $this->typeHint,
            'adderRemoverTypeHint' => $this->adderRemoverTypeHint,
        ];
    }
}
