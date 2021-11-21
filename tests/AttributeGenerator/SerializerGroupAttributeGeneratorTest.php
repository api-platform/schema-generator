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

use ApiPlatform\SchemaGenerator\AttributeGenerator\SerializerGroupsAttributeGenerator;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use Doctrine\Inflector\InflectorFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class SerializerGroupAttributeGeneratorTest extends TestCase
{
    private SerializerGroupsAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new SerializerGroupsAttributeGenerator(
            new PhpTypeConverter(),
            new NullLogger(),
            InflectorFactory::create()->build(),
            [],
            [],
            [],
            [],
        );
    }

    public function testGeneratePropertyAttributes(): void
    {
        $property = new Property('prop');
        $property->isId = false;
        $property->groups = ['group'];

        $this->assertEquals([new Attribute('Groups', [['group']])], $this->generator->generatePropertyAttributes($property, 'Res'));
    }
}
