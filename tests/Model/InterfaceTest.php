<?php

namespace ApiPlatform\SchemaGenerator\Tests\Model;

use ApiPlatform\SchemaGenerator\Model\Interface_;
use PHPUnit\Framework\TestCase;

class InterfaceTest extends TestCase
{
    public function testInterface()
    {
        $interface = new Interface_("Printable", "App\Entity");
        $interface->addAnnotation("@see description");

        $this->assertEquals($interface->name(), "Printable");
        $this->assertEquals($interface->namespace(), "App\Entity");
        $generated = (string) $interface->toNetteFile($fileHeader = "Package interfaces");
        $this->assertStringContainsString("Package interfaces", $generated);
        $this->assertStringContainsString("declare(strict_types=1);", $generated);
        $this->assertStringContainsString("namespace App\Entity", $generated);
        $this->assertStringContainsString("interface Printable", $generated);
    }
}
