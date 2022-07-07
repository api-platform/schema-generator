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

use ApiPlatform\SchemaGenerator\AttributeGenerator\DoctrineOrmAssociationOverrideAttributeGenerator;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use ApiPlatform\SchemaGenerator\Schema\Model\Property;
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use Nette\PhpGenerator\Literal;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\String\Inflector\EnglishInflector;

class DoctrineOrmAssociationOverrideAttributeGeneratorTest extends TestCase
{
    private DoctrineOrmAssociationOverrideAttributeGenerator $generator;

    private array $classMap = [];

    protected function setUp(): void
    {
        $graph = new RdfGraph();

        $thing = new SchemaClass('Thing', new RdfResource('https://schema.org/Thing', $graph));
        $thing->isAbstract = true;
        $thing->hasChild = true;
        $imageProperty = new Property('image');
        $imageProperty->addAttribute(new Attribute('ORM\JoinTable', ['name' => 'thing_image']));
        $imageProperty->addAttribute(new Attribute('ORM\InverseJoinColumn', ['nullable' => false, 'unique' => true]));
        $thing->addProperty($imageProperty);
        $this->classMap[$thing->name()] = $thing;

        $creativeWork = new SchemaClass('CreativeWork', new RdfResource('https://schema.org/CreativeWork', $graph), 'Thing');
        $creativeWork->hasChild = true;
        $this->classMap[$creativeWork->name()] = $creativeWork;

        $article = new SchemaClass('Article', new RdfResource('htts://schema.org/Article', $graph), 'CreativeWork');
        $article->hasChild = true;
        $article->isAbstract = true;
        $speakableProperty = new Property('speakable');
        $speakableProperty->addAttribute(new Attribute('ORM\JoinTable', ['name' => 'article_speakable']));
        $speakableProperty->addAttribute(new Attribute('ORM\JoinColumn', ['nullable' => false]));
        $article->addProperty($speakableProperty);
        $this->classMap[$article->name()] = $article;

        $newsArticle = new SchemaClass('NewsArticle', new RdfResource('https://schema.org/NewsArticle', $graph), 'Article');
        $newsArticle->hasChild = true;
        $newsArticle->isAbstract = true;
        $printSectionProperty = new Property('printSection');
        $printSectionProperty->addAttribute(new Attribute('ORM\JoinTable', ['name' => 'news_article_print_section']));
        $newsArticle->addProperty($printSectionProperty);
        $this->classMap[$newsArticle->name()] = $newsArticle;

        $opinionNewsArticle = new SchemaClass('OpinionNewsArticle', new RdfResource('https://schema.org/OpinionNewsArticle', $graph), 'NewsArticle');
        $this->classMap[$opinionNewsArticle->name()] = $opinionNewsArticle;

        $configuration = new SchemaGeneratorConfiguration();
        /** @var Configuration $processedConfiguration */
        $processedConfiguration = (new Processor())->processConfiguration($configuration, [[
            'doctrine' => [
                'maxIdentifierLength' => 40,
            ],
        ]]);

        $this->generator = new DoctrineOrmAssociationOverrideAttributeGenerator(
            new PhpTypeConverter(),
            new EnglishInflector(),
            $processedConfiguration,
            $this->classMap
        );
    }

    public function testGenerateLateClassAttributes(): void
    {
        $this->assertEquals([new Attribute('ORM\AssociationOverrides', [[
            new Literal("new ORM\AssociationOverride(...?:)", [['name' => 'printSection', 'joinTable' => new Literal('new ORM\JoinTable(...?:)', [['name' => 'join_table_9aff121e']]), 'joinColumns' => [new Literal('new ORM\JoinColumn(...?:)', [[]])], 'inverseJoinColumns' => [new Literal('new ORM\InverseJoinColumn(...?:)', [[]])]]]),
            new Literal("new ORM\AssociationOverride(...?:)", [['name' => 'speakable', 'joinTable' => new Literal('new ORM\JoinTable(...?:)', [['name' => 'article_speakable_opinion_news_article']]), 'joinColumns' => [new Literal('new ORM\JoinColumn(...?:)', [['nullable' => false]])], 'inverseJoinColumns' => [new Literal('new ORM\InverseJoinColumn(...?:)', [[]])]]]),
        ]])], $this->generator->generateLateClassAttributes($this->classMap['OpinionNewsArticle']));
        $this->assertEquals([new Attribute('ORM\AssociationOverrides', [[
            new Literal("new ORM\AssociationOverride(...?:)", [['name' => 'image', 'joinTable' => new Literal('new ORM\JoinTable(...?:)', [['name' => 'thing_image_creative_work']]), 'joinColumns' => [new Literal('new ORM\JoinColumn(...?:)', [[]])], 'inverseJoinColumns' => [new Literal('new ORM\InverseJoinColumn(...?:)', [['nullable' => false, 'unique' => true]])]]]),
        ]])], $this->generator->generateLateClassAttributes($this->classMap['CreativeWork']));
        $this->assertEquals([], $this->generator->generateLateClassAttributes($this->classMap['Thing']));
        $this->assertEquals([], $this->generator->generateLateClassAttributes($this->classMap['Article']));
        $this->assertEquals([], $this->generator->generateLateClassAttributes($this->classMap['NewsArticle']));
    }
}
