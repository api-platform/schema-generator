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

namespace ApiPlatform\SchemaGenerator\Schema\Rdf;

use ApiPlatform\SchemaGenerator\SchemaGeneratorConfigurationHolder as Config;
use EasyRdf\Graph as EasyRdfGraph;
use EasyRdf\Resource as EasyRdfResource;

use function Symfony\Component\String\u;

/**
 * This class is a wrapper around the EasyRdf\Resource class. It allows the
 * Schema Generator to use the labels for the resources names instead of the
 * default "ID/local names"(URI fragment ID), if the option is choosen in config.
 * This capability impacts the PHP class names and API resource names accordingly.
 *
 * @implements \ArrayAccess<string, mixed>
 *
 * @author d3fk::Angatar
 */
class RdfResource implements \ArrayAccess
{
    private EasyRdfResource $resource;
    private ?string $resourceName = null;
    private ?string $language = null;
    private ?string $namingConvention = null;
    private bool $useLabel = false;

    /**
     * Constructor, creates the RdfResource decorating a freshly created
     * or given EasyRdf\Resource with new resource naming capabilities.
     *
     * @param EasyRdfGraph|RdfGraph|null $graph
     */
    final public function __construct(?string $uri, $graph = null, EasyRdfResource $resource = null)
    {
        $graph = ($graph instanceof RdfGraph) ? $graph->getEasyGraph() : $graph;
        $this->resource = $resource ?? new EasyRdfResource($uri, $graph);
        $this->defineResourceName(); // line only added to satisfy existing test conditions in ClassPropertiesAppenderTest::testInvoke
    }

    /**
     * Returns the resourceName or trigger to define one according to the config.
     */
    public function localName(): ?string
    {
        if (!isset($this->resourceName)) {
            $this->defineResourceName();
        }

        return $this->resourceName;
    }

    /**
     * Defines the resource name according to the config file (ID/localName or Label).
     */
    private function defineResourceName(): void
    {
        $this->applyNamingConfig();
        $this->updateResourceName();
    }

    /**
     * Applies the naming configuration from the config file to the object.
     */
    public function applyNamingConfig(): void
    {
        $graphUri = (null !== $this->getGraph()) ? $this->getGraph()->getUri() : null;
        // Uses label only if asked in config and the resource is part of a graph
        if ($this->hasGraph()
        && ((Config::$config['nameAllFromLabels'] ?? false)
            || (Config::$config['vocabularies'][$graphUri]['nameAllFromLabels'] ?? false)
            || (Config::$config['types'][$this->localId()]['nameFromLabel'] ?? false)
        )
        ) {
            $this->useLabel = true;

            $this->language = Config::$config['types'][$this->localId()]['language']
                            ?? (Config::$config['vocabularies'][$graphUri]['language']
                            ?? (Config::$config['language'] ?? $this->language));

            $this->namingConvention = Config::$config['types'][$this->localId()]['namingConvention']
                                    ?? (Config::$config['vocabularies'][$graphUri]['namingConvention']
                                    ?? (Config::$config['namingConvention'] ?? $this->namingConvention));
        } else {
            $this->useLabel = false;
        }
    }

    /**
     * Updates the resource name according to language and naming convention
     * defined in the object. Using URI fragment ID (local ID/Name) by default.
     */
    public function updateResourceName(): void
    {
        if ($this->useLabel) {
            $resourceName = $this->labelAsName($this->language, $this->namingConvention) ?? $this->localId();
            // If it's a Class or a Wikidata/Wikibase Item, we need to start with
            // a capital letter as the name is used for the PHP Class & API resource
            $this->resourceName = (\in_array($this->type(), ['owl:Class', 'rdfs:Class', 'wikibase:Item', 'wd:Item'], true)) ? ucfirst($resourceName) : $resourceName;
        } else {
            $this->resourceName = $this->localId();
        }
    }

    /**
     * Sets wether or not this Resource makes use of the label for defining its name.
     */
    public function setUseLabel(bool $useLabel): void
    {
        $this->useLabel = $useLabel;
    }

    /**
     * Gets wether or not this Resource makes use of the label for defining its name.
     */
    public function getUseLabel(): bool
    {
        return $this->useLabel;
    }

    /**
     * Sets the resource name.
     */
    public function setResourceName(?string $resourceName): void
    {
        $this->resourceName = $resourceName;
    }

    /**
     * Gets the resource name defined.
     */
    public function getResourceName(): ?string
    {
        return $this->resourceName;
    }

    /**
     * Gets the EasyRdf\Resource composing this Schema Generator's RdfResource.
     */
    public function getEasyResource(): EasyRdfResource
    {
        return $this->resource;
    }

