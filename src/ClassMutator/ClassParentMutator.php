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

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use Psr\Log\LoggerAwareTrait;

final class ClassParentMutator implements ClassMutatorInterface
{
    use LoggerAwareTrait;

    private PhpTypeConverterInterface $phpTypeConverter;
    /** @var Configuration */
    private array $config;

    /**
     * @param Configuration $config
     */
    public function __construct(array $config, PhpTypeConverterInterface $phpTypeConverter)
    {
        $this->phpTypeConverter = $phpTypeConverter;
        $this->config = $config;
    }

    /**
     * @param array{} $context
     */
    public function __invoke(Class_ $class, array $context): void
    {
        if (!$class instanceof SchemaClass) {
            return;
        }

        $typeConfig = $this->config['types'][$class->name()] ?? null;
        $class->withParent($typeConfig['parent'] ?? null);

        if (null === $class->parent() && $subclassOf = $class->getSubClassOf()) {
            if (\count($subclassOf) > 1) {
                $this->logger ? $this->logger->info(sprintf('The type "%s" has several supertypes. Using the first one.', $class->rdfType())) : null;
            }

            if (\is_string($parentLocalName = $subclassOf[0]->localName())) {
                $class->withParent($this->phpTypeConverter->escapeIdentifier($parentLocalName));
            }
        }

        if ($class->hasParent() && isset($this->config['types'][$class->parent()]['namespaces']['class'])) {
            $parentNamespace = $this->config['types'][$class->parent()]['namespaces']['class'];

            if (!$class->isInNamespace($parentNamespace)) {
                $class->addUse(new Use_($parentNamespace.'\\'.$class->parent()));
            }
        }
    }
}
