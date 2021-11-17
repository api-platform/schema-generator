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
 * @author Erik Saunier <erik.saunier@gmail.com>
 */
class DoctrineOrmAnnotationGeneratorTest extends TestCase
{
    /**
     * @var DoctrineOrmAnnotationGenerator
     */
    private $generator;

    private array $classMap = [];

    protected function setUp(): void
    {
        $graph = new Graph();

        $product = new Class_('Product', new Resource('https://schema.org/Product', $graph));
        $product->setIsAbstract(true);
        $this->classMap[$product->name()] = $product;

        $vehicle = new Class_('Vehicle', new Resource('htts://schema.org/Vehicle', $graph));
        $weightProperty = new Property('weight');
        $weightProperty->isEmbedded = true;
        $weightProperty->rangeName = 'QuantitativeValue';
        $weightProperty->range = new Resource('https://schema.org/QuantitativeValue');
        $vehicle->addProperty($weightProperty);
        $prefixedWeightProperty = new Property('prefixedWeight');
        $prefixedWeightProperty->columnPrefix = 'weight_';
        $prefixedWeightProperty->isEmbedded = true;
        $prefixedWeightProperty->rangeName = 'QuantitativeValue';
        $prefixedWeightProperty->range = new Resource('https://schema.org/QuantitativeValue');
        $vehicle->addProperty($prefixedWeightProperty);
        $this->classMap[$vehicle->name()] = $vehicle;

        $quantitativeValue = new Class_('QuantitativeValue', new Resource('https://schema.org/QuantitativeValue', $graph));
        $quantitativeValue->setEmbeddable(true);
        $this->classMap[$quantitativeValue->name()] = $quantitativeValue;

        $myEnum = new Resource('https://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $myEnumClass = new Class_('MyEnum', $myEnum);
        $this->classMap[$myEnumClass->name()] = $myEnumClass;

        $this->generator = new DoctrineOrmAnnotationGenerator(
            new PhpTypeConverter(),
            new NullLogger(),
            InflectorFactory::create()->build(),
            [],
            [],
            [],
            $this->classMap
        );
    }

    public function testGenerateClassAnnotations(): void
    {
        $this->assertSame([], $this->generator->generateClassAnnotations($this->classMap['MyEnum']));
        $this->assertSame(['', '@ORM\MappedSuperclass'], $this->generator->generateClassAnnotations($this->classMap['Product']));
        $this->assertSame(['', '@ORM\Entity'], $this->generator->generateClassAnnotations($this->classMap['Vehicle']));
        $this->assertSame(['', '@ORM\Embeddable'], $this->generator->generateClassAnnotations($this->classMap['QuantitativeValue']));
    }

    public function testGenerateFieldAnnotations(): void
    {
        $this->assertSame(
            ['@ORM\Embedded(class="QuantitativeValue", columnPrefix=false)'],
            $this->generator->generatePropertyAnnotations($this->classMap['Vehicle']->getPropertyByName('weight'), 'Vehicle')
        );
        $this->assertSame(
            ['@ORM\Embedded(class="QuantitativeValue", columnPrefix="weight_")'],
            $this->generator->generatePropertyAnnotations($this->classMap['Vehicle']->getPropertyByName('prefixedWeight'), 'Vehicle')
        );
    }
}
