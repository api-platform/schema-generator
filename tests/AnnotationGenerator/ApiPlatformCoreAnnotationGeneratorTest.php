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

namespace ApiPlatform\SchemaGenerator\Tests\AnnotationGenerator;

use ApiPlatform\SchemaGenerator\AnnotationGenerator\ApiPlatformCoreAnnotationGenerator;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ApiPlatformCoreAnnotationGeneratorTest extends TestCase
{
    /**
     * @var ApiPlatformCoreAnnotationGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        $graph = new \EasyRdf_Graph();
        $myEnum = new \EasyRdf_Resource('http://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);

        $this->generator = new ApiPlatformCoreAnnotationGenerator(
            new NullLogger(),
            [],
            [],
            [],
            [
                'Res' => [
                    'resource' => new \EasyRdf_Resource('http://schema.org/Res', $graph),
                    'fields' => [
                        'prop' => ['isCustom' => false],
                        'customProp' => ['isCustom' => true],
                    ],
                ],
                'MyEnum' => ['resource' => $myEnum],
                'WithOperations' => [
                    'resource' => new \EasyRdf_Resource('http://schema.org/WithOperations', $graph),
                    'operations' => [
                        'item' => ['get' => ['route_name' => 'api_about_get']],
                        'collection' => [],
                    ],
                ],
            ]
        );
    }

    public function testGenerateClassAnnotations(): void
    {
        $this->assertSame(['@ApiResource(iri="http://schema.org/Res")'], $this->generator->generateClassAnnotations('Res'));
    }

    public function testGenerateClassAnnotationsWithOperations(): void
    {
        $this->assertSame(['@ApiResource(iri="http://schema.org/WithOperations", itemOperations={"get"={"route_name"="api_about_get"}}, collectionOperations={})'], $this->generator->generateClassAnnotations('WithOperations'));
    }

    public function testGenerateFieldAnnotations(): void
    {
        $this->assertSame(['@ApiProperty(iri="http://schema.org/prop")'], $this->generator->generateFieldAnnotations('Res', 'prop'));
        $this->assertSame([], $this->generator->generateFieldAnnotations('Res', 'customProp'));
    }

    public function testGenerateUses(): void
    {
        $this->assertSame(['ApiPlatform\Core\Annotation\ApiResource', 'ApiPlatform\Core\Annotation\ApiProperty'], $this->generator->generateUses('Res'));
        $this->assertSame([], $this->generator->generateUses('MyEnum'));
    }
}
