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
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use Doctrine\Inflector\InflectorFactory;
use EasyRdf\Graph;
use EasyRdf\Resource;
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
        $this->assertSame($attributes, $this->generator->generateClassAttributes($class));
    }

    public function provideGenerateClassAttributesCases(): \Generator
    {
        $graph = new Graph();
        $resource = new Resource('https://schema.org/Enum', $graph);
        $resource->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);

        yield 'enum' => [new Class_('Enum', $resource), []];

        $graph = new Graph();
        $class = new Class_('Foo', new Resource('https://schema.org/Foo', $graph));
        $uniqueProperty = new Property('bar');
        $uniqueProperty->isUnique = true;
        $class->addProperty($uniqueProperty);

        yield 'one unique property' => [$class, [['UniqueEntity' => ['bar']]]];

        $graph = new Graph();
        $class = new Class_('Foo', new Resource('https://schema.org/Foo', $graph));
        $uniqueProperty = new Property('bar');
        $uniqueProperty->isUnique = true;
        $class->addProperty($uniqueProperty);
        $uniqueProperty = new Property('baz');
        $uniqueProperty->isUnique = true;
        $class->addProperty($uniqueProperty);

        yield 'multiple unique properties' => [$class, [['UniqueEntity' => ['fields' => ['bar', 'baz']]]]];
    }

    /**
     * @dataProvider provideGeneratePropertyAttributesCases
     */
    public function testGeneratePropertyAttributes(Property $property, array $attributes): void
    {
        $this->assertSame($attributes, $this->generator->generatePropertyAttributes($property, 'Res'));
    }

    public function provideGeneratePropertyAttributesCases(): \Generator
    {
        $property = new Property('prop');
        $property->isId = true;
        yield 'uuid' => [$property, [['Assert\Uuid' => []]]];

        $property = new Property('prop');
        $property->range = new Resource('https://schema.org/email');
        $property->resource = new Resource('https://schema.org/email');
        $property->isNullable = false;
        yield 'email' => [$property, [['Assert\Email' => []], ['Assert\NotNull' => []]]];

        $property = new Property('prop');
        $property->range = new Resource('https://schema.org/Enum');
        $property->rangeName = 'Enum';
        $property->isEnum = true;
        $property->isArray = true;
        yield 'enum' => [$property, [['Assert\Choice' => ['callback' => ['Enum', 'toArray'], 'multiple' => true]]]];
    }

    public function testGenerateUses(): void
    {
        $this->assertSame(['Symfony\Component\Validator\Constraints as Assert', UniqueEntity::class], $this->generator->generateUses(new Class_('Res', new Resource('https://schema.org/Res', new Graph()))));
    }

    public function testGenerateNoUsesForEnum(): void
    {
        $graph = new Graph();
        $myEnum = new Resource('https://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $this->assertSame([], $this->generator->generateUses(new Class_('MyEnum', $myEnum)));
    }
}
