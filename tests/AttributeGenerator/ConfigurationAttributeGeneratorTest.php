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

use ApiPlatform\SchemaGenerator\AttributeGenerator\ConfigurationAttributeGenerator;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use ApiPlatform\SchemaGenerator\Schema\Model\Property;
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Inflector\EnglishInflector;

class ConfigurationAttributeGeneratorTest extends TestCase
{
    /**
     * @dataProvider provideGenerateClassAttributesCases
     */
    public function testGenerateClassAttributes(SchemaClass $class, array $config, array $attributes): void
    {
        $this->assertEquals($attributes, $this->generator($config)->generateClassAttributes($class));
    }

    public function provideGenerateClassAttributesCases(): \Generator
    {
        $class = new SchemaClass('Foo', new RdfResource('https://schema.org/Foo', new RdfGraph()));

        yield 'no configuration' => [$class, [], []];

        $class = new SchemaClass('Foo', new RdfResource('https://schema.org/Foo', new RdfGraph()));

        yield 'type configuration' => [
            $class,
            ['types' => ['Foo' => ['attributes' => [['ApiResource' => ['routePrefix' => '/prefix']]]]]],
            [new Attribute('ApiResource', ['routePrefix' => '/prefix', 'mergeable' => false])],
        ];

        $class = new SchemaClass('Foo', new RdfResource('https://schema.org/Foo', new RdfGraph(SchemaGeneratorConfiguration::SCHEMA_ORG_URI)));
        $expectedAttribute = new Attribute('ApiResource', ['routePrefix' => '/prefix']);
        $expectedAttribute->append = false;
        $expectedAttribute->mergeable = false;

        yield 'vocab configuration' => [
            $class,
            ['vocabularies' => [SchemaGeneratorConfiguration::SCHEMA_ORG_URI => ['attributes' => [['ApiResource' => ['routePrefix' => '/prefix']]]]]],
            [$expectedAttribute],
        ];

        $class = new SchemaClass('Foo', new RdfResource('https://schema.org/Foo', new RdfGraph(SchemaGeneratorConfiguration::SCHEMA_ORG_URI)));

        yield 'vocab and type configuration' => [
            $class,
            [
                'vocabularies' => [SchemaGeneratorConfiguration::SCHEMA_ORG_URI => ['attributes' => [['ApiResource' => ['routePrefix' => '/prefix']]]]],
                'types' => ['Foo' => ['attributes' => [['ApiResource' => ['security' => "is_granted('ROLE_USER')"]]]]],
            ],
            [new Attribute('ApiResource', ['security' => "is_granted('ROLE_USER')", 'mergeable' => false])],
        ];
    }

    /**
     * @dataProvider provideGeneratePropertyAttributesCases
     */
    public function testGeneratePropertyAttributes(Property $property, array $config, array $attributes): void
    {
        $this->assertEquals($attributes, $this->generator($config)->generatePropertyAttributes($property, 'Res'));
    }

    public function provideGeneratePropertyAttributesCases(): \Generator
    {
        $property = new Property('prop');

        yield 'no configuration' => [$property, [], []];

        $property = new Property('prop');

        yield 'type configuration' => [
            $property,
            ['types' => ['Res' => ['properties' => ['prop' => ['attributes' => [['ApiResource' => ['security' => "is_granted('ROLE_USER')"]]]]]]]],
            [new Attribute('ApiResource', ['security' => "is_granted('ROLE_USER')", 'mergeable' => false])],
        ];
    }

    /**
     * @dataProvider provideGenerateUsesCases
     */
    public function testGenerateUses(SchemaClass $class, array $config, array $uses): void
    {
        $this->assertEquals($uses, $this->generator($config)->generateUses($class));
    }

    public function provideGenerateUsesCases(): \Generator
    {
        $class = new SchemaClass('Foo', new RdfResource('https://schema.org/Foo', new RdfGraph()));

        yield 'no configuration' => [$class, ['uses' => []], []];

        $class = new SchemaClass('Foo', new RdfResource('https://schema.org/Foo', new RdfGraph()));

        yield 'type configuration' => [
            $class,
            ['uses' => ['Symfony\Component\Validator\Constraints' => ['alias' => 'Assert']]],
            [new Use_('Symfony\Component\Validator\Constraints', 'Assert')],
        ];
    }

    private function generator(array $config = []): ConfigurationAttributeGenerator
    {
        return new ConfigurationAttributeGenerator(
            new PhpTypeConverter(),
            new EnglishInflector(),
            $config,
            [],
        );
    }
}
