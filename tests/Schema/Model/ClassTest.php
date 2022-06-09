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

namespace ApiPlatform\SchemaGenerator\Tests\Schema\Model;

use ApiPlatform\SchemaGenerator\Model\Interface_;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use ApiPlatform\SchemaGenerator\Schema\Model\Property as SchemaProperty;
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\String\Inflector\EnglishInflector;

class ClassTest extends TestCase
{
    public function testClass(): void
    {
        $inflector = new EnglishInflector();

        $property = new SchemaProperty('author');
        $property->typeHint = "App\Entity\Author";
        $property->addAnnotation('@see https://schema.org/Author');
        $class = new SchemaClass('Book', new RdfResource('http//schema.org/Book', new RdfGraph()));
        $class->namespace = 'App\Entity';
        $class->interface = new Interface_('Printable', 'OtherApp\Interfaces');
        $class->addUse(new Use_('OtherApp\Interfaces\Printable'));
        $class->addProperty($property);

        $configuration = new SchemaGeneratorConfiguration();
        $processedConfiguration = (new Processor())->processConfiguration($configuration, [[
            'doctrine' => ['useCollection' => false],
            'fluentMutatorMethods' => true,
        ]]);

        $generated = (string) $class->toNetteFile($processedConfiguration, $inflector);

        $this->assertStringContainsString('class Book', $generated);
        $this->assertStringContainsString('namespace App\Entity;', $generated);
        $this->assertStringContainsString('use OtherApp\Interfaces\Printable;', $generated);
        $this->assertStringContainsString('class Book implements Printable', $generated);
        $this->assertStringContainsString('/** @see https://schema.org/Author */', $generated);
        $this->assertStringContainsString('private ?App\Entity\Author $author = null;', $generated);
        $this->assertStringContainsString('public function setAuthor(?App\Entity\Author $author): self', $generated);
        $this->assertStringContainsString('public function getAuthor(): ?App\Entity\Author', $generated);
        $this->assertFalse($class->isEmbeddable);
        $this->assertFalse($class->hasChild);
        $this->assertFalse($class->hasParent());
        $this->assertFalse($class->hasConstructor);
        $this->assertFalse($class->isEnum());
        $this->assertFalse($class->isAbstract);
        $this->assertTrue($class->isInNamespace('App\Entity'));
        $this->assertEquals('Book', $class->shortName());
        $this->assertEquals('http//schema.org/Book', $class->rdfType());
        $this->assertEquals([], $class->constants());
        $this->assertEquals('Book', $class->name());
        $this->assertTrue($class->hasProperty('author'));
    }
}
