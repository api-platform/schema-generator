<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The legal availability status of a medical drug.
 * 
 * @see http://schema.org/DrugLegalStatus Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DrugLegalStatus extends MedicalIntangible
{
    /**
     * @type AdministrativeArea $applicableLocation The location in which the status applies.
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $applicableLocation;
}
