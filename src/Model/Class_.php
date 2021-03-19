<?php

namespace ApiPlatform\SchemaGenerator\Model;

use EasyRdf\Resource as RdfResource;
use Nette\PhpGenerator\ClassType;

final class Class_
{
    private string $name;
    private string $namespace = '';
    private ?Interface_ $interface = null;
    private array $uses = [];
    /** @var Property[] */
    private array $properties = [];
    private array $constants = [];
    private array $annotations = [];
    private array $operations = [];
    private bool $hasConstructor = false;
    private bool $parentHasConstructor = false;
    private bool $isAbstract = false;
    private bool $hasChild = false;
    private bool $embeddable = false;
    private $parent;
    private RdfResource $resource;

    private const SCHEMA_ORG_ENUMERATION = 'http://schema.org/Enumeration';

    public function __construct(string $name, RdfResource $resource, $parent = null)
    {
        $this->name = $name;
        $this->resource = $resource;
        $this->parent = $parent;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function interfaceName(): ?string
    {
        return $this->interface ? $this->interface->name() : null;
    }

    public function interfaceNamespace(): ?string
    {
        return $this->interface ? $this->interface->namespace() : null;
    }

    public function interfaceAnnotations(): array
    {
        return $this->interface ? $this->interface->annotations() : [];
    }

    public function withNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function withParent(string $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function withInterface(Interface_ $interface): self
    {
        $this->interface = $interface;

        return $this;
    }

    public function addProperty(Property $property): self
    {
        $this->properties[$property->name] = $property;

        return $this;
    }

    public function removePropertyByName(string $name): self
    {
        unset($this->properties[$name]);

        return $this;
    }

    public function getPropertyByName(string $name): ?Property
    {
        return $this->properties[$name] ?? null;
    }

    public function hasProperty(string $propertyName): bool
    {
        return isset($this->properties[$propertyName]);
    }

    public function addUse(string $use): self
    {
        if (!\in_array($use, $this->uses, true)) {
            $this->uses[] = $use;
        }

        return $this;
    }

    public function doesUse(string $class): bool
    {
        return \in_array($class, $this->uses, true);
    }

    public function addAnnotation(string $annotation): self
    {
        if ($annotation === '' || !\in_array($annotation, $this->annotations, true)) {
            $this->annotations[] = $annotation;
        }

        return $this;
    }

    public function addInterfaceAnnotation(string $annotation): self
    {
        if ($this->interface !== null) {
            $this->interface->addAnnotation($annotation);
        }

        return $this;
    }

    public function addConstant(string $key, Constant $constant): self
    {
        $this->constants[$key] = $constant;

        return $this;
    }

    /** @return Constant[] */
    public function constants(): array
    {
        return $this->constants;
    }

    public function operations(): array
    {
        return $this->operations;
    }

    public function setOperations(array $operations): self
    {
        $this->operations = $operations;

        return $this;
    }

    public function resource(): RdfResource
    {
        return $this->resource;
    }

    public function resourceUri(): string
    {
        return $this->resource->getUri();
    }

    public function parent(): ?string
    {
        return $this->parent;
    }

    public function setParent(?string $parent): void
    {
        $this->parent = $parent;
    }

    public function hasParent(): bool
    {
        return $this->parent() !== '';
    }

    public function markWithConstructor(): self
    {
        $this->hasConstructor = true;

        return $this;
    }

    public function setIsAbstract(bool $isAbstract): self
    {
        $this->isAbstract = $isAbstract;

        return $this;
    }

    public function isAbstract(): bool
    {
        return $this->isAbstract;
    }

    public function getSubClassOf(): array
    {
        return array_filter($this->resource->all('rdfs:subClassOf', 'resource'), static fn (RdfResource $resource) => !$resource->isBNode());
    }

    public function isEnum(): bool
    {
        $subClassOf = $this->resource->get('rdfs:subClassOf');

        return $subClassOf && self::SCHEMA_ORG_ENUMERATION === $subClassOf->getUri();
    }

    public function isInNamespace(string $namespace): bool
    {
        return $this->namespace === $namespace;
    }

    public function namespace(): string
    {
        return $this->namespace;
    }

    public function asTwigParameters(): array
    {
        return [
            'name' => $this->name,
            'parent' => $this->parent,
            'namespace' => $this->namespace,
            'resource' => $this->resource,
            'isEnum' => $this->isEnum(),
            'constants' => array_map(static fn (Constant $constant) => $constant->toArray(), $this->constants),
            'fields' => $this->propertiesToArray(),
            'uses' => [...$this->uses],
            'hasConstructor' => $this->hasConstructor,
            'parentHasConstructor' => $this->parentHasConstructor,
            'hasChild' => $this->hasChild,
            'abstract' => $this->isAbstract,
            'embeddable' => $this->embeddable,
            'annotations' => [...$this->annotations],
            'interfaceName' => $this->interfaceName(),
            'interfaceNamespace' => $this->interfaceNamespace(),
            'interfaceAnnotations' => $this->interfaceAnnotations(),
        ];
    }

    /** @return Property[] */
    public function properties(): array
    {
        return $this->properties;
    }

    /** @return Property[] */
    public function uniqueProperties(): array
    {
        return \array_filter($this->properties, static fn (Property $property) => $property->isUnique);
    }

    /** @return string[] */
    public function uniquePropertyNames(): array
    {
        return \array_map(static fn (Property $property) => $property->name, $this->uniqueProperties());
    }

    /**
     * @return array
     */
    private function propertiesToArray(): array
    {
        // TODO-WRLSS cleaner way to start with Id first
        $asArrays = [];
        foreach ($this->properties as $key => $property) {
            $asArrays[$key] = $property->asTwigParameters();
        }

        return isset($asArrays['id']) ? ['id' => $asArrays['id']] + $asArrays : $asArrays;
    }

    public function toNetteClassType(): ClassType
    {
        // TODO-WRLSS convert to Nette model
    }

    public function isEmbeddable(): bool
    {
        return $this->embeddable;
    }

    public function setEmbeddable(bool $embeddable): self
    {
        $this->embeddable = $embeddable;

        return $this;
    }

    public function hasChild(): bool
    {
        return $this->hasChild;
    }

    public function hasConstructor(): bool
    {
        return $this->hasConstructor;
    }

    public function markAsHasChild(): self
    {
        $this->hasChild = true;

        return $this;
    }

    public function setParentHasConstructor(bool $parentHasConstructor): self
    {
        $this->parentHasConstructor = $parentHasConstructor;

        return $this;
    }
}
