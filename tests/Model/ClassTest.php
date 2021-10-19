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

namespace ApiPlatform\SchemaGenerator\Tests\Model;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Interface_;
use ApiPlatform\SchemaGenerator\Model\Property;
use Doctrine\Inflector\InflectorFactory;
use EasyRdf\Graph;
use EasyRdf\Resource;
use PHPUnit\Framework\TestCase;

class ClassTest extends TestCase
{
    public function testClass()
    {
        $inflector = InflectorFactory::create()->build();

        $property = new Property('author');
        $property->typeHint = "App\Entity\Author";
        $property->addAnnotation('@see https://schema.org/Author');
        $class = new Class_('Book', new Resource('http//schema.org/Book', new Graph()));
        $class->withNamespace("App\Entity");
        $class->withInterface(new Interface_('Printable', 'OtherApp\Interfaces'));
        $class->addUse('OtherApp\Interfaces\Printable');
        $class->addProperty($property);

        $generated = (string) $class->toNetteFile([
            'doctrine' => ['useCollection' => false],
            'accessorMethods' => true,
            'fluentMutatorMethods' => true,
        ], $inflector);

        $this->assertStringContainsString('class Book', $generated);
        $this->assertStringContainsString('namespace App\Entity;', $generated);
        $this->assertStringContainsString('use OtherApp\Interfaces\Printable;', $generated);
        $this->assertStringContainsString('class Book implements \Printable', $generated);
        $this->assertStringContainsString('/** @see https://schema.org/Author */', $generated);
        $this->assertStringContainsString('private ?Author $author = null;', $generated);
        $this->assertStringContainsString('private ?Author $author = null;', $generated);
        $this->assertStringContainsString('public function setAuthor(?Author $author): self', $generated);
        $this->assertStringContainsString('public function getAuthor(): ?Author', $generated);
        $this->assertFalse($class->isEmbeddable());
        $this->assertFalse($class->hasChild());
        $this->assertFalse($class->hasParent());
        $this->assertFalse($class->hasConstructor());
        $this->assertFalse($class->isEnum());
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInNamespace('App\Entity'));
        $this->assertEquals('Book', $class->resourceLocalName());
        $this->assertEquals('http//schema.org/Book', $class->resourceUri());
        $this->assertEquals([], $class->constants());
        $this->assertEquals('Book', $class->name());
        $this->assertTrue($class->hasProperty('author'));
    }
}
