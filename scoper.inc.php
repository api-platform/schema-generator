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

use Isolated\Symfony\Component\Finder\Finder;

return [
    'finders' => [
        Finder::create()->files()
            ->in('src')
            ->in('data')
            ->in('templates'),
        Finder::create()
            ->files()
            ->ignoreVCS(true)
            ->notName('/LICENSE|.*\\.md|.*\\.dist|Makefile|composer\\.json|composer\\.lock/')
            ->exclude([
                'doc',
                'test',
                'test_old',
                'tests',
                'Test',
                'Tests',
            ])
            ->in('vendor'),
        Finder::create()->append([
            'bin/schema',
            'composer.json',
        ]),
        Finder::create()->append([
            'vendor/friendsofphp/php-cs-fixer/tests/Test',
            'vendor/friendsofphp/php-cs-fixer/tests/TestCase.php',
        ]),
    ],
    'whitelist' => [
        'ApiPlatform\Core\Annotation\ApiProperty',
        'ApiPlatform\Core\Annotation\ApiResource',
    ],
    'patchers' => [
        function (string $filePath, string $prefix, string $content): string {
            //
            // PHP-CS-Fixer patch
            //

            if ($filePath === __DIR__.'/vendor/friendsofphp/php-cs-fixer/src/FixerFactory.php') {
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
