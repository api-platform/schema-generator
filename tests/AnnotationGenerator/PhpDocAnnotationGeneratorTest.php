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
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Inflector\EnglishInflector;

class PhpDocAnnotationGeneratorTest extends TestCase
{
    private PhpDocAnnotationGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new PhpDocAnnotationGenerator(
            new PhpTypeConverter(),
            new EnglishInflector(),
            ['author' => 'Bill'],
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
}
