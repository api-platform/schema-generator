<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * The most generic type of item.
 *
 * @see https://schema.org/Thing
 *
 * @ORM\Entity
 * @ApiResource(iri="https://schema.org/Thing")
 */
class Thing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * The name of the item.
     *
     * @see https://schema.org/name
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="https://schema.org/name")
     */
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
