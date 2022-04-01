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

namespace ApiPlatform\SchemaGenerator\Tests\AttributeGenerator;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\SchemaGenerator\AttributeGenerator\ApiPlatformCoreAttributeGenerator;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use ApiPlatform\SchemaGenerator\Schema\Model\Property;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Inflector\EnglishInflector;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ApiPlatformCoreAttributeGeneratorTest extends TestCase
{
    private ApiPlatformCoreAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new ApiPlatformCoreAttributeGenerator(
            new PhpTypeConverter(),
            new EnglishInflector(),
            [],
            [],
        );
    }

    /**
     * @dataProvider provideGenerateClassAttributesCases
     */
    public function testGenerateClassAttributes(SchemaClass $class, array $attributes): void
    {
        $this->assertEquals($attributes, $this->generator->generateClassAttributes($class));
    }

    public function provideGenerateClassAttributesCases(): \Generator
    {
        yield 'classical' => [new SchemaClass('Res', new RdfResource('https://schema.org/Res', new RdfGraph())), [new Attribute('ApiResource', ['iri' => 'https://schema.org/Res'])]];

        $class = new SchemaClass('WithOperations', new RdfResource('https://schema.org/WithOperations', new RdfGraph()));
        $class->operations = [
            'item' => ['get' => ['route_name' => 'api_about_get']],
            'collection' => [],
        ];
        yield 'with operations' => [$class, [new Attribute('ApiResource', ['iri' => 'https://schema.org/WithOperations', 'itemOperations' => ['get' => ['route_name' => 'api_about_get']], 'collectionOperations' => []])]];

        $class = new SchemaClass('Abstract', new RdfResource('https://schema.org/Abstract'));
        $class->isAbstract = true;
        yield 'abstract' => [$class, []];

        $resource = new RdfResource('https://schema.org/MyEnum', new RdfGraph());
        $resource->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $class = new SchemaClass('Enum', $resource);
        yield 'enum' => [$class, []];

        yield 'with short name' => [(new SchemaClass('WithShortName', new RdfResource('https://schema.org/DifferentLocalName', new RdfGraph()))), [new Attribute('ApiResource', ['shortName' => 'DifferentLocalName', 'iri' => 'https://schema.org/DifferentLocalName'])]];

        $class = new SchemaClass('WithSecurity', new RdfResource('https://schema.org/WithSecurity', new RdfGraph()));
        $class->security = "is_granted('ROLE_USER')";
        yield 'with security' => [$class, [new Attribute('ApiResource', ['iri' => 'https://schema.org/WithSecurity', 'security' => "is_granted('ROLE_USER')"])]];
    }

    /**
     * @dataProvider provideGeneratePropertyAttributesCases
     */
    public function testGeneratePropertyAttributes(Property $property, array $attributes): void
    {
        $this->assertEquals($attributes, $this->generator->generatePropertyAttributes($property, 'Res'));
    }

    public function provideGeneratePropertyAttributesCases(): \Generator
    {
        $property = new Property('prop');
        $property->resource = new RdfResource('https://schema.org/prop');
        yield 'classical' => [$property, [new Attribute('ApiProperty', ['iri' => 'https://schema.org/prop'])]];

        $property = new Property('WithSecurity');
        $property->resource = new RdfResource('https://schema.org/WithSecurity');
        $property->security = "is_granted('ROLE_ADMIN')";
        yield 'with security' => [$property, [new Attribute('ApiProperty', ['iri' => 'https://schema.org/WithSecurity', 'security' => "is_granted('ROLE_ADMIN')"])]];
    }

    public function testGenerateCustomPropertyAttributes(): void
    {
        $this->assertSame([], $this->generator->generatePropertyAttributes((new Property('customProp'))->markAsCustom(), 'Res'));
    }

    public function testGenerateUses(): void
    {
        $this->assertEquals([new Use_(ApiResource::class), new Use_(ApiProperty::class)], $this->generator->generateUses(new SchemaClass('Res', new RdfResource('https://schema.org/Res', new RdfGraph()))));
    }
}
