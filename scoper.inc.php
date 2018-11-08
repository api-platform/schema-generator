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
        'ApiPlatform\Core\Annotation\ApiProperty',
        'ApiPlatform\Core\Annotation\ApiResource',
    ],
    'patchers' => [
        function (string $filePath, string $prefix, string $content): string {
            //
            // PHP-CS-Fixer patch
            //

            if ($filePath === 'vendor/friendsofphp/php-cs-fixer/src/FixerFactory.php') {
                return preg_replace(
                    '/\$fixerClass = \'PhpCsFixer(.*?\;)/',
                    sprintf('$fixerClass = \'%s\\PhpCsFixer$1', $prefix),
                    $content
                );
            }

            return $content;
        },
    ],
];
