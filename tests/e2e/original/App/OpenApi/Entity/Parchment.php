<?php

declare(strict_types=1);

namespace App\OpenApi\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    itemOperations: ['get' => [], 'put' => [], 'patch' => [], 'delete' => []],
    collectionOperations: ['get' => [], 'post' => []],
)]
class Parchment
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * The title of the book.
     */
    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $title;

    /**
     * A description of the item.
     */
    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
