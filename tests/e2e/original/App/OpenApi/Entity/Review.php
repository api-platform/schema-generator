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
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A review of an item - for example, of a restaurant, movie, or store.
 *
 * @see http://schema.org/Review
 */
#[ORM\Entity]
#[ApiResource(
    types: ['http://schema.org/Review'],
    operations: [new Get(), new Put(), new Patch(), new Delete(), new GetCollection(), new Post()],
)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * The actual body of the review.
     *
     * @see http://schema.org/reviewBody
     */
    #[ORM\Column(type: 'text')]
    #[ApiProperty(types: ['http://schema.org/reviewBody'])]
    #[Assert\NotNull]
    private string $body;

    /**
     * A rating.
     */
    #[ORM\Column(type: 'integer')]
    #[ApiProperty]
    #[Assert\NotNull]
    private int $rating;

    /**
     * DEPRECATED (use rating now): A letter to rate the book.
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty]
    private ?string $letter = null;

    /**
     * @see https://schema.org/Book
     */
    #[ORM\OneToOne(targetEntity: 'App\OpenApi\Entity\Book')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty(types: ['https://schema.org/Book'])]
    #[Assert\NotNull]
    private Book $book;

    /**
     * The author of the review.
     *
     * @see http://schema.org/author
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['http://schema.org/author'])]
    private ?string $author = null;

    /**
     * Publication date of the review.
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    #[ApiProperty]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $publicationDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setLetter(?string $letter): void
    {
        $this->letter = $letter;
    }

    public function getLetter(): ?string
    {
        return $this->letter;
    }

    public function setBook(Book $book): void
    {
        $this->book = $book;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setPublicationDate(?\DateTimeInterface $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }
}
