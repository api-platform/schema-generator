<?php

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator;

use Nette\PhpGenerator\Printer as NettePrinter;

final class Printer extends NettePrinter
{
    /** @var int */
    protected $linesBetweenMethods = 1;

    public function __construct()
    {
        $this->setTypeResolving(false);
    }
}
