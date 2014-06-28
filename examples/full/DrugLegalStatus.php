<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Drug Legal Status
 * 
 * @link http://schema.org/DrugLegalStatus
 * 
 * @ORM\Entity
 */
class DrugLegalStatus extends MedicalIntangible
{
    /**
     * Applicable Location
     * 
     * @var AdministrativeArea $applicableLocation The location in which the status applies.
     * 
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $applicableLocation;
}
