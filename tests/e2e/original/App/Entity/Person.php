<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\GenderType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A person (alive, dead, undead, or fictional).
 *
 * @see https://schema.org/Person
 */
#[ORM\Entity]
#[ApiResource(
    iri: 'https://schema.org/Person',
    security: 'is_granted(\'ROLE_USER\')',
    itemOperations: ['get' => ['method' => 'GET'], 'delete' => ['method' => 'DELETE', 'security' => 'is_granted(\'ROLE_ADMIN\')']],
    collectionOperations: ['get' => ['route_name' => 'get_person_collection']],
)]
#[UniqueEntity('email')]
class Person extends Thing
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Family name. In the U.S., the last name of a Person.
     *
     * @see https://schema.org/familyName
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/familyName')]
    private ?string $familyName = null;

    /**
     * Given name. In the U.S., the first name of a Person.
     *
     * @see https://schema.org/givenName
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/givenName')]
    private ?string $givenName = null;

    /**
     * An additional name for a Person, can be used for a middle name.
     *
     * @see https://schema.org/additionalName
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/additionalName')]
    #[Groups(['extra'])]
    private ?string $additionalName = null;

    /**
     * Gender of something, typically a \[\[Person\]\], but possibly also fictional characters, animals, etc. While https://schema.org/Male and https://schema.org/Female may be used, text strings are also acceptable for people who do not identify as a binary gender. The \[\[gender\]\] property can also be used in an extended sense to cover e.g. the gender of sports teams. As with the gender of individuals, we do not try to enumerate all possibilities. A mixed-gender \[\[SportsTeam\]\] can be indicated with a text value of "Mixed".
     *
     * @see https://schema.org/gender
     */
    #[ORM\Column(nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/gender')]
    #[Assert\Choice(callback: [GenderType::class, 'toArray'])]
    private ?string $gender = null;

    /**
     * Physical address of the item.
     *
     * @see https://schema.org/address
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\PostalAddress')]
    #[ApiProperty(iri: 'https://schema.org/address')]
    private ?PostalAddress $address = null;

    /**
     * Date of birth.
     *
     * @see https://schema.org/birthDate
     */
    #[ORM\Column(type: 'date', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/birthDate')]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $birthDate = null;

    /**
     * The telephone number.
     *
     * @see https://schema.org/telephone
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/telephone')]
    private ?string $telephone = null;

    /**
     * Email address.
     *
     * @see https://schema.org/email
     */
    #[ORM\Column(type: 'text', nullable: true, unique: true)]
    #[ApiProperty(iri: 'https://schema.org/email', security: 'is_granted(\'ROLE_ADMIN\')')]
    #[Assert\Email]
    private ?string $email = null;

    /**
     * URL of the item.
     *
     * @see https://schema.org/url
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(iri: 'https://schema.org/url')]
    #[Assert\Url]
    private ?string $url = null;

    /**
     * A sibling of the person.
     *
     * @see https://schema.org/siblings
     */
    #[ORM\ManyToMany(targetEntity: 'App\Entity\Person')]
    #[ORM\InverseJoinColumn(unique: true)]
    #[ApiProperty(iri: 'https://schema.org/siblings')]
    private ?Collection $siblings = null;

    /**
     * @see _:customColumn
     */
    #[ORM\Column(type: 'decimal', precision: 5, scale: 1, options: ['comment' => 'my comment'])]
    private ?Person $customColumn = null;

    public function __construct()
    {
        $this->siblings = new ArrayCollection();
    }

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

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function getGender(): ?string
    {
        return $this->gender;
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

    public function addSibling(Person $sibling): void
    {
        $this->siblings[] = $sibling;
    }

    public function removeSibling(Person $sibling): void
    {
        $this->siblings->removeElement($sibling);
    }

    public function getSiblings(): Collection
    {
        return $this->siblings;
    }

    public function setCustomColumn(?Person $customColumn): void
    {
        $this->customColumn = $customColumn;
    }

    public function getCustomColumn(): ?Person
    {
        return $this->customColumn;
    }
}
