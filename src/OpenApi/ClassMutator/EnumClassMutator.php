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

namespace ApiPlatform\SchemaGenerator\OpenApi\ClassMutator;

use ApiPlatform\SchemaGenerator\ClassMutator\EnumClassMutator as BaseEnumClassMutator;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\OpenApi\Model\Constant as OpenApiConstant;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;

use function Symfony\Component\String\u;

final class EnumClassMutator extends BaseEnumClassMutator
{
    /** @var string[] */
    private array $values;

    /**
     * @param string[] $values
     */
    public function __construct(PhpTypeConverterInterface $phpTypeConverter, string $desiredNamespace, array $values)
    {
        parent::__construct($phpTypeConverter, $desiredNamespace);

        $this->values = $values;
    }

    protected function addEnumConstants(Class_ $class): void
    {
        foreach ($this->values as $value) {
            $class->addConstant($value, new OpenApiConstant(
                $this->phpTypeConverter->escapeIdentifier(u($value)->snake()->upper()->toString()),
                $value
            ));
        }
    }
}
