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
            [__DIR__.'/../../build/blog/', __DIR__.'/../config/blog.yaml'],
            [__DIR__.'/../../build/ecommerce/', __DIR__.'/../config/ecommerce.yaml'],
            [__DIR__.'/../../build/vgo/', __DIR__.'/../config/vgo.yaml'],
            [__DIR__.'/../../build/mongodb/address-book/', __DIR__.'/../config/mongodb/address-book.yaml'],
            [__DIR__.'/../../build/mongodb/ecommerce/', __DIR__.'/../config/mongodb/ecommerce.yaml'],
        ];
    }

    public function testDoctrineCollection()
    {
        $outputDir = __DIR__.'/../../build/address-book';
        $config = __DIR__.'/../config/address-book.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AddressBook/Entity/Person.php");
        $this->assertContains('use Doctrine\Common\Collections\ArrayCollection;', $person);
        $this->assertContains('use Doctrine\Common\Collections\Collection;', $person);

        $this->assertContains(<<<'PHP'
    public function getFriends(): Collection
    {
        return $this->friends;
    }
PHP
            , $person);
    }

    public function testFluentMutators()
    {
        $outputDir = __DIR__.'/../../build/fluent-mutators';
        $config = __DIR__.'/../config/fluent-mutators.yaml';
        $this->fs->mkdir($outputDir);
        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");
        $this->assertContains(<<<'PHP'
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
PHP
        , $person);

        $this->assertContains(<<<'PHP'
    public function addFriend(self $friend): self
    {
        $this->friends[] = $friend;

        return $this;
    }

    public function removeFriend(self $friend): self
    {
        $this->friends->removeElement($friend);

        return $this;
    }
PHP
            , $person);
    }

    public function testDoNotGenerateAccessorMethods()
    {
        $outputDir = __DIR__.'/../../build/public-properties';
        $config = __DIR__.'/../config/public-properties.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");
        $this->assertNotContains('function get', $person);
        $this->assertNotContains('function set', $person);
        $this->assertNotContains('function add', $person);
        $this->assertNotContains('function remove', $person);
    }

    public function testReadableWritable()
    {
        $outputDir = __DIR__.'/../../build/readable-writable';
        $config = __DIR__.'/../config/readable-writable.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");
        $this->assertContains('public function getId(', $person);
        $this->assertNotContains('function setId(', $person);
        $this->assertContains('public function getName(', $person);
        $this->assertNotContains('function setName(', $person);
        $this->assertContains('public function getFriends(', $person);
        $this->assertNotContains('function addFriend(', $person);
        $this->assertNotContains('function removeFriend(', $person);
    }

    public function testGeneratedId()
    {
        $outputDir = __DIR__.'/../../build/generated-id';
        $config = __DIR__.'/../config/generated-id.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertContains(<<<'PHP'
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
PHP
            , $person);

        $this->assertContains(<<<'PHP'
    public function getId(): ?int
    {
        return $this->id;
    }
PHP
        , $person);

        $this->assertNotContains('function setId(', $person);
    }

    public function testNonGeneratedId()
    {
        $outputDir = __DIR__.'/../../build/non-generated-id';
        $config = __DIR__.'/../config/non-generated-id.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertContains(<<<'PHP'
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;
PHP
            , $person);

        $this->assertContains(<<<'PHP'
    public function getId(): string
    {
        return $this->id;
    }
PHP
            , $person);

        $this->assertContains('public function setId(string $id): void', $person);
    }

    public function testGeneratedUuid()
    {
        $outputDir = __DIR__.'/../../build/generated-uuid';
        $config = __DIR__.'/../config/generated-uuid.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertContains(<<<'PHP'
    /**
     * @var string|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     * @Assert\Uuid
     */
    private $id;
PHP
            , $person);

        $this->assertContains(<<<'PHP'
    public function getId(): ?string
    {
        return $this->id;
    }
PHP
            , $person);

        $this->assertNotContains('function setId(', $person);
    }

    public function testNonGeneratedUuid()
    {
        $outputDir = __DIR__.'/../../build/non-generated-uuid';
        $config = __DIR__.'/../config/non-generated-uuid.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertContains(<<<'PHP'
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @Assert\Uuid
     */
    private $id;
PHP
            , $person);

        $this->assertContains(<<<'PHP'
    public function getId(): string
    {
        return $this->id;
    }
PHP
            , $person);

        $this->assertContains('public function setId(string $id): void', $person);
    }

    public function testDoNotGenerateId()
    {
        $outputDir = __DIR__.'/../../build/no-id';
        $config = __DIR__.'/../config/no-id.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertNotContains('$id', $person);
        $this->assertNotContains('function getId', $person);
        $this->assertNotContains('function setId', $person);
    }

    public function testNamespacesPrefix()
    {
        $outputDir = __DIR__.'/../../build/namespaces-prefix';
        $config = __DIR__.'/../config/namespaces-prefix.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/Entity/Person.php");

        $this->assertContains('namespace App\Entity;', $person);
    }

    public function testNamespacesPrefixAutodetect()
    {
        $outputDir = __DIR__.'/../../build/namespaces-prefix-autodetect/';

        $this->fs->mkdir($outputDir);
        $this->fs->copy(__DIR__.'/../config/namespaces-prefix-autodetect/composer.json', "$outputDir/composer.json");
        $this->fs->copy(__DIR__.'/../config/namespaces-prefix-autodetect/schema.yaml', "$outputDir/schema.yaml");

        $currentDir = getcwd();
        chdir($outputDir);
        try {
            $commandTester = new CommandTester(new GenerateTypesCommand());
            $this->assertEquals(0, $commandTester->execute([]));

            $person = file_get_contents("$outputDir/src/Entity/Person.php");

            $this->assertContains('namespace App\Entity;', $person);
        } finally {
            chdir($currentDir);
        }
    }
}
