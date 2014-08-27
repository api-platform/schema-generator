<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A software application designed specifically to work well on a mobile device such as a telephone.
 * 
 * @see http://schema.org/MobileApplication Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MobileApplication extends SoftwareApplication
{
    /**
     * @type string $carrierRequirements Specifies specific carrier(s) requirements for the application (e.g. an application may only work on a specific carrier network).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $carrierRequirements;
}
