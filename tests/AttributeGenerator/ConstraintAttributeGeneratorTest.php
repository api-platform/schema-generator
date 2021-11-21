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

use ApiPlatform\SchemaGenerator\AttributeGenerator\ConstraintAttributeGenerator;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use Doctrine\Inflector\InflectorFactory;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class ConstraintAttributeGeneratorTest extends TestCase
{
    private ConstraintAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new ConstraintAttributeGenerator(
            new PhpTypeConverter(),
            new NullLogger(),
            InflectorFactory::create()->build(),
            [],
            [],
            ['id' => ['generationStrategy' => 'uuid']],
            [],
        );
    }

    /**
     * @dataProvider provideGenerateClassAttributesCases
     */
    public function testGenerateClassAttributes(Class_ $class, array $attributes): void
    {
        $this->assertEquals($attributes, $this->generator->generateClassAttributes($class));
    }

    public function provideGenerateClassAttributesCases(): \Generator
    {
        $graph = new RdfGraph();
        $resource = new RdfResource('https://schema.org/Enum', $graph);
        $resource->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);

        yield 'enum' => [new Class_('Enum', $resource), []];

        $graph = new RdfGraph();
        $class = new Class_('Foo', new RdfResource('https://schema.org/Foo', $graph));
        $uniqueProperty = new Property('bar');
        $uniqueProperty->isUnique = true;
        $class->addProperty($uniqueProperty);

        yield 'one unique property' => [$class, [new Attribute('UniqueEntity', ['bar'])]];

        $graph = new RdfGraph();
        $class = new Class_('Foo', new RdfResource('https://schema.org/Foo', $graph));
        $uniqueProperty = new Property('bar');
        $uniqueProperty->isUnique = true;
        $class->addProperty($uniqueProperty);
        $uniqueProperty = new Property('baz');
        $uniqueProperty->isUnique = true;
        $class->addProperty($uniqueProperty);

        yield 'multiple unique properties' => [$class, [new Attribute('UniqueEntity', ['fields' => ['bar', 'baz']])]];
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
        $property->isId = true;
        yield 'uuid' => [$property, [new Attribute('Assert\Uuid')]];

        $property = new Property('prop');
        $property->range = new RdfResource('https://schema.org/email');
        $property->resource = new RdfResource('https://schema.org/email');
        $property->isNullable = false;
        yield 'email' => [$property, [new Attribute('Assert\Email'), new Attribute('Assert\NotNull')]];

        $property = new Property('prop');
        $property->range = new RdfResource('https://schema.org/Enum');
        $property->rangeName = 'Enum';
        $property->isEnum = true;
        $property->isArray = true;
        yield 'enum' => [$property, [new Attribute('Assert\Choice', ['callback' => ['Enum', 'toArray'], 'multiple' => true])]];
    }

    public function testGenerateUses(): void
    {
        $this->assertEquals([new Use_('Symfony\Component\Validator\Constraints', 'Assert'), new Use_(UniqueEntity::class)], $this->generator->generateUses(new Class_('Res', new RdfResource('https://schema.org/Res', new RdfGraph()))));
    }

    public function testGenerateNoUsesForEnum(): void
    {
        $graph = new RdfGraph();
        $myEnum = new RdfResource('https://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $this->assertSame([], $this->generator->generateUses(new Class_('MyEnum', $myEnum)));
    }
}
