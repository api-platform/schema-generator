<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * The mailing address.
 *
 * @see http://schema.org/PostalAddress Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/PostalAddress")
 */
class PostalAddress
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null The country. For example, USA. You can also provide the two-letter \[ISO 3166-1 alpha-2 country code\](http://en.wikipedia.org/wiki/ISO\_3166-1).
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/addressCountry")
     */
    private $addressCountry;

    /**
     * @var string|null The locality. For example, Mountain View.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/addressLocality")
     */
    private $addressLocality;

    /**
     * @var string|null The region. For example, CA.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/addressRegion")
     */
    private $addressRegion;

    /**
     * @var string|null the post office box number for PO box addresses
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/postOfficeBoxNumber")
     */
    private $postOfficeBoxNumber;

    /**
     * @var string|null The postal code. For example, 94043.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/postalCode")
     */
    private $postalCode;

    /**
     * @var string|null The street address. For example, 1600 Amphitheatre Pkwy.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/streetAddress")
     */
    private $streetAddress;

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
