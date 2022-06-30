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

use ApiPlatform\SchemaGenerator\Command\GenerateCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class GenerateCommandTest extends TestCase
{
    private Filesystem $fs;

    protected function setUp(): void
    {
        $this->fs = new Filesystem();
    }

    /**
     * @dataProvider getArguments
     */
    public function testCommand(string $output, string $config): void
    {
        $this->fs->mkdir($output);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $output, 'config' => $config]));
    }

    public function getArguments(): iterable
    {
        yield 'blog' => [__DIR__.'/../../build/blog/', __DIR__.'/../config/blog.yaml'];
        yield 'ecommerce' => [__DIR__.'/../../build/ecommerce/', __DIR__.'/../config/ecommerce.yaml'];
        yield 'vgo' => [__DIR__.'/../../build/vgo/', __DIR__.'/../config/vgo.yaml'];
        yield 'address-book' => [__DIR__.'/../../build/mongodb/address-book/', __DIR__.'/../config/mongodb/address-book.yaml'];
        yield 'mongodb-ecommerce' => [__DIR__.'/../../build/mongodb/ecommerce/', __DIR__.'/../config/mongodb/ecommerce.yaml'];
    }

    public function testDoctrineCollection(): void
    {
        $outputDir = __DIR__.'/../../build/address-book';
        $config = __DIR__.'/../config/address-book.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/AddressBook/Entity/Person.php");
        $this->assertStringContainsString('use Doctrine\Common\Collections\ArrayCollection;', $person);
        $this->assertStringContainsString('use Doctrine\Common\Collections\Collection;', $person);
        $this->assertStringNotContainsString('extends', $person);

        $this->assertStringContainsString(<<<'PHP'
    public function getFriends(): Collection
    {
        return $this->friends;
    }
PHP
        , $person);
    }

    public function testCustomAttributes(): void
    {
        $outputDir = __DIR__.'/../../build/custom-attributes';
        $config = __DIR__.'/../config/custom-attributes.yaml';
        $this->fs->mkdir($outputDir);
        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $book = file_get_contents("$outputDir/App/Entity/Book.php");

        // Attributes given as ordered map (omap).
        $this->assertStringContainsString(<<<'PHP'
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Attributes\MyAttribute;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A book.
 *
 * @see https://schema.org/Book
 */
#[ORM\Entity]
#[ApiResource(types: ['https://schema.org/Book'], routePrefix: '/library')]
#[MyAttribute]
class Book
{
PHP
        , $book);

        // Attributes given as unordered map.
        $this->assertStringContainsString(<<<'PHP'
    #[ORM\OneToMany(targetEntity: 'App\Entity\Review', mappedBy: 'book', cascade: ['persist', 'remove'])]
PHP
        , $book);
        $this->assertStringContainsString(<<<'PHP'
    #[ORM\OrderBy(name: 'ASC')]
PHP
        , $book);
    }

    public function testFluentMutators(): void
    {
        $outputDir = __DIR__.'/../../build/fluent-mutators';
        $config = __DIR__.'/../config/fluent-mutators.yaml';
        $this->fs->mkdir($outputDir);
        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/App/Entity/Person.php");
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

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/App/Entity/Person.php");
        $this->assertStringContainsString('public ?string $name', $person);
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

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $creativeWork = file_get_contents("$outputDir/App/Entity/CreativeWork.php");
        $this->assertStringContainsString('class CreativeWork extends Thing', $creativeWork);
        $this->assertStringContainsString('private ?string $copyrightYear = null;', $creativeWork);
        $this->assertStringContainsString('public function getCopyrightYear(): ?string', $creativeWork);
        $this->assertStringContainsString('public function setCopyrightYear(?string $copyrightYear): void', $creativeWork);
        $this->assertStringNotContainsString('$name;', $creativeWork);
        $this->assertStringNotContainsString('getName(', $creativeWork);
        $this->assertStringNotContainsString('setName(', $creativeWork);

        $webPage = file_get_contents("$outputDir/App/Entity/WebPage.php");
        $this->assertStringContainsString('class WebPage extends CreativeWork', $webPage);
        $this->assertStringContainsString('private ?string $relatedLink = null;', $webPage);
        $this->assertStringContainsString('public function getRelatedLink(): ?string', $webPage);
        $this->assertStringContainsString('public function setRelatedLink(?string $relatedLink): void', $webPage);
        $this->assertStringNotContainsString('$copyrightYear;', $webPage);
        $this->assertStringNotContainsString('getCopyrightYear(', $webPage);
        $this->assertStringNotContainsString('setCopyrightYear(', $webPage);
        $this->assertStringNotContainsString('$name;', $webPage);
        $this->assertStringNotContainsString('getName(', $webPage);
        $this->assertStringNotContainsString('setName(', $webPage);
    }

    public function testReadableWritable(): void
    {
        $outputDir = __DIR__.'/../../build/readable-writable';
        $config = __DIR__.'/../config/readable-writable.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/App/Entity/Person.php");
        $this->assertStringContainsString('private ?string $sameAs = null;', $person);
        $this->assertStringContainsString('public function getId(): ?int', $person);
        $this->assertStringNotContainsString('setId(', $person);
        $this->assertStringContainsString('private ?string $name = null;', $person);
        $this->assertStringContainsString('public function getName(): ?string', $person);
        $this->assertStringNotContainsString('setName(', $person);
        $this->assertStringContainsString('public function getFriends(', $person);
        $this->assertStringNotContainsString('addFriend(', $person);
        $this->assertStringNotContainsString('removeFriend(', $person);
        $this->assertStringNotContainsString('setSameAs(', $person);
    }

    public function testGeneratedId(): void
    {
        $outputDir = __DIR__.'/../../build/generated-id';
        $config = __DIR__.'/../config/generated-id.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/App/Entity/Person.php");

        $this->assertStringContainsString(<<<'PHP'
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
PHP
            , $person);

        $this->assertStringContainsString(<<<'PHP'
    public function getId(): ?int
    {
        return $this->id;
    }
PHP
        , $person);

        $this->assertStringNotContainsString('setId(', $person);
    }

    public function testNonGeneratedId(): void
    {
        $outputDir = __DIR__.'/../../build/non-generated-id';
        $config = __DIR__.'/../config/non-generated-id.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/App/Entity/Person.php");

        $this->assertStringContainsString(<<<'PHP'
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;
PHP
            , $person);

        $this->assertStringContainsString(<<<'PHP'
    public function getId(): string
    {
        return $this->id;
    }
PHP
            , $person);

        $this->assertStringContainsString(<<<'PHP'
    public function setId(string $id): void
    {
        $this->id = $id;
    }
PHP
            , $person);
    }

    public function testGeneratedUuid(): void
    {
        $outputDir = __DIR__.'/../../build/generated-uuid';
        $config = __DIR__.'/../config/generated-uuid.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/App/Entity/Person.php");

        $this->assertStringContainsString(<<<'PHP'
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'UUID')]
    #[ORM\Column(type: 'guid')]
    #[Assert\Uuid]
    private ?string $id = null;
PHP
            , $person);

        $this->assertStringContainsString(<<<'PHP'
    public function getId(): ?string
    {
        return $this->id;
    }
PHP
            , $person);

        $this->assertStringNotContainsString('setId(', $person);
    }

    public function testNonGeneratedUuid(): void
    {
        $outputDir = __DIR__.'/../../build/non-generated-uuid';
        $config = __DIR__.'/../config/non-generated-uuid.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/App/Entity/Person.php");

        $this->assertStringContainsString(<<<'PHP'
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    #[Assert\Uuid]
    private string $id;
PHP
            , $person);

        $this->assertStringContainsString(<<<'PHP'
    public function getId(): string
    {
        return $this->id;
    }
PHP
            , $person);

        $this->assertStringContainsString(<<<'PHP'
    public function setId(string $id): void
    {
        $this->id = $id;
    }

PHP
        , $person);
    }

    public function testDoNotGenerateId(): void
    {
        $outputDir = __DIR__.'/../../build/no-id';
        $config = __DIR__.'/../config/no-id.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $person = file_get_contents("$outputDir/App/Entity/Person.php");

        $this->assertStringNotContainsString('$id', $person);
        $this->assertStringNotContainsString('getId', $person);
        $this->assertStringNotContainsString('setId', $person);
    }

    public function testNamespacesPrefix(): void
    {
        $outputDir = __DIR__.'/../../build/namespaces-prefix';
        $config = __DIR__.'/../config/namespaces-prefix.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
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
            $commandTester = new CommandTester(new GenerateCommand());
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

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $gender = file_get_contents("$outputDir/App/Enum/GenderType.php");

        $this->assertStringContainsString(<<<'PHP'
    /** @var string The female gender. */
    public const FEMALE = 'https://schema.org/Female';
PHP
            , $gender);

        $this->assertStringNotContainsString('function setId(', $gender);
    }

    public function testSupersededProperties(): void
    {
        $outputDir = __DIR__.'/../../build/superseded-properties';
        $config = __DIR__.'/../config/superseded-properties.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $creativeWork = file_get_contents("$outputDir/App/Entity/CreativeWork.php");

        $this->assertStringContainsString(<<<'PHP'
    /**
     * An award won by or for this item.
     *
     * @see https://schema.org/award
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['https://schema.org/award'])]
    private ?string $award = null;
PHP
            , $creativeWork);

        $this->assertStringNotContainsString('protected', $creativeWork);
    }

    public function testActivityStreams(): void
    {
        $outputDir = __DIR__.'/../../build/activity-streams';
        $config = __DIR__.'/../config/activity-streams.yaml';

        $this->fs->mkdir($outputDir);

        $commandTester = new CommandTester(new GenerateCommand());
        $this->assertEquals(0, $commandTester->execute(['output' => $outputDir, 'config' => $config]));

        $object = file_get_contents("$outputDir/App/Entity/Object_.php");

        $this->assertStringContainsString(<<<'PHP'
    /**
     * The content of the object.
     *
     * @see http://www.w3.org/ns/activitystreams#content
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['http://www.w3.org/ns/activitystreams#content'])]
    private ?string $content = null;
PHP
            , $object);

        $page = file_get_contents("$outputDir/App/Entity/Page.php");

        $this->assertStringContainsString(<<<'PHP'
/**
 * A Web Page.
 *
 * @see http://www.w3.org/ns/activitystreams#Page
 */
#[ORM\Entity]
#[ApiResource(types: ['http://www.w3.org/ns/activitystreams#Page'], routePrefix: 'as')]
class Page extends Object_
PHP
            , $page);

        self::assertFalse($this->fs->exists("$outputDir/App/Entity/Delete.php"));
        self::assertFalse($this->fs->exists("$outputDir/App/Entity/Travel.php"));
    }

    public function testGenerationWithoutConfigFileQuestion(): void
    {
        // No config file is given.
        $application = new Application();
        $application->add(new GenerateCommand());

        $command = $application->find('generate');
        $commandTester = new CommandTester($command);
        $this->assertEquals(0, $commandTester->execute(['output' => sys_get_temp_dir()]));
        $this->assertMatchesRegularExpression('/The entire vocabulary will be imported/', $commandTester->getDisplay());
    }
}
