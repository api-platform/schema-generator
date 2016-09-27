<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator\Tests;

use ApiPlatform\SchemaGenerator\Command\GenerateTypesCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class GenerateTypesCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filesystem
     */
    private $fs;

    public function setUp()
    {
        $this->fs = new Filesystem();
        $this->fs->remove(__DIR__.'/../../build/');
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
            [__DIR__.'/../../build/address-book/', __DIR__.'/../config/address-book.yml'],
            [__DIR__.'/../../build/blog/', __DIR__.'/../config/blog.yml'],
            [__DIR__.'/../../build/ecommerce/', __DIR__.'/../config/ecommerce.yml'],
            [__DIR__.'/../../build/vgo/', __DIR__.'/../config/vgo.yml'],
            [__DIR__.'/../../build/mongodb/address-book/', __DIR__.'/../config/mongodb/address-book.yml'],
            [__DIR__.'/../../build/mongodb/ecommerce/', __DIR__.'/../config/mongodb/ecommerce.yml'],
        ];
    }
}
