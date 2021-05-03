<?php

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator\Model;

use EasyRdf\Resource as RdfResource;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\Property as NetteProperty;

final class Property
{
    public string $name;
    public ?RdfResource $resource = null;
    public string $cardinality;
    public $range;
    public $rangeName;
    public ?string $ormColumn = null;
    public bool $isArray = false;
    public bool $isReadable = true;
    public bool $isWritable = true;
    public bool $isNullable = true;
    public bool $isUnique = false;
    public bool $isCustom = false;
    public bool $isEmbedded = false;
    public ?string $mappedBy = null;
    public ?string $inversedBy = null;
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

    public function adderAnnotations(): array
    {
        return $this->adderAnnotations;
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

    public function toNetteProperty(string $visibility = null, bool $useDoctrineCollections = true): NetteProperty
    {
        $netteProperty = (new NetteProperty($this->name))
            ->setVisibility($visibility ?? ClassType::VISIBILITY_PRIVATE);

        if ($this->typeHint) {
            $netteProperty->setType($this->typeHint);
        }

        if (!$this->isArray || $this->isTypehintedAsCollection()) {
            $netteProperty->setNullable($this->isNullable);
        }

        if (($default = $this->guessDefaultGeneratedValue($useDoctrineCollections)) !== -1) {
            $netteProperty->setValue($default);
        }

        foreach ($this->annotations as $annotation) {
            $netteProperty->addComment($annotation);
        }

        return $netteProperty;
    }

    public function generateNetteMethods(
        \Closure $singularize,
        bool $useDoctrineCollections = true,
        bool $useFluentMutators = false
    ): array {
        return array_merge(
            $this->generateMutators($singularize, $useDoctrineCollections, $useFluentMutators),
            $this->isReadable ? [$this->generateGetter()] : []
        );
    }

    private function generateGetter(): Method
    {
        if (!$this->isReadable) {
            throw new \LogicException(sprintf("Property '%s' is not readable.", $this->name));
        }

        $getter = (new Method("get" . ucfirst($this->name)))->setVisibility(ClassType::VISIBILITY_PUBLIC);
        foreach ($this->getterAnnotations as $annotation) {
            $getter->addComment($annotation);
        }
        if ($this->typeHint) {
            $getter->setReturnType($this->typeHint);
            if ($this->isNullable && !$this->isArray) {
                $getter->setReturnNullable();
            }
        }
        $getter->setBody('return $this->?;', [$this->name()]);

        return $getter;
    }

    private function generateMutators(
        \Closure $singularize,
        bool $useDoctrineCollections = true,
        bool $useFluentMutators = false
    ): array {
        if (!$this->isWritable) {
            return [];
        }

        $mutators = [];
        if ($this->isArray) {
            $singularProperty = $singularize($this->name());

            $adder = (new Method("add" . ucfirst($singularProperty)))->setVisibility(ClassType::VISIBILITY_PUBLIC);
            $adder->setReturnType($useFluentMutators ? "self" : "void");
            foreach ($this->adderAnnotations() as $annotation) {
                $adder->addComment($annotation);
            }
            $parameter = $adder->addParameter($singularProperty);
            if ($this->typeHint && !$this->isEnum) {
                $parameter->setType($this->adderRemoverTypeHint);
            }
            $adder->addBody(
                sprintf('$this->%s[] = %s;', $this->name(), ($this->isEnum ? "(string) " : "") . "$$singularProperty")
            );
            if ($useFluentMutators) {
                $adder->addBody("");
                $adder->addBody('return $this;');
            }
            $mutators[] = $adder;

            $remover = (new Method("remove" . ucfirst($singularProperty)))->setVisibility(ClassType::VISIBILITY_PUBLIC);
            $remover->setReturnType($useFluentMutators ? "self" : "void");
            foreach ($this->removerAnnotations as $annotation) {
                $adder->addComment($annotation);
            }
            $parameter = $remover->addParameter($singularProperty);
            if ($this->typeHint) {
                $parameter->setType($this->adderRemoverTypeHint);
            }
            if ($useDoctrineCollections && $this->isArray && $this->typeHint && $this->typeHint !== 'array' && !$this->isEnum) {
                $remover->addBody(sprintf(
                    '$this->%s->removeElement(%s);',
                    $this->name(),
                    $this->isEnum ? "(string) $$singularProperty" : "$$singularProperty"
                ));
            } else {
                $remover->addBody(sprintf(<<<'PHP'
if (false !== $key = array_search(%s, %s, true)) {
    unset($this->%s[$key]);
}
PHP,
                    ($this->isEnum ? "(string)" : "") . "$".$singularProperty, '$this->'.$this->name() . ($this->isNullable ? " ?? []" : ""), $this->name()));
            }

            if ($useFluentMutators) {
                $remover->addBody("");
                $remover->addBody('return $this;');
            }

            $mutators[] = $remover;
        } else {
            $setter = (new Method("set" . ucfirst($this->name())))->setVisibility(ClassType::VISIBILITY_PUBLIC);
            $setter->setReturnType($useFluentMutators ? "self" : "void");
            foreach ($this->setterAnnotations as $annotation) {
                $setter->addComment($annotation);
            }
            $setter->addParameter($this->name())
                   ->setType($this->typeHint)
                   ->setNullable($this->isNullable);

            $setter->addBody('$this->? = $?;', [$this->name(), $this->name()]);
            if ($useFluentMutators) {
                $setter->addBody("");
                $setter->addBody('return $this;');
            }
            $mutators[] = $setter;
        }

        return $mutators;
    }

    private function guessDefaultGeneratedValue(bool $useDoctrineCollections = true)
    {
        if ($this->isArray && !$this->isTypehintedAsCollection() && ($this->isEnum || !$this->typeHint || $this->typeHint === 'array' || !$useDoctrineCollections)) {
            return [];
        }

        if ($this->isNullable) {
            return null;
        }

        return -1;
    }

    private function isTypehintedAsCollection(): bool
    {
        return $this->typeHint === 'Collection';
    }
}
