<?php

declare(strict_types=1);

namespace App\OpenApi\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use App\OpenApi\Enum\OrderStatus;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: '`order`')]
#[ApiResource(operations: [new Get(), new Delete()])]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: 'App\OpenApi\Entity\Pet')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty]
    #[Assert\NotNull]
    private Pet $petId;

    #[ORM\Column(type: 'integer')]
    #[ApiProperty]
    #[Assert\NotNull]
    private int $quantity;

    #[ORM\Column(type: 'datetime')]
    #[ApiProperty]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\NotNull]
    private \DateTimeInterface $shipDate;

    /**
     * Order Status.
     */
    #[ORM\Column]
    #[ApiProperty]
    #[Assert\NotNull]
    #[Assert\Choice(callback: [OrderStatus::class, 'toArray'])]
    private OrderStatus $status;

    #[ORM\Column(type: 'boolean')]
    #[ApiProperty]
    #[Assert\NotNull]
    private bool $complete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setPetId(Pet $petId): void
    {
        $this->petId = $petId;
    }

    public function getPetId(): Pet
    {
        return $this->petId;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setShipDate(\DateTimeInterface $shipDate): void
    {
        $this->shipDate = $shipDate;
    }

    public function getShipDate(): \DateTimeInterface
    {
        return $this->shipDate;
    }

    public function setStatus(OrderStatus $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setComplete(bool $complete): void
    {
        $this->complete = $complete;
    }

    public function getComplete(): bool
    {
        return $this->complete;
    }
}
