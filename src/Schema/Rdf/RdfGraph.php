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

use EasyRdf\Graph as EasyRdfGraph;

/**
 * This class is a wrapper around the EasyRdf\Graph class. It allows the Schema
 * Generator to get RdfResource objects instead of EasyRdf\Resource ones when required.
 *
 * @author d3fk::Angatar
 */
class RdfGraph
{
    private EasyRdfGraph $graph;

    /**
     * Constructor, creates the RdfGraph decorating a freshly created or given
     * EasyRdf\Graph with the capability to return/use RdfResource instead of EasyRdf\Resource.
     */
    final public function __construct(string $uri = null, string $data = null, string $format = null, EasyRdfGraph $graph = null)
    {
        $this->graph = $graph ?? new EasyRdfGraph($uri, $data, $format);
    }

    /**
     * Returns the corresponding EasyRdf\Graph.
     */
    public function getEasyGraph(): EasyRdfGraph
    {
        return $this->graph;
    }

    /**
     * Passes any call for an absent method to the contained EasyRdf\Graph, ensuring
     * that it returns a Schema Generator's RdfResource in place of any EasyRdf\Resource.
     *
     * @param array<mixed> $arguments
     *
     * @return mixed depending on the method called
     */
    #[\ReturnTypeWillChange]
    public function __call(string $methodName, array $arguments)
    {
        $arguments = RdfResource::fromRdftoEasyRdfResources($arguments);
        $callback = [$this->graph, $methodName];
        if (\is_callable($callback)) {
            return RdfResource::wrapEasyRdfResource(\call_user_func_array($callback, $arguments));
        }
        throw new \Exception('Method not found');
    }

    /**
     * Gets all the resources for a property of a resource and ensures that each
     * EasyRdf\Resource matched is returned as wrapped in an RdfResource.
     *
     * @return array<string>
     */
    public function allResources(string $resource, string $property): array
    {
        $resource = RdfResource::fromRdftoEasyRdfResource($resource);

        return RdfResource::wrapEasyRdfResources($this->graph->allResources($resource, $property));
    }

    /**
     * Gets all values for a property path and ensures that each EasyRdf\Resource
     * matched is returned as wrapped in an RdfResource.
     *
     * @return array<string>
     */
    public function all(string $resource, string $propertyPath, string $type = null, string $lang = null): array
    {
        $resource = RdfResource::fromRdftoEasyRdfResource($resource);

        return RdfResource::wrapEasyRdfResources($this->graph->all($resource, $propertyPath, $type, $lang));
    }

    /**
     * Gets all the resources in the graph of a certain type and ensures that
     * each EasyRdf\Resource matched is returned as wrapped in an RdfResource.
     *
     * @return array<mixed>
     */
    public function allOfType(string $type): array
    {
        return RdfResource::wrapEasyRdfResources($this->graph->allOfType($type));
    }

    /**
     * Gets the resource types of the graph as list of RdfResource.
     *
     * @param string|null $resource
     *
     * @return RdfResource[]
     */
    public function typesAsResources($resource = null): array
    {
        $resource = RdfResource::fromRdftoEasyRdfResource($resource);

        return RdfResource::wrapEasyRdfResources($this->graph->typesAsResources($resource));
    }

    /**
     * Gets an associative array of all the resources stored in the graph as
     * RdfResources. The keys of the array is the URI of the related RdfResource.
     *
     * @return RdfResource[]
     */
    public function resources(): array
    {
        return RdfResource::wrapEasyRdfResources($this->graph->resources());
    }

    /**
     * Get an array of RdfResources matching a certain property and optional value.
     *
     * @param string $property the property to check
     * @param mixed  $value    optional, the value of the propery to check for
     *
     * @return RdfResource[]
     */
    public function resourcesMatching($property, $value = null): array
    {
        return RdfResource::wrapEasyRdfResources($this->graph->resourcesMatching($property, $value));
    }

    /**
     * Turns any provided EasyRdf\Graph into an RdfGraph.
     */
    public static function fromEasyRdf(EasyRdfGraph $graph): self
    {
        $rdfGraph = new static(null, null, null, $graph);

        return $rdfGraph;
    }

    /**
     * Ensures that any EasyRdf\Graph provided by reference will be wrapped in
     * an RdfGraph.
     *
     * @param EasyRdfGraph|RdfGraph &$graph
     */
    public static function ensureGraphClass(&$graph): void
    {
        $graph = ($graph instanceof EasyRdfGraph) ? self::fromEasyRdf($graph) : $graph;
    }

    /**
     * Ensures that each EasyRdf\Graph, in an array of Graphs passed by reference,
     * is wrapped in an RdfGraph.
     *
     * @param array<EasyRdfGraph|RdfGraph> &$graphs
     */
    public static function ensureGraphsClass(array &$graphs): void
    {
        array_walk($graphs, self::class.'::ensureGraphClass');
    }

    /**
     * Statically creates a new RdfGraph and loads RDF data from the provided URI.
     */
    public static function newAndLoad(string $uri, string $format = null): self
    {
        $graph = new self($uri);
        $graph->load($uri, $format);

        return $graph;
    }

    public function __toString(): string
    {
        return $this->graph->__toString();
    }

    public function __isset(string $name): bool
    {
        return $this->graph->__isset($name);
    }

    public function __set(string $name, string $value): void
    {
        $this->graph->__set($name, $value);
    }

    public function __get(string $name): ?string
    {
        return $this->graph->__get($name);
    }

    public function __unset(string $name): void
    {
        $this->graph->__unset($name);
    }

    // The following Methods are not required but avoid PHPStan special cases of
    // class Reflection without implementing extensions; see __call()

    /**
     * Get the URI of the EasyRdf\Graph.
     */
    public function getUri(): ?string
    {
        return $this->graph->getUri();
    }

    /** Get or create a resource stored in a graph.
     *
     * If the resource did not previously exist, then a new resource will
     * be created.
     *
     * If URI is null, then the URI of the graph is used.
     *
     * @param string $uri   The URI of the resource
     * @param mixed  $types RDF type of a new resource (e.g. foaf:Person)
     */
    public function resource($uri = null, $types = []): RdfResource
    {
        return RdfResource::wrapEasyRdfResource($this->graph->resource($uri, $types));
    }

    public function load(string $uri = null, string $format = null): int
    {
        return $this->graph->load($uri, $format);
    }

    /**
     * Parse a file containing RDF data into the graph object.
     *
     * @param string $filename The path of the file to load
     * @param string $format   Optional format of the file
     * @param string $uri      The URI of the file to load
     *
     * @return int The number of triples added to the graph
     */
    public function parseFile($filename, $format = null, $uri = null): int
    {
        return $this->graph->parseFile($filename, $format, $uri);
    }
}
