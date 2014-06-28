<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mobile Application
 * 
 * @link http://schema.org/MobileApplication
 * 
 * @ORM\Entity
 */
class MobileApplication extends SoftwareApplication
{
    /**
     * Carrier Requirements
     * 
     * @var string $carrierRequirements Specifies specific carrier(s) requirements for the application (e.g. an application may only work on a specific carrier network).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $carrierRequirements;
}
