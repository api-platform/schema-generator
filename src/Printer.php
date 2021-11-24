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

use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer as NettePrinter;

final class Printer extends NettePrinter
{
    public function __construct()
    {
        parent::__construct();

        $this->linesBetweenMethods = 1;
        // If the type name cannot be resolved with the namespace and its uses (nette/php-generator >= 4),
        // disable type resolving to avoid using the root namespace.
        if (!method_exists(PhpNamespace::class, 'resolveName')) {
            $this->setTypeResolving(false);
        }
    }
}
