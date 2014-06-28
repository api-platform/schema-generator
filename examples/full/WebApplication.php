<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web Application
 * 
 * @link http://schema.org/WebApplication
 * 
 * @ORM\Entity
 */
class WebApplication extends SoftwareApplication
{
    /**
     * Browser Requirements
     * 
     * @var string $browserRequirements Specifies browser requirements in human-readable text. For example,"requires HTML5 support".
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $browserRequirements;
}
