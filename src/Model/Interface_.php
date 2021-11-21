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

namespace ApiPlatform\SchemaGenerator\Model;

use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpFile;

final class Interface_
{
    private string $name;
    private string $namespace;
    /** @var string[] */
    private array $annotations = [];

    public function __construct(string $name, string $namespace)
    {
        $this->name = $name;
        $this->namespace = $namespace;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function namespace(): string
    {
        return $this->namespace;
    }

    public function addAnnotation(string $annotation): self
    {
        if (\in_array($annotation, $this->annotations, true)) {
            $this->annotations[] = $annotation;
        }

        return $this;
    }

    public function toNetteFile(string $fileHeader = null): PhpFile
    {
        $file = (new PhpFile())
            ->setStrictTypes(true)
            ->setComment(Helpers::unformatDocComment((string) $fileHeader));

        $namespace = $file->addNamespace($this->namespace);
        $namespace->addInterface($this->name);

        return $file;
    }
}
