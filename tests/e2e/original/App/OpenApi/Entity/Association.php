<?php

declare(strict_types=1);

namespace App\OpenApi\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(operations: [new Get(), new Patch()])]
class Association
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Unique id of this association.
     */
    #[ORM\OneToOne(targetEntity: 'App\OpenApi\Entity\Association')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty]
    #[Assert\NotNull]
    private Association $associationId;

    /**
     * The type of this association.
     */
    #[ORM\Column]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $associationType;

    /**
     * The role of this person associated with the offering - student: student - lecturer: docent - teaching assistant: studentassistent - coordinator: coördinator - guest: gast.
     */
    #[ORM\Column(name: '`role`')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $role;

    /**
     * The state of this association.
     */
    #[ORM\Column(name: '`state`')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $state;

    /**
     * The state of this association for the institution performing the request.
     */
    #[ORM\Column]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $remoteState;

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

    #[ORM\Column(type: 'text', name: '`result`')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $result;

    #[ORM\OneToOne(targetEntity: 'App\OpenApi\Entity\Person')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty]
    #[Assert\NotNull]
    private Person $person;

    #[ORM\OneToOne(targetEntity: 'App\OpenApi\Entity\Offering')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty]
    #[Assert\NotNull]
    private Offering $offering;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssociationId(): Association
    {
        return $this->associationId;
    }

    public function getAssociationType(): string
    {
        return $this->associationType;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setRemoteState(string $remoteState): void
    {
        $this->remoteState = $remoteState;
    }

    public function getRemoteState(): string
    {
        return $this->remoteState;
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

    public function setResult(string $result): void
    {
        $this->result = $result;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function getPerson(): Person
    {
        return $this->person;
    }

    public function setOffering(Offering $offering): void
    {
        $this->offering = $offering;
    }

    public function getOffering(): Offering
    {
        return $this->offering;
    }
}
