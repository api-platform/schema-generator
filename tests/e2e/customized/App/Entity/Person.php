<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Attribute\MyCustomAttribute;
use App\Model\MyCustomClass;
use App\Model\MyCustomInterface;
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
#[MyCustomAttribute(foo: 'bar')]
class Person extends MyCustomClass implements MyCustomInterface
{
    public const PERSON_TRAITS = ['nice', 'funny'];

    private string $myProperty = 'foo';

    #[MyCustomAttribute]
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

    /** @see _:customColumn */
    #[ORM\Column(type: 'decimal', precision: 5, scale: 1, options: ['comment' => 'my comment'])]
    private ?Person $customColumn = null;

    public function getMyProperty(): string
    {
        return $this->myProperty;
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

    public function setCustomColumn(?Person $customColumn): void
    {
        $this->customColumn = $customColumn;
    }

    public function getCustomColumn(): ?Person
    {
        return $this->customColumn;
    }
}
