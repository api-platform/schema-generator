<?php

declare(strict_types=1);

namespace App\OpenApi\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use App\OpenApi\Enum\PetStatus;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(operations: [new Get(), new Delete()])]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $name;

    #[ApiProperty]
    #[Assert\NotNull]
    private string $category;

    /**
     * @var string[]
     */
    #[ORM\Column(type: 'json')]
    #[ApiProperty]
    #[Assert\NotNull]
    private array $photoUrls = [];

    #[ORM\Column(type: 'json')]
    #[ApiProperty]
    #[Assert\NotNull]
    private array $tags = [];

    /**
     * pet status in the store.
     */
    #[ORM\Column]
    #[ApiProperty]
    #[Assert\NotNull]
    #[Assert\Choice(callback: [PetStatus::class, 'toArray'])]
    private PetStatus $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function addPhotoUrl(string $photoUrl): void
    {
        $this->photoUrls[] = $photoUrl;
    }

    public function removePhotoUrl(string $photoUrl): void
    {
        if (false !== $key = array_search($photoUrl, $this->photoUrls, true)) {
            unset($this->photoUrls[$key]);
        }
    }

    /**
     * @return string[]
     */
    public function getPhotoUrls(): array
    {
        return $this->photoUrls;
    }

    public function addTag(string $tag): void
    {
        $this->tags[] = $tag;
    }

    public function removeTag(string $tag): void
    {
        if (false !== $key = array_search($tag, $this->tags, true)) {
            unset($this->tags[$key]);
        }
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setStatus(PetStatus $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): PetStatus
    {
        return $this->status;
    }
}
