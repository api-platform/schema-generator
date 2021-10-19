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
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
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
        $this->generator = new ApiPlatformCoreAnnotationGenerator(
            new PhpTypeConverter(),
            new NullLogger(),
            InflectorFactory::create()->build(),
            [],
            [],
            [],
            [],
        );
    }

    public function testGenerateClassAnnotations(): void
    {
        $this->assertSame(['@ApiResource(iri="http://schema.org/Res")'], $this->generator->generateClassAnnotations(new Class_('Res', new Resource('http://schema.org/Res'))));
    }

    public function testGenerateClassAnnotationsWithOperations(): void
    {
        $class = new Class_('WithOperations', new Resource('http://schema.org/WithOperations'));
        $class->setOperations([
            'item' => ['get' => ['route_name' => 'api_about_get']],
            'collection' => [],
        ]);

        $this->assertSame(
            ['@ApiResource(iri="http://schema.org/WithOperations", itemOperations={"get"={"route_name"="api_about_get"}}, collectionOperations={})'],
            $this->generator->generateClassAnnotations($class)
        );
    }

    public function testGeneratePropertyAnnotations(): void
    {
        $property = new Property('prop');
        $property->resource = new Resource('http://schema.org/prop');

        $this->assertSame(['@ApiProperty(iri="http://schema.org/prop")'], $this->generator->generatePropertyAnnotations($property, 'Res'));
    }

    public function testGenerateCustomPropertyAnnotations(): void
    {
        $this->assertSame([], $this->generator->generatePropertyAnnotations((new Property('customProp'))->markAsCustom(), 'Res'));
    }

    public function testGenerateUses(): void
    {
        $this->assertSame([ApiResource::class, ApiProperty::class], $this->generator->generateUses(new Class_('Res', new Resource('http://schema.org/Res', new Graph()))));
    }

    public function testGenerateNoUsesForEnum(): void
    {
        $graph = new Graph();
        $myEnum = new Resource('http://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $this->assertSame([], $this->generator->generateUses(new Class_('MyEnum', $myEnum)));
    }
}
