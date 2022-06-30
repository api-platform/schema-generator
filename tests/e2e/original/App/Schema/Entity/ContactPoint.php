<?php

declare(strict_types=1);

namespace App\Schema\Entity;

use ApiPlatform\Metadata\ApiProperty;
use Doctrine\ORM\Mapping as ORM;

/**
 * A contact point—for example, a Customer Complaints department.
 *
 * @see https://schema.org/ContactPoint
 */
#[ORM\MappedSuperclass]
abstract class ContactPoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * The telephone number.
     *
     * @see https://schema.org/telephone
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['https://schema.org/telephone'])]
    private ?string $telephone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }
}
