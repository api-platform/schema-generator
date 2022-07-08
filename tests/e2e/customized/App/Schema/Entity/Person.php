<?php

declare(strict_types=1);

namespace App\Schema\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Attribute\MyCustomAttribute;
use App\Model\MyCustomClass;
use App\Model\MyCustomInterface;
use App\Schema\Enum\GenderType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A person (alive, dead, undead, or fictional).
 *
 * @see https://schema.org/Person
 */
#[ORM\Entity]
#[ApiResource(
    types: ['https://schema.org/Person'],
    operations: [
        new Get(),
        new GetCollection(routeName: 'get_person_collection'),
        new Delete(security: 'is_granted(\'ROLE_ADMIN\')'),
    ],
    security: 'is_granted(\'ROLE_USER\')',
)]
#[UniqueEntity('email')]
#[MyCustomAttribute(foo: 'bar')]
class Person extends MyCustomClass implements MyCustomInterface
{
    public const PERSON_TRAITS = ['nice', 'funny'];

    private string $myProperty = 'foo';

    /**
     * Family name. In the U.S., the last name of a Person.
     *
     * @see https://schema.org/familyName
     */
    #[MyCustomAttribute]
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['https://schema.org/familyName'])]
    private ?string $familyName = null;

    /**
     * Given name. In the U.S., the first name of a Person.
     *
     * @see https://schema.org/givenName
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['https://schema.org/givenName'])]
    private ?string $givenName = null;

    /**
     * An additional name for a Person, can be used for a middle name.
     *
     * @see https://schema.org/additionalName
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['https://schema.org/additionalName'])]
    private ?string $additionalName = null;

    /**
     * Gender of something, typically a \[\[Person\]\], but possibly also fictional characters, animals, etc. While https://schema.org/Male and https://schema.org/Female may be used, text strings are also acceptable for people who do not identify as a binary gender. The \[\[gender\]\] property can also be used in an extended sense to cover e.g. the gender of sports teams. As with the gender of individuals, we do not try to enumerate all possibilities. A mixed-gender \[\[SportsTeam\]\] can be indicated with a text value of "Mixed".
     *
     * @see https://schema.org/gender
     */
    #[ORM\Column]
    #[ApiProperty(types: ['https://schema.org/gender'])]
    #[Assert\NotNull]
    #[Assert\Choice(callback: [GenderType::class, 'toArray'])]
    private string $gender;

    /**
     * Physical address of the item.
     *
     * @see https://schema.org/address
     */
    #[ORM\OneToOne(targetEntity: 'App\Schema\Entity\PostalAddress')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty(types: ['https://schema.org/address'])]
    #[Assert\NotNull]
    private PostalAddress $address;

    /**
     * Date of birth.
     *
     * @see https://schema.org/birthDate
     */
    #[ORM\Column(type: 'date', nullable: true)]
    #[ApiProperty(types: ['https://schema.org/birthDate'])]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $birthDate = null;

    /**
     * The telephone number.
     *
     * @see https://schema.org/telephone
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['https://schema.org/telephone'])]
    private ?string $telephone = null;

    /**
     * Email address.
     *
     * @see https://schema.org/email
     */
    #[ORM\Column(type: 'text', nullable: true, unique: true)]
    #[ApiProperty(types: ['https://schema.org/email'], security: 'is_granted(\'ROLE_ADMIN\')')]
    #[Assert\Email]
    private ?string $email = null;

    /**
     * URL of the item.
     *
     * @see https://schema.org/url
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[ApiProperty(types: ['https://schema.org/url'])]
    #[Assert\Url]
    private ?string $url = null;

    /**
     * @var Collection<Person>|null a sibling of the person
     *
     * @see https://schema.org/siblings
     */
    #[ORM\ManyToMany(targetEntity: 'App\Schema\Entity\Person')]
    #[ORM\JoinTable(name: 'person_person_siblings')]
    #[ORM\InverseJoinColumn(unique: true)]
    #[ApiProperty(types: ['https://schema.org/siblings'])]
    private ?Collection $siblings = null;

    /**
     * Of a \[\[Person\]\], and less typically of an \[\[Organization\]\], to indicate a topic that is known about - suggesting possible expertise but not implying it. We do not distinguish skill levels here, or relate this to educational content, events, objectives or \[\[JobPosting\]\] descriptions.
     *
     * @see https://schema.org/knowsAbout
     */
    #[ORM\OneToOne(targetEntity: 'App\Schema\Entity\Thing')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty(types: ['https://schema.org/knowsAbout'])]
    #[Assert\NotNull]
    private Thing $knowsAbout;

    /** @see _:customColumn */
    #[ORM\Column(type: 'decimal', nullable: true, precision: 5, scale: 1, options: ['comment' => 'my comment'])]
    private ?string $customColumn = null;

    public function __construct()
    {
        $this->siblings = new ArrayCollection();
    }

    public function getMyProperty(): string
    {
        return $this->myProperty;
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

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setAddress(PostalAddress $address): void
    {
        $this->address = $address;
    }

    public function getAddress(): PostalAddress
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

    /**
     * @return Collection<Person>|null
     */
    public function getSiblings(): Collection
    {
        return $this->siblings;
    }

    public function setKnowsAbout(Thing $knowsAbout): void
    {
        $this->knowsAbout = $knowsAbout;
    }

    public function getKnowsAbout(): Thing
    {
        return $this->knowsAbout;
    }

    public function setCustomColumn(?string $customColumn): void
    {
        $this->customColumn = $customColumn;
    }

    public function getCustomColumn(): ?string
    {
        return $this->customColumn;
    }
}
