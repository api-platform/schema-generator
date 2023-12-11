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
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfigurationHolder as Config;
use EasyRdf\Graph as EasyRdfGraph;
use EasyRdf\RdfNamespace;
use EasyRdf\Resource as EasyRdfResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

use function Symfony\Component\String\u;

/**
 * @author d3fk::Angatar
 */
class RdfResourceTest extends TestCase
{
    private static array $testGroups;
    private static Processor $processor;

    public static function setUpBeforeClass(): void
    {
        self::$processor = new Processor();
        $testGroups = [
            [
                'graphUri' => 'https://ontobee.org/ontology/rdf/NCIT?iri=http://purl.obolibrary.org/obo/NCIT_C94196',
                'graphFormat' => 'rdfxml',
                'resourceUri' => 'http://purl.obolibrary.org/obo/NCIT_C94196',
                'vocabularyNamespace' => 'http://purl.obolibrary.org/obo/',
                'label' => 'Virus-neutralizing Antibody',
                'id' => 'NCIT_C94196',
                'spanishLabel' => 'Virus-neutralizing Antibody',
            ],
            [
                'graphUri' => 'https://raw.githubusercontent.com/w3c/dxwg/gh-pages/dcat/rdf/dcat3.rdf',
                'graphFormat' => 'rdfxml',
                'resourceUri' => 'http://www.w3.org/ns/dcat#DataService',
                'vocabularyNamespace' => 'http://www.w3.org/ns/dcat#',
                'label' => 'Data service',
                'id' => 'DataService',
                'spanishLabel' => 'Servicio de datos',
            ],
            [
                'graphUri' => 'http://www.wikidata.org/entity/Q115634351.rdf',
                'graphFormat' => 'rdfxml',
                'resourceUri' => 'http://www.wikidata.org/entity/Q115634351',
                'vocabularyNamespace' => 'http://www.wikidata.org/entity/',
                'label' => 'laboratory freezer',
                'id' => 'Q115634351',
                'spanishLabel' => 'congelador de laboratorio',
            ],
        ];

        // set namespaces to work with wikidata
        RdfNamespace::set('wikibase', 'http://wikiba.se/ontology#');
        RdfNamespace::set('wd', 'http://www.wikidata.org/entity/');

        foreach ($testGroups as &$testValues) {
            $testValues['snakeLabel'] = u($testValues['label'])->snake()->__toString();
            $testValues['camelLabel'] = u($testValues['label'])->camel()->__toString();
            $testValues['snakeClassLabel'] = ucfirst($testValues['snakeLabel']);
            $testValues['camelClassLabel'] = ucfirst($testValues['camelLabel']);
            $testValues['snakeSpanishLabel'] = u($testValues['spanishLabel'])->snake()->__toString();
            $testValues['camelSpanishLabel'] = u($testValues['spanishLabel'])->camel()->__toString();
            $testValues['snakeSpanishClassLabel'] = ucfirst($testValues['snakeSpanishLabel']);

            $testValues['graph'] = RdfGraph::newAndLoad($testValues['graphUri'], $testValues['graphFormat']);
        }

        self::$testGroups = $testGroups;
    }

    protected function setUp(): void
    {
        Config::reset();
    }

    public function testLocalNameWithConfig(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getSingleTypeRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['snakeClassLabel'], $resource->localName());

            $resource = $this->createConfiguredRdfResource($this->getAllTypesRdfResourceGeneralNamingConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['camelClassLabel'], $resource->localName());

            $resource = $this->createConfiguredRdfResource($this->getAllTypesRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['snakeClassLabel'], $resource->localName());

