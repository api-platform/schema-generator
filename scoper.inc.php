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

return [
    'whitelist' => [
        \ApiPlatform\Core\Annotation\ApiProperty::class,
        \ApiPlatform\Core\Annotation\ApiResource::class,
    ],
    'patchers' => [
        function (string $filePath, string $prefix, string $content): string {
            //
            // PHP-CS-Fixer patch
            //

            if ('vendor/friendsofphp/php-cs-fixer/src/FixerFactory.php' === $filePath) {
                return preg_replace(
                    '/\$fixerClass = \'PhpCsFixer(.*?\;)/',
                    sprintf('$fixerClass = \'%s\\PhpCsFixer$1', $prefix),
                    $content
                );
            }

            return $content;
        },

        // TODO: Temporary patch until the issue is fixed upstream
        // @link https://github.com/humbug/php-scoper/issues/285
        function (string $filePath, string $prefix, string $content): string {
            if (false === strpos($content, '@')) {
                return $content;
            }

            $regex = sprintf(
                '/\'%s\\\\\\\\(@.*?)\'/',
                $prefix
            );

            return preg_replace(
                $regex,
                '\'$1\'',
                $content
            );
        },
        function (string $filePath, string $prefix, string $content): string {
            if (0 !== strpos($filePath, 'src/AnnotationGenerator/')) {
                return $content;
            }

            $regex = sprintf(
                '/\\\\%s(.*?::class)/',
                $prefix
            );

            return preg_replace(
                $regex,
                '$1',
                $content
            );
        },
    ],
];
