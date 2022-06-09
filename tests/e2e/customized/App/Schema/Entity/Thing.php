<?php

declare(strict_types=1);

namespace App\Schema\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;

/**
 * The most generic type of item.
 *
 * @see https://schema.org/Thing
 */
#[ORM\MappedSuperclass]
abstract class Thing
{
    /**
     * The name of the item.
     *
     * @see https://schema.org/name
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/name')]
    private ?string $name = null;

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
