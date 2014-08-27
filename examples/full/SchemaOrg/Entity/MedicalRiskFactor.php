<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A risk factor is anything that increases a person's likelihood of developing or contracting a disease, medical condition, or complication.
 * 
 * @see http://schema.org/MedicalRiskFactor Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalRiskFactor extends MedicalEntity
{
    /**
     * @type MedicalEntity $increasesRiskOf The condition, complication, etc. influenced by this factor.
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $increasesRiskOf;
}
