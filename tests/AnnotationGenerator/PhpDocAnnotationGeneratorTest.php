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

use ApiPlatform\SchemaGenerator\AnnotationGenerator\PhpDocAnnotationGenerator;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Interface_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Type\ArrayType;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use ApiPlatform\SchemaGenerator\Schema\Model\Property as SchemaProperty;
use ApiPlatform\SchemaGenerator\Schema\Model\Type\PrimitiveType as SchemaPrimitiveType;
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\String\Inflector\EnglishInflector;

class PhpDocAnnotationGeneratorTest extends TestCase
{
    private PhpDocAnnotationGenerator $generator;

    protected function setUp(): void
    {
        $configuration = new SchemaGeneratorConfiguration();
        $processedConfiguration = (new Processor())->processConfiguration($configuration, [[
            'author' => 'Bill',
        ]]);

        $this->generator = new PhpDocAnnotationGenerator(
            new PhpTypeConverter(),
            new EnglishInflector(),
            $processedConfiguration,
            [],
        );
    }

    /**
     * @dataProvider provideGenerateClassAnnotationsCases
     */
    public function testGenerateClassAnnotations(Class_ $class, array $annotations): void
    {
        $this->assertSame($annotations, $this->generator->generateClassAnnotations($class));
    }

    public function provideGenerateClassAnnotationsCases(): \Generator
    {
        $class = new SchemaClass('Res', new RdfResource('https://schema.org/Res'));
        $class->interface = new Interface_('Interface', '/foo');
        yield 'with interface' => [$class, ['{@inheritdoc}', '', '@author Bill']];

        $graph = new RdfGraph();
        yield 'with resource' => [new SchemaClass('Res', new RdfResource('https://schema.org/Res', $graph)), ['@see https://schema.org/Res', '@author Bill']];
    }

    /**
     * @dataProvider provideGeneratePropertyAnnotationsCases
     */
    public function testGeneratePropertyAnnotations(Property $property, string $className, array $annotations): void
    {
        $this->assertSame($annotations, $this->generator->generatePropertyAnnotations($property, $className));
    }

    public function provideGeneratePropertyAnnotationsCases(): \Generator
    {
        $property = new SchemaProperty('telephone');
        $graph = new RdfGraph();
        $resource = new RdfResource('https://schema.org/telephone', $graph);
        $resource->addResource('rdfs:comment', 'The telephone <b>number</b>.<br>@number');
        $property->resource = $resource;

        yield 'property with description' => [$property, 'Place', ['The telephone **number**.  ', '   \@number', '', '@see https://schema.org/telephone', '']];

        $property = new SchemaProperty('review');
        $graph = new RdfGraph();
        $resource = new RdfResource('https://schema.org/review', $graph);
        $resource->addResource('rdfs:comment', 'A review of the item.');
        $property->resource = $resource;
        $property->typeHint = 'array';
        $property->type = new ArrayType(new SchemaPrimitiveType('string'));
        $property->range = new RdfResource('https://schema.org/Text');

        yield 'array of strings property' => [$property, 'Place', ['@var string[]|null A review of the item.', '@see https://schema.org/review', '']];

        $property = new SchemaProperty('address');
        $graph = new RdfGraph();
        $property->isNullable = false;
        $property->typeHint = 'array';
        $property->type = new ArrayType();
        $property->reference = new SchemaClass('PostalAddress', new RdfResource('https://schema.org/PostalAddress', $graph));

        yield 'reference property' => [$property, 'Place', ['@var Collection<PostalAddress> ', '']];
    }
}
