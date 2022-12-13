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
 * A named period of time that can be used to communicate the various schedules and time periods an institution recognizes and uses to organize their education. AcademicSessions can be nested. Offerings MAY be be linked to a specific AcademicSession to indicate that the specified Offering takes place during the AcademicSession, however this is not mandatory.
 */
#[ORM\Entity]
#[ApiResource(operations: [new Get(), new GetCollection()])]
class AcademicSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Unique id for this academic session.
     */
    #[ORM\OneToOne(targetEntity: 'App\OpenApi\Entity\AcademicSession')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty]
    #[Assert\NotNull]
    private AcademicSession $academicSessionId;

    /**
     * The type of this Academic Session This is an \*extensible enumeration\*. - academic year: academic year - semester: semester, typically there are two semesters per academic year - trimester: trimester, typically there are three semesters per academic year - quarter: quarter, typically there are four quarters per academic year - testing period: a period in which tests take place - period: any other period in an academic year Implementations are allowed to add additional values to those above, as long as they do not overlap in definition to existing values.
     */
    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $academicSessionType;

    #[ApiProperty]
    #[Assert\NotNull]
    private string $primaryCode;

    /**
     * @var array The name of this academic session
     */
    #[ORM\Column(type: 'json')]
    #[ApiProperty]
    #[Assert\NotNull]
    private array $name = [];

    /**
     * The day on which this academic session starts, RFC3339 (full-date).
     */
    #[ORM\Column(type: 'date')]
    #[ApiProperty]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\NotNull]
    private \DateTimeInterface $startDate;

    /**
     * The day on which this academic session ends, RFC3339 (full-date).
     */
    #[ORM\Column(type: 'date')]
    #[ApiProperty]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\NotNull]
    private \DateTimeInterface $endDate;

    /**
     * The parent Academicsession of this session (e.g. fall semester 20xx where the current session is a week 40). This object is \[`expandable`\](#tag/academic\_sessions\_model).
     */
    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $parent;

    /**
     * @var (uuid|object)[] The list of Academicsession children of this Session (e.g. all academic sessions in fall semester 20xx). This object is \[`expandable`\](#tag/academic\_sessions\_model)
     */
    #[ORM\Column(type: 'json')]
    #[ApiProperty]
    #[Assert\NotNull]
    private array $children = [];

    /**
     * The top level year of this session (e.g. 20xx where the current session is a week 40 of a semester). This object is \[`expandable`\](#tag/academic\_sessions\_model).
     */
    #[ORM\Column(type: 'text', name: '`year`')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $year;

    /**
     * @var array an array of additional human readable codes/identifiers for the entity being described
     */
    #[ORM\Column(type: 'json')]
    #[ApiProperty]
    #[Assert\NotNull]
    private array $otherCodes = [];

    /**
     * @var array The additional consumer elements that can be provided, see the \[documentation on support for specific consumers\](https://open-education-api.github.io/specification/#/consumers) for more information about this mechanism.
     */
    #[ORM\Column(type: 'json')]
    #[ApiProperty]
    #[Assert\NotNull]
    private array $consumers = [];

    /**
     * Object for additional non-standard attributes.
     */
    #[ApiProperty]
    #[Assert\NotNull]
    private string $ext;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAcademicSessionId(): AcademicSession
    {
        return $this->academicSessionId;
    }

    public function setAcademicSessionType(string $academicSessionType): void
    {
        $this->academicSessionType = $academicSessionType;
    }

    public function getAcademicSessionType(): string
    {
        return $this->academicSessionType;
    }

    public function setPrimaryCode(string $primaryCode): void
    {
        $this->primaryCode = $primaryCode;
    }

    public function getPrimaryCode(): string
    {
        return $this->primaryCode;
    }

    public function addName(string $name): void
    {
        $this->name[] = $name;
    }

    public function removeName(string $name): void
    {
        if (false !== $key = array_search($name, $this->name, true)) {
            unset($this->name[$key]);
        }
    }

    public function getName(): array
    {
        return $this->name;
    }

    public function setStartDate(\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    public function setParent(string $parent): void
    {
        $this->parent = $parent;
    }

    public function getParent(): string
    {
        return $this->parent;
    }

    public function addChild(string $child): void
    {
        $this->children[] = $child;
    }

    public function removeChild(string $child): void
    {
        if (false !== $key = array_search($child, $this->children, true)) {
            unset($this->children[$key]);
        }
    }

    /**
     * @return (uuid|object)[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function setYear(string $year): void
    {
        $this->year = $year;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function addOtherCod(string $otherCod): void
    {
        $this->otherCodes[] = $otherCod;
    }

    public function removeOtherCod(string $otherCod): void
    {
        if (false !== $key = array_search($otherCod, $this->otherCodes, true)) {
            unset($this->otherCodes[$key]);
        }
    }

    public function getOtherCodes(): array
    {
        return $this->otherCodes;
    }

    public function addConsumer(string $consumer): void
    {
        $this->consumers[] = $consumer;
    }

    public function removeConsumer(string $consumer): void
    {
        if (false !== $key = array_search($consumer, $this->consumers, true)) {
            unset($this->consumers[$key]);
        }
    }

    public function getConsumers(): array
    {
        return $this->consumers;
    }

    public function setExt(string $ext): void
    {
        $this->ext = $ext;
    }

    public function getExt(): string
    {
        return $this->ext;
    }
}
