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

namespace ApiPlatform\SchemaGenerator\Tests\Command;

use ApiPlatform\SchemaGenerator\Command\GenerateTypesCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class GenerateTypesCommandTest extends TestCase
{
    /**
     * @var Filesystem
     */
    private $fs;

    public function setUp()
    {
        $this->fs = new Filesystem();
    }

    /**
     * @dataProvider getArguments
     */
    public function testCommand($output, $config)
    {
        $this->fs->mkdir($output);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $output, 'config' => $config]));
    }

    public function getArguments()
    {
        return [
            [__DIR__.'/../../build/address-book/', __DIR__.'/../config/address-book.yaml'],
            [__DIR__.'/../../build/blog/', __DIR__.'/../config/blog.yaml'],
            [__DIR__.'/../../build/ecommerce/', __DIR__.'/../config/ecommerce.yaml'],
            [__DIR__.'/../../build/vgo/', __DIR__.'/../config/vgo.yaml'],
            [__DIR__.'/../../build/mongodb/address-book/', __DIR__.'/../config/mongodb/address-book.yaml'],
            [__DIR__.'/../../build/mongodb/ecommerce/', __DIR__.'/../config/mongodb/ecommerce.yaml'],
        ];
    }

    public function testFluentMutators()
    {
        $outputDir = __DIR__.'/../../build/fluent-mutators';
        $config = __DIR__.'/../config/fluent-mutators.yaml';
        $this->fs->mkdir($outputDir);
        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));
        $organization = file_get_contents($outputDir.'/AppBundle/Entity/Person.php');
        $this->assertContains(<<<'PHP'
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
PHP
            , $organization);
        $this->assertContains(<<<'PHP'
    public function addFriends(Person $friends): self
    {
        $this->friends[] = $friends;

        return $this;
    }

    public function removeFriends(Person $friends): self
    {
        $this->friends->removeElement($friends);

        return $this;
    }
PHP
            , $organization);
    }

    public function testDoNotGenerateAccessorMethods()
    {
        $outputDir = __DIR__.'/../../build/public-properties';
        $config = __DIR__.'/../config/public-properties.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $organization = file_get_contents($outputDir.'/AppBundle/Entity/Person.php');
        $this->assertNotContains('function get', $organization);
        $this->assertNotContains('function set', $organization);
        $this->assertNotContains('function add', $organization);
        $this->assertNotContains('function remove', $organization);
    }
}
