<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * The mailing address.
 *
 * @see https://schema.org/PostalAddress
 */
#[ORM\Entity]
#[ApiResource(iri: 'https://schema.org/PostalAddress')]
class PostalAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * The country. For example, USA. You can also provide the two-letter \[ISO 3166-1 alpha-2 country code\](http://en.wikipedia.org/wiki/ISO\_3166-1).
     *
     * @see https://schema.org/addressCountry
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/addressCountry')]
    private ?string $addressCountry = null;

    /**
     * The locality in which the street address is, and which is in the region. For example, Mountain View.
     *
     * @see https://schema.org/addressLocality
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/addressLocality')]
    private ?string $addressLocality = null;

    /**
     * The region in which the locality is, and which is in the country. For example, California or another appropriate first-level \[Administrative division\](https://en.wikipedia.org/wiki/List\_of\_administrative\_divisions\_by\_country).
     *
     * @see https://schema.org/addressRegion
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/addressRegion')]
    private ?string $addressRegion = null;

    /**
     * The post office box number for PO box addresses.
     *
     * @see https://schema.org/postOfficeBoxNumber
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/postOfficeBoxNumber')]
    private ?string $postOfficeBoxNumber = null;

    /**
     * The postal code. For example, 94043.
     *
     * @see https://schema.org/postalCode
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/postalCode')]
    private ?string $postalCode = null;

    /**
     * The street address. For example, 1600 Amphitheatre Pkwy.
     *
     * @see https://schema.org/streetAddress
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/streetAddress')]
    private ?string $streetAddress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setAddressCountry(?string $addressCountry): void
    {
        $this->addressCountry = $addressCountry;
    }

    public function getAddressCountry(): ?string
    {
        return $this->addressCountry;
    }

    public function setAddressLocality(?string $addressLocality): void
    {
        $this->addressLocality = $addressLocality;
    }

    public function getAddressLocality(): ?string
    {
        return $this->addressLocality;
    }

    public function setAddressRegion(?string $addressRegion): void
    {
        $this->addressRegion = $addressRegion;
    }

    public function getAddressRegion(): ?string
    {
        return $this->addressRegion;
    }

    public function setPostOfficeBoxNumber(?string $postOfficeBoxNumber): void
    {
        $this->postOfficeBoxNumber = $postOfficeBoxNumber;
    }

    public function getPostOfficeBoxNumber(): ?string
    {
        return $this->postOfficeBoxNumber;
    }

    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setStreetAddress(?string $streetAddress): void
    {
        $this->streetAddress = $streetAddress;
    }

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }
}
