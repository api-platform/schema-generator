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

namespace ApiPlatform\SchemaGenerator\AttributeGenerator;

use function Symfony\Component\String\u;

trait GenerateIdentifierNameTrait
{
    /**
     * @param Configuration $config
     */
    public function generateIdentifierName(string $name, string $defaultName, array $config): string
    {
        $maxIdentifierLength = $config['doctrine']['maxIdentifierLength'];

        $identifierName = u($name)->snake()->toString();

        if (\strlen($identifierName) > $maxIdentifierLength) {
            $identifierName = $defaultName.'_'.hash('adler32', $name);
            if (\strlen($identifierName) > $maxIdentifierLength) {
                throw new \RuntimeException('Identifier name with default name exceeds maximum identifier length.');
            }
        }

        return $identifierName;
    }
}
