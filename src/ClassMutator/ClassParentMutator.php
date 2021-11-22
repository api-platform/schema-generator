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
use Psr\Log\LoggerInterface;

final class ClassParentMutator implements ClassMutatorInterface
{
    private PhpTypeConverterInterface $phpTypeConverter;
    private LoggerInterface $logger;
    /** @var Configuration */
    private array $config;

    /**
     * @param Configuration $config
     */
    public function __construct(array $config, PhpTypeConverterInterface $phpTypeConverter, LoggerInterface $logger)
    {
        $this->phpTypeConverter = $phpTypeConverter;
        $this->logger = $logger;
        $this->config = $config;
    }

    public function __invoke(Class_ $class): Class_
    {
        $typeConfig = $this->config['types'][$class->name()] ?? null;
        $class->withParent($typeConfig['parent'] ?? null);

        if (null === $class->parent() && $subclassOf = $class->getSubClassOf()) {
            if (\count($subclassOf) > 1) {
                $this->logger->warning(sprintf('The type "%s" has several supertypes. Using the first one.', $class->resourceUri()));
            }

            $class = $class->withParent($this->phpTypeConverter->escapeIdentifier($subclassOf[0]->localName()));
        }

        if ($class->hasParent() && isset($this->config['types'][$class->parent()]['namespaces']['class'])) {
            $parentNamespace = $this->config['types'][$class->parent()]['namespaces']['class'];

            if (!$class->isInNamespace($parentNamespace)) {
                $class->addUse(new Use_($parentNamespace.'\\'.$class->parent()));
            }
        }

        return $class;
    }
}
