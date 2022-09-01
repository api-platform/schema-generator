<?php

declare(strict_types=1);

namespace App\OpenApi\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: '`user`')]
#[ApiResource(operations: [new Get(), new Put(), new Delete()])]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $username;

    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $firstName;

    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $lastName;

    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $email;

    #[ORM\Column(type: 'text', name: '`password`')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $password;

    #[ORM\Column(type: 'text')]
    #[ApiProperty]
    #[Assert\NotNull]
    private string $phone;

    /**
     * User Status.
     */
    #[ORM\Column(type: 'integer')]
    #[ApiProperty]
    #[Assert\NotNull]
    private int $userStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setUserStatus(int $userStatus): void
    {
        $this->userStatus = $userStatus;
    }

    public function getUserStatus(): int
    {
        return $this->userStatus;
    }
}
