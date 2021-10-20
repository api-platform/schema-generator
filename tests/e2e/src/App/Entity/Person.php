<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A person (alive, dead, undead, or fictional).
 *
 * @see https://schema.org/Person
 *
 * @ORM\Entity
 * @ApiResource(iri="https://schema.org/Person")
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * Family name. In the U.S., the last name of a Person.
     *
     * @see https://schema.org/familyName
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="https://schema.org/familyName")
     */
    private ?string $familyName = null;

    /**
     * Given name. In the U.S., the first name of a Person.
     *
     * @see https://schema.org/givenName
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="https://schema.org/givenName")
     */
    private ?string $givenName = null;

    /**
     * An additional name for a Person, can be used for a middle name.
     *
     * @see https://schema.org/additionalName
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="https://schema.org/additionalName")
     */
    private ?string $additionalName = null;

    /**
     * Physical address of the item.
     *
     * @see https://schema.org/address
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\PostalAddress")
     * @ApiProperty(iri="https://schema.org/address")
     */
    private ?PostalAddress $address = null;

    /**
     * Date of birth.
     *
     * @see https://schema.org/birthDate
     *
     * @ORM\Column(type="date", nullable=true)
     * @ApiProperty(iri="https://schema.org/birthDate")
     * @Assert\Date
     */
    private ?\DateTimeInterface $birthDate = null;

    /**
     * The telephone number.
     *
     * @see https://schema.org/telephone
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="https://schema.org/telephone")
     */
    private ?string $telephone = null;

    /**
     * Email address.
     *
     * @see https://schema.org/email
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="https://schema.org/email")
     * @Assert\Email
     */
    private ?string $email = null;

    /**
     * URL of the item.
     *
     * @see https://schema.org/url
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="https://schema.org/url")
     * @Assert\Url
     */
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFamilyName(?string $familyName): void
    {
        $this->familyName = $familyName;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setGivenName(?string $givenName): void
    {
        $this->givenName = $givenName;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setAdditionalName(?string $additionalName): void
    {
        $this->additionalName = $additionalName;
    }

    public function getAdditionalName(): ?string
    {
        return $this->additionalName;
    }

    public function setAddress(?PostalAddress $address): void
    {
        $this->address = $address;
    }

    public function getAddress(): ?PostalAddress
    {
        return $this->address;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
