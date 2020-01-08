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

    protected function setUp(): void
    {
        $this->fs = new Filesystem();
    }

    /**
     * @dataProvider getArguments
     */
    public function testCommand($output, $config): void
    {
        $this->fs->mkdir($output);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $output, 'config' => $config]));
    }

    public function getArguments(): array
    {
        return [
            [__DIR__.'/../../build/blog/', __DIR__.'/../config/blog.yaml'],
            [__DIR__.'/../../build/ecommerce/', __DIR__.'/../config/ecommerce.yaml'],
            [__DIR__.'/../../build/vgo/', __DIR__.'/../config/vgo.yaml'],
            [__DIR__.'/../../build/mongodb/address-book/', __DIR__.'/../config/mongodb/address-book.yaml'],
            [__DIR__.'/../../build/mongodb/ecommerce/', __DIR__.'/../config/mongodb/ecommerce.yaml'],
        ];
    }

    public function testDoctrineCollection(): void
    {
        $outputDir = __DIR__.'/../../build/address-book';
        $config = __DIR__.'/../config/address-book.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AddressBook/Entity/Person.php");
        $this->assertStringContainsString('use Doctrine\Common\Collections\ArrayCollection;', $person);
        $this->assertStringContainsString('use Doctrine\Common\Collections\Collection;', $person);

        $this->assertStringContainsString(<<<'PHP'
    public function getFriends(): Collection
    {
        return $this->friends;
    }
PHP
        , $person);
    }

    public function testFluentMutators(): void
    {
        $outputDir = __DIR__.'/../../build/fluent-mutators';
        $config = __DIR__.'/../config/fluent-mutators.yaml';
        $this->fs->mkdir($outputDir);
        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");
        $this->assertStringContainsString(<<<'PHP'
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
PHP
        , $person);

        $this->assertStringContainsString(<<<'PHP'
    public function addFriend(Person $friend): self
    {
        $this->friends[] = $friend;

        return $this;
    }

    public function removeFriend(Person $friend): self
    {
        $this->friends->removeElement($friend);

        return $this;
    }
PHP
            , $person);
    }

    public function testDoNotGenerateAccessorMethods(): void
    {
        $outputDir = __DIR__.'/../../build/public-properties';
        $config = __DIR__.'/../config/public-properties.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");
        $this->assertStringNotContainsString('function get', $person);
        $this->assertStringNotContainsString('function set', $person);
        $this->assertStringNotContainsString('function add', $person);
        $this->assertStringNotContainsString('function remove', $person);
    }

    public function testImplicitAndExplicitPropertyInheritance(): void
    {
        $outputDir = __DIR__.'/../../build/inherited-properties';
        $config = __DIR__.'/../config/inherited-properties.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $creativeWork = file_get_contents("$outputDir/AppBundle/Entity/CreativeWork.php");
        $this->assertStringContainsString('class CreativeWork extends Thing', $creativeWork);
        $this->assertStringContainsString('private $copyrightYear;', $creativeWork);
        $this->assertStringContainsString('function getCopyrightYear(', $creativeWork);
        $this->assertStringContainsString('function setCopyrightYear(', $creativeWork);
        $this->assertStringNotContainsString('private $name;', $creativeWork);
        $this->assertStringNotContainsString('function getName(', $creativeWork);
        $this->assertStringNotContainsString('function setName(', $creativeWork);

        $webPage = file_get_contents("$outputDir/AppBundle/Entity/WebPage.php");
        $this->assertStringContainsString('class WebPage extends CreativeWork', $webPage);
        $this->assertStringContainsString('private $mainEntity;', $webPage);
        $this->assertStringContainsString('function getMainEntity(', $webPage);
        $this->assertStringContainsString('function setMainEntity(', $webPage);
        $this->assertStringNotContainsString('private $copyrightYear;', $webPage);
        $this->assertStringNotContainsString('function getCopyrightYear(', $webPage);
        $this->assertStringNotContainsString('function setCopyrightYear(', $webPage);
        $this->assertStringNotContainsString('private $name;', $webPage);
        $this->assertStringNotContainsString('function getName(', $webPage);
        $this->assertStringNotContainsString('function setName(', $webPage);
    }

    public function testReadableWritable(): void
    {
        $outputDir = __DIR__.'/../../build/readable-writable';
        $config = __DIR__.'/../config/readable-writable.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");
        $this->assertStringContainsString('private $sameAs;', $person);
        $this->assertStringContainsString('public function getId(', $person);
        $this->assertStringNotContainsString('function setId(', $person);
        $this->assertStringContainsString('public function getName(', $person);
        $this->assertStringNotContainsString('function setName(', $person);
        $this->assertStringContainsString('public function getFriends(', $person);
        $this->assertStringNotContainsString('function addFriend(', $person);
        $this->assertStringNotContainsString('function removeFriend(', $person);
        $this->assertStringNotContainsString('function setSameAs(', $person);
    }

    public function testGeneratedId(): void
    {
        $outputDir = __DIR__.'/../../build/generated-id';
        $config = __DIR__.'/../config/generated-id.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertStringContainsString(<<<'PHP'
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

        $this->assertStringContainsString(<<<'PHP'
    public function getId(): ?int
    {
        return $this->id;
    }
PHP
        , $person);

        $this->assertStringNotContainsString('function setId(', $person);
    }

    public function testNonGeneratedId(): void
    {
        $outputDir = __DIR__.'/../../build/non-generated-id';
        $config = __DIR__.'/../config/non-generated-id.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertStringContainsString(<<<'PHP'
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;
PHP
            , $person);

        $this->assertStringContainsString(<<<'PHP'
    public function getId(): string
    {
        return $this->id;
    }
PHP
            , $person);

        $this->assertStringContainsString('public function setId(string $id): void', $person);
    }

    public function testGeneratedUuid(): void
    {
        $outputDir = __DIR__.'/../../build/generated-uuid';
        $config = __DIR__.'/../config/generated-uuid.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertStringContainsString(<<<'PHP'
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

        $this->assertStringContainsString(<<<'PHP'
    public function getId(): ?string
    {
        return $this->id;
    }
PHP
            , $person);

        $this->assertStringNotContainsString('function setId(', $person);
    }

    public function testNonGeneratedUuid(): void
    {
        $outputDir = __DIR__.'/../../build/non-generated-uuid';
        $config = __DIR__.'/../config/non-generated-uuid.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertStringContainsString(<<<'PHP'
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

        $this->assertStringContainsString(<<<'PHP'
    public function getId(): string
    {
        return $this->id;
    }
PHP
            , $person);

        $this->assertStringContainsString('public function setId(string $id): void', $person);
    }

    public function testDoNotGenerateId(): void
    {
        $outputDir = __DIR__.'/../../build/no-id';
        $config = __DIR__.'/../config/no-id.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AppBundle/Entity/Person.php");

        $this->assertStringNotContainsString('$id', $person);
        $this->assertStringNotContainsString('function getId', $person);
        $this->assertStringNotContainsString('function setId', $person);
    }

    public function testNamespacesPrefix(): void
    {
        $outputDir = __DIR__.'/../../build/namespaces-prefix';
        $config = __DIR__.'/../config/namespaces-prefix.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/Entity/Person.php");

        $this->assertStringContainsString('namespace App\Entity;', $person);
    }

    public function testNamespacesPrefixAutodetect(): void
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

            $this->assertStringContainsString('namespace App\Entity;', $person);
        } finally {
            chdir($currentDir);
        }
    }

    public function testGeneratedEnum(): void
    {
        $outputDir = __DIR__.'/../../build/enum';
        $config = __DIR__.'/../config/enum.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $gender = file_get_contents("$outputDir/AppBundle/Enum/GenderType.php");

        $this->assertStringContainsString(<<<'PHP'
    /**
     * @var string the female gender
     */
    public const FEMALE = 'http://schema.org/Female';
PHP
            , $gender);

        $this->assertStringNotContainsString('function setId(', $gender);
    }

    public function testSupersededProperties(): void
    {
        $outputDir = __DIR__.'/../../build/superseded-properties';
        $config = __DIR__.'/../config/superseded-properties.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateTypesCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $creativeWork = file_get_contents("$outputDir/AppBundle/Entity/CreativeWork.php");

        $this->assertStringContainsString(<<<'PHP'
    /**
     * @var string|null an award won by or for this item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/award")
     */
    private $award;
PHP
            , $creativeWork);

        $this->assertStringNotContainsString(<<<'PHP'
    /**
     * @var string|null awards won by or for this item
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $award;
PHP
            , $creativeWork);
    }
}