    /**
     * Resets the resource's parameters related to naming behavior.
     */
    public function resetResourceNamingBehavior(): void
    {
        $this->useLabel = false;
        $this->language = null;
        $this->namingConvention = null;
        $this->resourceName = null;
    }

    /**
     * Gets the Identifier of the resource from the URI fragment identifier.
     */
    public function localId(): string
    {
        // Replaces EasyRdf\Resource->localName() that may return void on v1.1.1 (PHPStan)
        if (preg_match('|([^#:/]+)$|', $this->getUri(), $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Returns the label of the resource in the given language with given style
     * or make use of the default label if none exists in the defined language.
     */
    private function labelAsName(?string $language, string $namingConvention = null): ?string
    {
        // English is the default language, forseeing graphs with several ones.
        $language = $language ?: 'en';

        $defaultLabel = $this->resource->label(null);
        $label = $this->resource->label($language) ?? $defaultLabel;

        if ('snake case' === $namingConvention) {
            return isset($label) ? u($label->__toString())->snake()->__toString() : null;
        }

        // default is camel case style as with schema.org
        return isset($label) ? u($label->__toString())->camel()->__toString() : null;
    }

    /**
     * Gets the graph related to this resource as a Schema Generator's RdfGraph.
     */
    public function getGraph(): ?RdfGraph
    {
        return ($this->hasGraph()) ? RdfGraph::fromEasyRdf($this->resource->getGraph()) : null;
    }

    /**
     * Get the URI of the EasyRdf\Resource.
     */
    public function getUri(): string
    {
        return $this->resource->getUri();
    }

    /**
     * Returns true if the current RdfResource belongs to a graph.
     */
    protected function hasGraph(): bool
    {
        return null !== $this->resource->getGraph();
    }

    /**
     * Sets the current resource's prefered language (e.g. 'en').
     */
    public function setResourceLanguage(?string $language): void
    {
        $this->language = $language;
    }

    /**
     * Gets the prefered language set for the resource.
     */
    public function getResourceLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * Sets the current resource naming convention to use when naming entities
     * from labels (i.e. "snake case" or "camel case").
     */
    public function setNamingConvention(?string $namingConvention): void
    {
        $this->namingConvention = $namingConvention;
    }

    /**
     * Gets the naming convention set for the resource.
     */
    public function getNamingConvention(): ?string
    {
        return $this->namingConvention;
    }

    /**
     * Gets all values for a property and ensures that each EasyRdf\Resource
     * matched is returned as wrapped in an RdfResource.
     *
     * @param mixed $property The name of the property
     *
     * @return array<mixed>
     */
    public function all($property, string $type = null, string $lang = null): array
    {
        $property = self::fromRdftoEasyRdfResource($property);

        return self::wrapEasyRdfResources($this->resource->all($property, $type, $lang));
    }

    /**
     * Gets all the resources for a property of this resource and ensures that
     * each EasyRdf\Resource matched is returned as wrapped in an RdfResource.
     *
     * @return RdfResource[]
     */
    public function allResources(string $property): array
    {
        $property = self::fromRdftoEasyRdfResource($property);

        return self::wrapEasyRdfResources($this->resource->allResources($property));
    }

    /**
     * Gets a list of types for a resource, as an array of schema generator's RdfResources.
     *
     * @return RdfResource[]
     */
    public function typesAsResources(): array
    {
        return self::wrapEasyRdfResources($this->resource->typesAsResources());
    }

    /**
     * Wrapps a given EasyRdf\Resource in the returned RdfResource.
     */
    public static function fromEasyRdf(EasyRdfResource $resource): self
    {
        $rdfResource = new static(null, null, $resource);

        return $rdfResource;
    }

    /**
     * Turns any EasyRdf\Resource, provided by reference, into an RdfResource.
     * Any form of resource is accepted but only EasyRdf\Resources are impacted.
     *
     * @param mixed &$resource mixed resource types
     */
    public static function ensureResourceClass(&$resource): void
    {
        $resource = ($resource instanceof EasyRdfResource) ? self::fromEasyRdf($resource) : $resource;
    }

    /**
     * Ensures each EasyRdf\resource in the array of resources passed by reference
     * is turned into an RdfResource wrapping the EasyRdf\Resource.
     *
     * @param array<mixed> &$resources
     */
    public static function ensureResourcesClass(array &$resources): void
    {
        array_walk($resources, self::class.'::ensureResourceClass');
    }

    /**
     * Extends the capabilities of any EasyRdf\Resource provided by turning it
     * into an RdfResource.
     *
     * @param mixed $resource mixed resource types
     *
     * @return mixed $resource mixed but EasyRdf\Resource is wrapped into an RdfResource
     */
    public static function wrapEasyRdfResource($resource)
    {
        $resource = ($resource instanceof EasyRdfResource) ? self::fromEasyRdf($resource) : $resource;

        return $resource;
    }

    /**
     * Extends the capabilities of each EasyRdf\resource in the array provided
     * by wrapping it in an RdfResource.
     *
     * @param array<mixed> $resources
     *
     * @return array<mixed>
     */
    public static function wrapEasyRdfResources(array $resources): array
    {
        array_walk($resources, self::class.'::ensureResourceClass');

        return $resources;
    }

    /**
     * Returns the corresponding EasyRdf\Resource for any RdfResource provided.
     *
     * @param mixed $resource mixed resource types
     *
     * @return mixed $resource mixed but any RdfResource will return its contained EasyRdf\resource
     */
    public static function fromRdftoEasyRdfResource($resource)
    {
        $resource = ($resource instanceof self) ? $resource->getEasyResource() : $resource;

        return $resource;
    }

    /**
     * Ensures that all RdfResources provided in an array are returned in that
     * array as EasyRdf\Resource class Type.
     *
     * @param array<mixed> $resources
     *
     * @return array<mixed>
     */
    public static function fromRdftoEasyRdfResources(array $resources): array
    {
        array_walk($resources, self::class.'::ensureEasyResourceClass');

        return $resources;
    }

    /**
     * Ensures that any RdfResource provided by reference will be an EasyRdf\Resource.
     *
     * @param mixed $resource mixed resource types
     */
    public static function ensureEasyResourceClass(&$resource): void
    {
        $resource = ($resource instanceof self) ? $resource->getEasyResource() : $resource;
    }

    /**
     * Passes any call for an absent method to the contained EasyRdf\Resource,
     * ensuring that it returns an RdfResource in place of a simple EasyRdf\Resource.
     *
     * @param array<mixed> $arguments
     *
     * @return mixed depending on the method called
     */
    #[\ReturnTypeWillChange]
    public function __call(string $methodName, array $arguments)
    {
        $arguments = self::fromRdftoEasyRdfResources($arguments);
        $callback = [$this->resource, $methodName];
        if (\is_callable($callback)) {
            return self::wrapEasyRdfResource(\call_user_func_array($callback, $arguments));
        }
        throw new \Exception('Method not found');
    }

    public function __toString(): string
    {
        return $this->resource->__toString();
    }

    public function __isset(string $name): bool
    {
        return $this->resource->__isset($name);
    }

    public function __set(string $name, string $value): void
    {
        $this->resource->__set($name, $value);
    }

    public function __get(string $name): ?string
    {
        return $this->resource->__get($name);
    }

    public function __unset(string $name): void
    {
        $this->resource->__unset($name);
    }

    /**
     * Array Access Interface: Check whether an offset exists.
     *
     * @param mixed $offset an offset to check for
     */
    public function offsetExists($offset): bool
    {
        return $this->resource->offsetExists($offset);
    }

    /**
     * Array Access Interface: perform get at using array syntax.
     *
     * @return mixed can return all value types
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->resource->offsetGet($offset);
    }

    /**
     * Array Access Interface: perform set at using array syntax.
     */
    public function offsetSet($offset, $value): void
    {
        $this->resource->offsetSet($offset, $value);
    }

    /**
     * Array Access Interface: perform unset at using array syntax.
     */
    public function offsetUnset($offset): void
    {
        $this->resource->offsetUnset($offset);
    }

    // The following Methods are not required but avoid PHPStan special cases of
    // class Reflection without implementing extensions; see __call()

    public function isA(string $type): bool
    {
        return $this->resource->isA($type);
    }

    public function isBNode(): bool
    {
        return $this->resource->isBNode();
    }

    /** Get a single value for a property.
     *
     * @param mixed  $property The name of the property (e.g. foaf:name)
     * @param mixed  $type     The type of value to filter by (e.g. literal or resource)
     * @param string $lang     The language to filter by (e.g. en)
     *
     * @return mixed A value associated with the property
     */
    public function get($property, $type = null, $lang = null)
    {
        $property = self::fromRdftoEasyRdfResource($property);
        $type = self::fromRdftoEasyRdfResource($type);

        return self::wrapEasyRdfResource($this->resource->get($property, $type, $lang));
    }

    /** Check to see if a property exists for this resource.
     *
     * @param string $property The name of the property (e.g. foaf:name)
     * @param mixed  $value    An optional value of the property
     *
     * @return bool true if value the property exists
     */
    public function hasProperty($property, $value = null): bool
    {
        return $this->resource->hasProperty($property, $value);
    }

    /** Add values to for a property of the resource.
     *
     * @param mixed $property The property name
     * @param mixed $value    The value for the property
     *
     * @return int The number of values added (1 or 0)
     */
    public function add($property, $value): int
    {
        return $this->resource->add($property, $value);
    }

    public function type(): ?string
    {
        return $this->resource->type();
    }
}
