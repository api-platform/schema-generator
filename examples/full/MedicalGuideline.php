<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Guideline
 * 
 * @link http://schema.org/MedicalGuideline
 * 
 * @ORM\MappedSuperclass
 */
class MedicalGuideline extends MedicalEntity
{
    /**
     * Evidence Level
     * 
     * @var MedicalEvidenceLevel $evidenceLevel Strength of evidence of the data used to formulate the guideline (enumerated).
     * 
     */
    private $evidenceLevel;
    /**
     * Evidence Origin
     * 
     * @var string $evidenceOrigin Source of the data used to formulate the guidance, e.g. RCT, consensus opinion, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $evidenceOrigin;
    /**
     * Guideline Date
     * 
     * @var \DateTime $guidelineDate Date on which this guideline's recommendation was made.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $guidelineDate;
    /**
     * Guideline Subject
     * 
     * @var MedicalEntity $guidelineSubject The medical conditions, treatments, etc. that are the subject of the guideline.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $guidelineSubject;
}