            $resource = $this->createConfiguredRdfResource($this->getAllTypesRdfResourcePreferedLanguageConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['snakeSpanishClassLabel'], $resource->localName());

            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['id'], $resource->localName());

            // no config reset occured Config::$config is still set
            $resource = new RdfResource($testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['id'], $resource->localName());

            $resource = new RdfResource($testValues['resourceUri']);
            $this->assertEquals($testValues['id'], $resource->localName());
        }
    }

    public function testLocalNameWithoutConfig(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = new RdfResource($testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['id'], $resource->localName());

            $resource = new RdfResource($testValues['resourceUri']);
            $this->assertEquals($testValues['id'], $resource->localName());
        }
    }

    public function testLocalNameConfigOvewrittenBySetters()
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['id'], $resource->localName());
            $resource->setResourceName('test');
            $this->assertEquals('test', $resource->localName());
            $resource->setResourceName(null);
            $this->assertEquals($testValues['id'], $resource->localName());
            $resource->setResourceName(null);
            $resource->setUseLabel(true);
            $resource->updateResourceName();
            $this->assertEquals($testValues['camelClassLabel'], $resource->localName());
            $resource->setNamingConvention('snake case');
            $resource->updateResourceName();
            $this->assertEquals($testValues['snakeClassLabel'], $resource->localName());
            $resource->setResourceLanguage('es');
            $resource->updateResourceName();
            $this->assertEquals($testValues['snakeSpanishClassLabel'], $resource->localName());
            $resource->setResourceLanguage('en');
            $resource->updateResourceName();
            $this->assertEquals($testValues['snakeClassLabel'], $resource->localName());
        }
    }

    public function testApplyNamingConfig(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $resource->setUseLabel(true);
            $resource->applyNamingConfig();
            $this->assertFalse($resource->getUseLabel());
            $resource = $this->createConfiguredRdfResource($this->getAllTypesRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $this->assertTrue($resource->getUseLabel());
            $resource->setUseLabel(false);
            $resource->applyNamingConfig();
            $this->assertTrue($resource->getUseLabel());
        }
    }

    public function testSetResourceName(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getAllTypesRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $resource->setResourceName('test');
            $this->assertEquals('test', $resource->getResourceName());
        }
    }

    public function testUpdateResourceName(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = new RdfResource($testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['id'], $resource->localName());
            $resource->setUseLabel(true);
            $resource->updateResourceName();
            $this->assertEquals($testValues['camelClassLabel'], $resource->getResourceName());
        }
    }

    public function testResetResourceNamingBehavior(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getAllTypesRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);

            $resource->resetResourceNamingBehavior();
            $this->assertNull($resource->getResourceName());

            $resource->updateResourceName();
            $this->assertEquals($testValues['id'], $resource->localName());
        }
    }

    public function testLocalId(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getAllTypesRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $this->assertEquals($testValues['id'], $resource->localId());
        }
    }

    public function testLabelAsName(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $resourceMethod = self::getMethod('labelAsName');
            $this->assertEquals($testValues['camelLabel'], $resourceMethod->invokeArgs($resource, ['', '']));
            $this->assertEquals($testValues['snakeLabel'], $resourceMethod->invokeArgs($resource, ['en', 'snake case']));
            $this->assertEquals($testValues['camelSpanishLabel'], $resourceMethod->invokeArgs($resource, ['es', 'camel case']));
        }
    }

    public function testGetGraph(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = new RdfResource($testValues['resourceUri']);
            $this->assertNull($resource->getGraph());
            $resource = new RdfResource($testValues['resourceUri'], $testValues['graph']);
            $this->assertInstanceOf(RdfGraph::class, $resource->getGraph());
            $resource = new RdfResource($testValues['resourceUri'], new EasyRdfGraph($testValues['graphUri']));
            $this->assertInstanceOf(RdfGraph::class, $resource->getGraph());
        }
    }

    public function testAll(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getAllTypesRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $resource->addResource('rdf:test', 'Simple Test1');
            $resource->addResource('rdf:test', 'Simple Test2');
            $prop = $testValues['graph']->resource('http://www.w3.org/1999/02/22-rdf-syntax-ns#test');
            $all = $resource->all($prop);
            $this->assertNotEmpty($all);
            foreach ($all as $propResource) {
                $this->assertInstanceOf(RdfResource::class, $propResource);
            }
        }
    }

    public function testAllResources(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $resource->addResource('rdf:test', 'Resource Test');
            $resources = $resource->allResources('rdf:test');
            $this->assertNotEmpty($resources);
            foreach ($resources as $relatedResource) {
                $this->assertInstanceOf(RdfResource::class, $relatedResource);
            }
        }
    }

    public function testTypesAsResources(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $resources = $resource->typesAsResources();
            $this->assertNotEmpty($resources);
            foreach ($resources as $typeResource) {
                $this->assertInstanceOf(RdfResource::class, $typeResource);
            }
        }
    }

    public function testTypeAsResource(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $typeResource = $resource->typeAsResource();
            $this->assertNotNull($typeResource);
            $this->assertInstanceOf(RdfResource::class, $typeResource);
        }
    }

    public function testGet(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $resource->addResource('rdf:test', 'Testing get function');
            $prop = $testValues['graph']->resource('http://www.w3.org/1999/02/22-rdf-syntax-ns#test');
            $getPropertyResource = $resource->get($prop);
            $this->assertNotNull($getPropertyResource);
            $this->assertInstanceOf(RdfResource::class, $getPropertyResource);
        }
    }

    public function testGetResource(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $resource->addResource('rdf:test', 'Testing getRersource function');
            $prop = $testValues['graph']->resource('http://www.w3.org/1999/02/22-rdf-syntax-ns#test');
            $getPropertyResource = $resource->getResource($prop);
            $this->assertNotNull($getPropertyResource);
            $this->assertInstanceOf(RdfResource::class, $getPropertyResource);
        }
    }

    public function testPrimaryTopic(): void
    {
        foreach (self::$testGroups as $testValues) {
            $resource = $this->createConfiguredRdfResource($this->getDefaultRdfResourceConfig($testValues), $testValues['resourceUri'], $testValues['graph']);
            $resource->addResource('foaf:primaryTopic', 'Testing Resource primary Topic');
            $primaryTopic = $resource->primaryTopic();
            $this->assertInstanceOf(RdfResource::class, $primaryTopic);
        }
    }

    public function testFromEasyRdf(): void
    {
        foreach (self::$testGroups as $testValues) {
            $easyRdfResource = new EasyRdfResource($testValues['resourceUri']);
            $rdfResource = RdfResource::fromEasyRdf($easyRdfResource);
            $this->assertInstanceOf(RdfResource::class, $rdfResource);
        }
    }

    public function testFromEasyRdfWithGraph(): void
    {
        foreach (self::$testGroups as $testValues) {
            $easyRdfResource = new EasyRdfResource($testValues['resourceUri'], $testValues['graph']->getEasyGraph());
            $rdfResource = RdfResource::fromEasyRdf($easyRdfResource);
            $this->assertInstanceOf(RdfResource::class, $rdfResource);
        }
    }

    public function testEnsureResourceClass(): void
    {
        foreach (self::$testGroups as $testValues) {
            $rdfResourceToCast = new EasyRdfResource($testValues['resourceUri'], $testValues['graph']->getEasyGraph());
            RdfResource::ensureResourceClass($rdfResourceToCast);
            $this->assertInstanceOf(RdfResource::class, $rdfResourceToCast);
        }
    }

    public function testEnsureResourcesClass(): void
    {
        $resources = [];
        $easyRdfResource = new EasyRdfResource(self::$testGroups[0]['resourceUri'], self::$testGroups[0]['graph']->getEasyGraph());
        $resources[] = $easyRdfResource;
        $resources[] = $easyRdfResource;
        $resources[] = new RdfResource(self::$testGroups[0]['resourceUri'], self::$testGroups[0]['graph']);

        RdfResource::ensureResourcesClass($resources);
        foreach ($resources as $resource) {
            $this->assertInstanceOf(RdfResource::class, $resource);
        }
    }

    public function testWrapEasyRdfResource(): void
    {
        $resourceToDecorate = new EasyRdfResource(self::$testGroups[0]['resourceUri'], self::$testGroups[0]['graph']->getEasyGraph());
        $decoratedResource = RdfResource::wrapEasyRdfResource($resourceToDecorate);
        $this->assertInstanceOf(RdfResource::class, $decoratedResource);
    }

    public function testWrapEasyRdfResources(): void
    {
        $resources = [];
        $easyRdfResource = new EasyRdfResource(self::$testGroups[0]['resourceUri'], self::$testGroups[0]['graph']->getEasyGraph());
        $resources[] = $easyRdfResource;
        $resources[] = $easyRdfResource;
        $resources[] = new RdfResource(self::$testGroups[0]['resourceUri'], self::$testGroups[0]['graph']);

        $resources = RdfResource::wrapEasyRdfResources($resources);
        foreach ($resources as $resource) {
            $this->assertInstanceOf(RdfResource::class, $resource);
        }
    }

    private function processConfiguration(array $config): array
    {
        return self::$processor->processConfiguration(new SchemaGeneratorConfiguration(), [$config]);
    }

    private function setResourceConfiguration(array $processedConfiguration): void
    {
        Config::set($processedConfiguration);
    }

    private function createConfiguredRdfResource(array $config, string $resouceUri, RdfGraph $graph): RdfResource
    {
        $processedConfiguration = $this->processConfiguration($config);
        $this->setResourceConfiguration($processedConfiguration);

        return new RdfResource($resouceUri, $graph);
    }

    private function getSingleTypeRdfResourceConfig(array $testValues): array
    {
        return [
            'vocabularies' => [
                ['uri' => $testValues['graphUri'], 'allTypes' => false],
            ],
            'types' => [
                $testValues['id'] => [
                    'nameFromLabel' => true,
                    'namingConvention' => 'snake case',
                    'vocabularyNamespace' => $testValues['vocabularyNamespace'],
                ],
            ],
        ];
    }

    private function getAllTypesRdfResourceGeneralNamingConfig(array $testValues): array
    {
        return [
            'vocabularies' => [
                ['uri' => $testValues['graphUri'], 'allTypes' => true],
            ],
            'nameAllFromLabels' => true,
            'namingConvention' => 'camel case',
        ];
    }

    private function getAllTypesRdfResourceConfig(array $testValues): array
    {
        return [
            'vocabularies' => [
                ['uri' => $testValues['graphUri'], 'allTypes' => true, 'nameAllFromLabels' => true, 'namingConvention' => 'snake case'],
            ],
        ];
    }

    private function getAllTypesRdfResourcePreferedLanguageConfig(array $testValues): array
    {
        return [
            'vocabularies' => [
                ['uri' => $testValues['graphUri'], 'allTypes' => true, 'nameAllFromLabels' => true, 'namingConvention' => 'snake case', 'language' => 'es'],
            ],
        ];
    }

    private function getDefaultRdfResourceConfig(array $testValues): array
    {
        return [
            'vocabularies' => [
                ['uri' => $testValues['graphUri']],
            ],
        ];
    }

    /**
     * Get private/protected method from a class for testing.
     *
     * @param string $name method name
     */
    protected static function getMethod($name): \ReflectionMethod
    {
        $class = new \ReflectionClass(RdfResource::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}
