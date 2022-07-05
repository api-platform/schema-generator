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

use ApiPlatform\Core\Annotation\ApiProperty as OldApiProperty;
use ApiPlatform\Core\Annotation\ApiResource as OldApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\SchemaGenerator\AttributeGenerator\ApiPlatformCoreAttributeGenerator;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use ApiPlatform\SchemaGenerator\Schema\Model\Property;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use Nette\PhpGenerator\Literal;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Inflector\EnglishInflector;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ApiPlatformCoreAttributeGeneratorTest extends TestCase
{
    private function generator(bool $oldAttributes = false): ApiPlatformCoreAttributeGenerator
    {
        return new ApiPlatformCoreAttributeGenerator(
            new PhpTypeConverter(),
            new EnglishInflector(),
            ['apiPlatformOldAttributes' => $oldAttributes],
            [],
        );
    }

    /**
     * @dataProvider provideGenerateClassAttributesCases
     */
    public function testGenerateClassAttributes(SchemaClass $class, array $attributes, bool $oldAttributes = false): void
    {
        $this->assertEquals($attributes, $this->generator($oldAttributes)->generateClassAttributes($class));
    }

    public function provideGenerateClassAttributesCases(): \Generator
    {
        yield 'classical' => [new SchemaClass('Res', new RdfResource('https://schema.org/Res', new RdfGraph())), [new Attribute('ApiResource', ['types' => ['https://schema.org/Res']])]];

        yield 'classical (old)' => [new SchemaClass('Res', new RdfResource('https://schema.org/Res', new RdfGraph())), [new Attribute('ApiResource', ['iri' => 'https://schema.org/Res'])], true];

        $class = new SchemaClass('WithOperations', new RdfResource('https://schema.org/WithOperations', new RdfGraph()));
        $class->operations = [
            'Get' => ['routeName' => 'api_about_get'],
        ];
        yield 'with operations' => [$class, [new Attribute('ApiResource', ['types' => ['https://schema.org/WithOperations'], 'operations' => [new Literal('new Get(...?:)', [['routeName' => 'api_about_get']])]])]];

        $class = new SchemaClass('WithOperations', new RdfResource('https://schema.org/WithOperations', new RdfGraph()));
        $class->operations = [
            'item' => ['get' => ['route_name' => 'api_about_get']],
            'collection' => [],
        ];
        yield 'with operations (old)' => [$class, [new Attribute('ApiResource', ['iri' => 'https://schema.org/WithOperations', 'itemOperations' => ['get' => ['route_name' => 'api_about_get']], 'collectionOperations' => []])], true];

        $class = new SchemaClass('HasChild', new RdfResource('https://schema.org/HasChild'));
        $class->hasChild = true;
        yield 'has child' => [$class, []];

        $resource = new RdfResource('https://schema.org/MyEnum', new RdfGraph());
        $resource->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $class = new SchemaClass('Enum', $resource);
        yield 'enum' => [$class, []];

        yield 'with short name' => [(new SchemaClass('WithShortName', new RdfResource('https://schema.org/DifferentLocalName', new RdfGraph()))), [new Attribute('ApiResource', ['shortName' => 'DifferentLocalName', 'types' => ['https://schema.org/DifferentLocalName']])]];
    }

    /**
     * @dataProvider provideGeneratePropertyAttributesCases
     */
    public function testGeneratePropertyAttributes(Property $property, array $attributes, bool $oldAttributes = false): void
    {
        $this->assertEquals($attributes, $this->generator($oldAttributes)->generatePropertyAttributes($property, 'Res'));
    }

    public function provideGeneratePropertyAttributesCases(): \Generator
    {
        $property = new Property('prop');
        $property->resource = new RdfResource('https://schema.org/prop');
        yield 'classical' => [$property, [new Attribute('ApiProperty', ['types' => ['https://schema.org/prop']])]];

        $property = new Property('prop');
        $property->resource = new RdfResource('https://schema.org/prop');
        yield 'classical (old)' => [$property, [new Attribute('ApiProperty', ['iri' => 'https://schema.org/prop'])], true];
    }

    public function testGenerateCustomPropertyAttributes(): void
    {
        $this->assertSame([], $this->generator()->generatePropertyAttributes((new Property('customProp'))->markAsCustom(), 'Res'));
    }

    public function testGenerateUses(): void
    {
        $this->assertEquals([
            new Use_(OldApiResource::class),
            new Use_(OldApiProperty::class),
        ], $this->generator(true)->generateUses(new SchemaClass('Res', new RdfResource('https://schema.org/Res', new RdfGraph()))));

        $this->assertEquals([
            new Use_(ApiResource::class),
            new Use_(ApiProperty::class),
            new Use_(Get::class),
            new Use_(Put::class),
            new Use_(Patch::class),
            new Use_(Delete::class),
            new Use_(GetCollection::class),
            new Use_(Post::class),
        ], $this->generator()->generateUses(new SchemaClass('Res', new RdfResource('https://schema.org/Res', new RdfGraph()))));
    }
}
