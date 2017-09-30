<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PhpScoper59cf7a2150abb\ApiPlatform\Core\Annotation\ApiProperty;
use PhpScoper59cf7a2150abb\ApiPlatform\Core\Annotation\ApiResource;
use PhpScoper59cf7a2150abb\Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use PhpScoper59cf7a2150abb\Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The most generic type of item.
 * 
 * @see http://schema.org/Thing Documentation on Schema.org
 * 
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Thing")
 */
class Thing
{

    /**
     * @var integer|null 
     * 
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null The name of the item.
     * 
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/name")
     */
    private $name;




    /**
     */
    public function getId(): ?int    {
        return $this->id;
    }

    /**
     */
    public function setName(?string $name): void    {
        $this->name = $name;

    }

    /**
     */
    public function getName(): ?string    {
        return $this->name;
    }

}
