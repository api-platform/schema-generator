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

namespace ApiPlatform\SchemaGenerator\Tests\ClassMutator;

use ApiPlatform\SchemaGenerator\ClassMutator\ClassParentMutator;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\TypesGeneratorConfiguration;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Processor;

class ClassParentMutatorTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $loggerProphecy;
    private ClassParentMutator $classParentMutator;

    protected function setUp(): void
    {
        $this->loggerProphecy = $this->prophesize(LoggerInterface::class);

        $configuration = new TypesGeneratorConfiguration();
        /** @var Configuration $processedConfiguration */
        $processedConfiguration = (new Processor())->processConfiguration($configuration, [[
            'types' => [
                'BlogPosting' => ['parent' => 'SocialMediaPosting'],
                'SocialMediaPosting' => ['namespaces' => ['class' => 'socialMediaNamespace']],
            ],
        ]]);

        $this->classParentMutator = new ClassParentMutator($processedConfiguration, new PhpTypeConverter(), $this->loggerProphecy->reveal());
    }

    /**
     * @dataProvider provideInvokeTestCases
     */
    public function testInvoke(Class_ $class, Class_ $expectedClass, ?string $loggerMessage = null): void
    {
        if ($loggerMessage) {
            $this->loggerProphecy->warning($loggerMessage)->shouldBeCalled();
        }

        $this->assertEquals($expectedClass, ($this->classParentMutator)($class));
    }

    /**
     * @return \Generator<array{0: Class_, 1: Class_, 2?: string}>
     */
    public function provideInvokeTestCases(): \Generator
    {
        $graph = new RdfGraph();
        $product = new Class_('Product', new RdfResource('https://schema.org/Product', $graph));
        yield 'no parent' => [clone $product, clone $product];

        $graph = new RdfGraph();
        $graph->addResource('https://schema.org/CreativeWork', 'rdfs:subClassOf', 'https://schema.org/Thing');
        $creativeWork = new Class_('CreativeWork', new RdfResource('https://schema.org/CreativeWork', $graph));
        yield 'with subclass' => [clone $creativeWork, (clone $creativeWork)->withParent('Thing')];

        $graph = new RdfGraph();
        $graph->addResource('https://schema.org/CreativeWork', 'rdfs:subClassOf', 'https://schema.org/Work');
        $graph->addResource('https://schema.org/CreativeWork', 'rdfs:subClassOf', 'https://schema.org/Thing');
        $creativeWork = new Class_('CreativeWork', new RdfResource('https://schema.org/CreativeWork', $graph));
        yield 'with multiple subclasses' => [clone $creativeWork, (clone $creativeWork)->withParent('Work'), 'The type "https://schema.org/CreativeWork" has several supertypes. Using the first one.'];

        $graph = new RdfGraph();
        $blogPosting = new Class_('BlogPosting', new RdfResource('https://schema.org/BlogPosting', $graph));
        yield 'with parent' => [clone $blogPosting, (clone $blogPosting)->withParent('SocialMediaPosting')->addUse(new Use_('socialMediaNamespace\SocialMediaPosting'))];
    }
}
