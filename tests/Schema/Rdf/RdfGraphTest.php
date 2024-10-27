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

namespace ApiPlatform\SchemaGenerator\Tests\Schema\Rdf;

use ApiPlatform\SchemaGenerator\Schema\Rdf\RdfGraph;
use ApiPlatform\SchemaGenerator\Schema\Rdf\RdfResource;
use EasyRdf\Graph as EasyRdfGraph;
use PHPUnit\Framework\TestCase;

/**
 * @author d3fk::Angatar
 */
class RdfGraphTest extends TestCase
{
    private static array $testvalues;
    private RdfGraph $graph;

    public static function setUpBeforeClass(): void
    {
        self::$testvalues = [
            'graphUri' => 'https://raw.githubusercontent.com/w3c/dxwg/gh-pages/dcat/rdf/dcat3.rdf',
            'graphFormat' => 'rdfxml',
            'vocabularyNamespace' => 'http://www.w3.org/ns/dcat#',
            'resourceUri' => 'http://www.w3.org/ns/dcat#DataService',
            'resourceType' => 'owl:Class',
            'property' => 'rdfs:range',
            'newBnodeType' => 'foaf:Project',
            'newResourcePropertyName' => 'rdf:test',
        ];
    }

    protected function setUp(): void
    {
        $this->graph = new RdfGraph(self::$testvalues['graphUri']);
    }

    public function testResource(): void
    {
        $resource = $this->graph->resource(self::$testvalues['resourceUri'], [self::$testvalues['resourceType']]);
        $this->assertInstanceOf(RdfResource::class, $resource);
    }

    public function testNewBnode(): void
    {
        $bnode = $this->graph->newBnode(self::$testvalues['newBnodeType']);
        $this->assertInstanceOf(RdfResource::class, $bnode);
    }

    public function testGet(): void
    {
        $bnode = $this->graph->newBnode(self::$testvalues['newBnodeType']);
        $this->graph->addResource(self::$testvalues['resourceUri'], self::$testvalues['newResourcePropertyName'], $bnode);
        $resource = $this->graph->get(self::$testvalues['resourceUri'], self::$testvalues['newResourcePropertyName'], 'resource');
        $this->assertInstanceOf(RdfResource::class, $resource);
    }

    public function testGetResource(): void
    {
        $bnode = $this->graph->newBnode(self::$testvalues['newBnodeType']);
        $this->graph->addResource(self::$testvalues['resourceUri'], self::$testvalues['newResourcePropertyName'], $bnode);
        $resource = $this->graph->getResource(self::$testvalues['resourceUri'], self::$testvalues['newResourcePropertyName']);
        $this->assertInstanceOf(RdfResource::class, $resource);
    }

    public function testTypeAsResource(): void
    {
        $this->graph->load(self::$testvalues['graphUri'], self::$testvalues['graphFormat']);
        $resource = $this->graph->typeAsResource(self::$testvalues['resourceUri']);
        $this->assertInstanceOf(RdfResource::class, $resource);
    }

    public function testPrimaryTopic(): void
    {
        $bnode = $this->graph->newBnode(self::$testvalues['newBnodeType']);
        $this->graph->addResource(self::$testvalues['resourceUri'], 'foaf:primaryTopic', $bnode);
        $resource = $this->graph->primaryTopic(self::$testvalues['resourceUri']);
        $this->assertInstanceOf(RdfResource::class, $resource);
    }

    public function testAll(): void
    {
        $this->graph->load(self::$testvalues['graphUri'], self::$testvalues['graphFormat']);
        $resources = $this->graph->all(self::$testvalues['resourceType'], '^rdf:type');
        $this->assertNotEmpty($resources);
        foreach ($resources as $resource) {
            $this->assertInstanceOf(RdfResource::class, $resource);
        }
    }

    public function testAllOfType(): void
    {
        $this->graph->load(self::$testvalues['graphUri'], self::$testvalues['graphFormat']);
        $resources = $this->graph->allOfType(self::$testvalues['resourceType']);
        $this->assertNotEmpty($resources);
        foreach ($resources as $resource) {
            $this->assertInstanceOf(RdfResource::class, $resource);
        }
    }

    public function testTypesAsResources(): void
    {
        $this->graph->load(self::$testvalues['graphUri'], self::$testvalues['graphFormat']);
        $resources = $this->graph->typesAsResources(self::$testvalues['resourceUri']);
        $this->assertNotEmpty($resources);
        foreach ($resources as $resource) {
            $this->assertInstanceOf(RdfResource::class, $resource);
        }
    }

    public function testResources(): void
    {
        $this->graph->load(self::$testvalues['graphUri'], self::$testvalues['graphFormat']);
        $resources = $this->graph->resources();
        $this->assertNotEmpty($resources);
        foreach ($resources as $resource) {
            $this->assertInstanceOf(RdfResource::class, $resource);
        }
    }

    public function testResourcesMatching(): void
    {
        $this->graph->load(self::$testvalues['graphUri'], self::$testvalues['graphFormat']);
        $resources = $this->graph->resourcesMatching(self::$testvalues['property']);
        $this->assertNotEmpty($resources);
        foreach ($resources as $resource) {
            $this->assertInstanceOf(RdfResource::class, $resource);
        }
    }

    public function testAllResources(): void
    {
        $this->graph->load(self::$testvalues['graphUri'], self::$testvalues['graphFormat']);
        $this->graph->addResource(self::$testvalues['resourceUri'], self::$testvalues['newResourcePropertyName'], 'http://example.com/thing');
        $this->graph->addResource(self::$testvalues['resourceUri'], self::$testvalues['newResourcePropertyName'], '_:bnode1');
        $resources = $this->graph->allResources(self::$testvalues['resourceUri'], self::$testvalues['newResourcePropertyName']);
        $this->assertNotEmpty($resources);
        foreach ($resources as $resource) {
            $this->assertInstanceOf(RdfResource::class, $resource);
        }
    }

    public function testFromEasyRdf(): void
    {
        $easyRdfGraph = new EasyRdfGraph(self::$testvalues['graphUri']);
        $easyRdfGraph->load(self::$testvalues['graphUri'], self::$testvalues['graphFormat']);
        $rdfGraph = RdfGraph::fromEasyRdf($easyRdfGraph);
        $this->assertInstanceOf(RdfGraph::class, $rdfGraph);
        $this->assertEquals($easyRdfGraph->serialise('rdfxml'), $rdfGraph->serialise('rdfxml'));
    }

    public function testEnsureGraphClass(): void
    {
        $rdfGraph = new EasyRdfGraph(self::$testvalues['graphUri']);
        RdfGraph::ensureGraphClass($rdfGraph);
        $this->assertInstanceOf(RdfGraph::class, $rdfGraph);
    }

    public function testEnsureGraphsClass(): void
    {
        $graphs = [];
        $rdfGraph = new EasyRdfGraph(self::$testvalues['graphUri']);
        $graphs[] = $rdfGraph;
        $graphs[] = $rdfGraph;
        $graphs[] = $this->graph;

        RdfGraph::ensureGraphsClass($graphs);
        foreach ($graphs as $graph) {
            $this->assertInstanceOf(RdfGraph::class, $graph);
        }
    }

    public function testNewAndLoad(): void
    {
        $newLoadedGraph = RdfGraph::newAndLoad(self::$testvalues['graphUri'], self::$testvalues['graphFormat']);
        $this->assertInstanceOf(RdfGraph::class, $newLoadedGraph);
    }
}
