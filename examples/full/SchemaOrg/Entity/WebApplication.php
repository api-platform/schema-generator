<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web applications.
 * 
 * @see http://schema.org/WebApplication Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WebApplication extends SoftwareApplication
{
    /**
     * @type string $browserRequirements Specifies browser requirements in human-readable text. For example,"requires HTML5 support".
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $browserRequirements;
}
