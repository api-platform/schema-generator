<?php

declare(strict_types=1);

namespace App\OpenApi\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * This entity represents a "most borrowed book" in a given a given French library.
 */
#[ORM\Entity]
#[ApiResource(operations: [new Get(), new GetCollection()])]
class TopBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text', name: '`title`')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $title;

    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $author;

    #[ORM\Column(type: 'text', name: '`part`')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $part;

    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $place;

    #[ORM\Column(type: 'integer')]
    #[ApiProperty]
    #[Assert\NotNull]
    private int $borrowCount;

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

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setPart(string $part): void
    {
        $this->part = $part;
    }

    public function getPart(): string
    {
        return $this->part;
    }

    public function setPlace(string $place): void
    {
        $this->place = $place;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function setBorrowCount(int $borrowCount): void
    {
        $this->borrowCount = $borrowCount;
    }

    public function getBorrowCount(): int
    {
        return $this->borrowCount;
    }
}
