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

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\SchemaGenerator\AnnotationGenerator\ApiPlatformCoreAnnotationGenerator;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use Doctrine\Inflector\InflectorFactory;
use EasyRdf\Graph;
use EasyRdf\Resource;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ApiPlatformCoreAnnotationGeneratorTest extends TestCase
{
    private ApiPlatformCoreAnnotationGenerator $generator;

    protected function setUp(): void
    {
        $graph = new Graph();
        $myEnum = new Resource('https://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);

        $this->generator = new ApiPlatformCoreAnnotationGenerator(
            new PhpTypeConverter(),
            new NullLogger(),
            InflectorFactory::create()->build(),
            [],
            [],
            [],
            [
                'Res' => [
                    'resource' => new Resource('https://schema.org/Res', $graph),
                    'fields' => [
                        'prop' => [
                            'isCustom' => false,
                            'resource' => new Resource('https://schema.org/prop'),
                        ],
                        'customProp' => [
                            'isCustom' => true,
                            'resource' => new Resource('https://schema.org/customProp'),
                        ],
                    ],
                ],
                'MyEnum' => ['resource' => $myEnum],
                'WithOperations' => [
                    'resource' => new Resource('https://schema.org/WithOperations', $graph),
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
        $this->assertSame(['@ApiResource(iri="https://schema.org/Res")'], $this->generator->generateClassAnnotations('Res'));
    }

    public function testGenerateClassAnnotationsWithOperations(): void
    {
        $this->assertSame(['@ApiResource(iri="https://schema.org/WithOperations", itemOperations={"get"={"route_name"="api_about_get"}}, collectionOperations={})'], $this->generator->generateClassAnnotations('WithOperations'));
    }

    public function testGenerateFieldAnnotations(): void
    {
        $this->assertSame(['@ApiProperty(iri="https://schema.org/prop")'], $this->generator->generateFieldAnnotations('Res', 'prop'));
        $this->assertSame([], $this->generator->generateFieldAnnotations('Res', 'customProp'));
    }

    public function testGenerateUses(): void
    {
        $this->assertSame([ApiResource::class, ApiProperty::class], $this->generator->generateUses('Res'));
        $this->assertSame([], $this->generator->generateUses('MyEnum'));
    }
}
