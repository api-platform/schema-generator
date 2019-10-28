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

use ApiPlatform\SchemaGenerator\AnnotationGenerator\DoctrineOrmAnnotationGenerator;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * @author Erik Saunier <erik.saunier@gmail.com>
 */
class DoctrineOrmAnnotationGeneratorTest extends TestCase
{
    /**
     * @var DoctrineOrmAnnotationGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        $graph = new \EasyRdf_Graph();
        $myEnum = new \EasyRdf_Resource('https://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $this->generator = new DoctrineOrmAnnotationGenerator(
            new NullLogger(),
            [],
            [],
            [],
            [
                'Product' => [
                    'isEnum' => false,
                    'resource' => new \EasyRdf_Resource('https://schema.org/Product', $graph),
                    'abstract' => true,
                    'embeddable' => false,
                ],
                'Vehicle' => [
                    'isEnum' => false,
                    'abstract' => false,
                    'embeddable' => false,
                    'resource' => new \EasyRdf_Resource('https://schema.org/Vehicle', $graph),
                    'fields' => [
                        'weight' => [
                            'isEnum' => false,
                            'isId' => false,
                            'isEmbedded' => true,
                            'range' => 'QuantitativeValue',
                            'columnPrefix' => false,
                        ],
                        'prefixedWeight' => [
                            'isEnum' => false,
                            'isId' => false,
                            'isEmbedded' => true,
                            'range' => 'QuantitativeValue',
                            'columnPrefix' => 'weight_',
                        ],
                    ],
                ],
                'QuantitativeValue' => [
                    'isEnum' => false,
                    'abstract' => false,
                    'name' => 'QuantitativeValue',
                    'resource' => new \EasyRdf_Resource('https://schema.org/QuantitativeValue', $graph),
                    'embeddable' => true,
                ],
                'MyEnum' => ['isEnum' => true, 'resource' => $myEnum],
            ]
        );
    }

    public function testGenerateClassAnnotations(): void
    {
        $this->assertSame([], $this->generator->generateClassAnnotations('MyEnum'));
        $this->assertSame(['', '@ORM\MappedSuperclass'], $this->generator->generateClassAnnotations('Product'));
        $this->assertSame(['', '@ORM\Entity'], $this->generator->generateClassAnnotations('Vehicle'));
        $this->assertSame(['', '@ORM\Embeddable'], $this->generator->generateClassAnnotations('QuantitativeValue'));
    }

    public function testGenerateFieldAnnotations(): void
    {
        $this->assertSame(
            ['@ORM\Embedded(class="QuantitativeValue", columnPrefix=false)'],
            $this->generator->generateFieldAnnotations('Vehicle', 'weight')
        );
        $this->assertSame(
            ['@ORM\Embedded(class="QuantitativeValue", columnPrefix="weight_")'],
            $this->generator->generateFieldAnnotations('Vehicle', 'prefixedWeight')
        );
    }
}
