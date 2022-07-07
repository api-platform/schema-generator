<?php

declare(strict_types=1);

namespace App\OpenApi\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @see https://schema.org/Book
 */
#[ORM\Entity]
#[ApiResource(
    types: ['https://schema.org/Book'],
    operations: [new Get(), new Put(), new Patch(), new Delete(), new GetCollection(), new Post()],
)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * The ISBN of the book.
     *
     * @see https://schema.org/isbn
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['https://schema.org/isbn'])]
    private ?string $isbn = null;

    /**
     * The title of the book.
     *
     * @see https://schema.org/name
     */
    #[ORM\Column(type: 'text')]
    #[ApiProperty(types: ['https://schema.org/name'])]
    #[Assert\NotNull]
    private string $title;

    /**
     * A description of the item.
     *
     * @see https://schema.org/description
     */
    #[ORM\Column(type: 'text')]
    #[ApiProperty(types: ['https://schema.org/description'])]
    #[Assert\NotNull]
    private string $description;

    /**
     * The author of this content or rating. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
     *
     * @see https://schema.org/author
     */
    #[ORM\Column(type: 'text')]
    #[ApiProperty(types: ['https://schema.org/author'])]
    #[Assert\NotNull]
    private string $author;

    /**
     * The date on which the CreativeWork was created or the item was added to a DataFeed.
     *
     * @see https://schema.org/dateCreated
     */
    #[ORM\Column(type: 'date')]
    #[ApiProperty(types: ['https://schema.org/dateCreated'])]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\NotNull]
    private \DateTimeInterface $publicationDate;

    /**
     * @var Collection<Review> the book's reviews
     *
     * @see https://schema.org/reviews
     */
    #[ORM\OneToMany(targetEntity: 'App\OpenApi\Entity\Review', mappedBy: 'book')]
    #[ORM\JoinTable(name: 'book_review_reviews')]
    #[ORM\InverseJoinColumn(nullable: false, unique: true)]
    #[ApiProperty(types: ['https://schema.org/reviews'])]
    #[Assert\NotNull]
    private Collection $reviews;

    /**
     * The book's cover base64 encoded.
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty]
    private ?string $cover = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[ApiProperty]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $archivedAt = null;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIsbn(?string $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
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

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

    public function getPublicationDate(): \DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function addReview(Review $review): void
    {
        $this->reviews[] = $review;
    }

    public function removeReview(Review $review): void
    {
        $this->reviews->removeElement($review);
    }

    /**
     * @return Collection<Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function setCover(?string $cover): void
    {
        $this->cover = $cover;
    }

    public function setArchivedAt(?\DateTimeInterface $archivedAt): void
    {
        $this->archivedAt = $archivedAt;
    }
}
