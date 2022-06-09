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

namespace ApiPlatform\SchemaGenerator;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

final class TwigBuilder
{
    /**
     * @param Configuration $config
     */
    public function build(array $config): Environment
    {
        $templatePaths = $config['generatorTemplates'];
        $templatePaths[] = __DIR__.'/../templates/';
        $loader = new FilesystemLoader($templatePaths);

        $twig = new Environment($loader, ['autoescape' => false, 'debug' => $config['debug']]);
        if ($config['debug']) {
            $twig->addExtension(new DebugExtension());
        }

        return $twig;
    }
}
