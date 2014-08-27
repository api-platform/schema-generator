<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any recommendation made by a standard society (e.g. ACC/AHA) or consensus statement that denotes how to diagnose and treat a particular condition. Note: this type should be used to tag the actual guideline recommendation; if the guideline recommendation occurs in a larger scholarly article, use MedicalScholarlyArticle to tag the overall article, not this type. Note also: the organization making the recommendation should be captured in the recognizingAuthority base property of MedicalEntity.
 * 
 * @see http://schema.org/MedicalGuideline Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalGuideline extends MedicalEntity
{
    /**
     * @type MedicalEvidenceLevel $evidenceLevel Strength of evidence of the data used to formulate the guideline (enumerated).
     */
    private $evidenceLevel;
    /**
     * @type string $evidenceOrigin Source of the data used to formulate the guidance, e.g. RCT, consensus opinion, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $evidenceOrigin;
    /**
     * @type \DateTime $guidelineDate Date on which this guideline's recommendation was made.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $guidelineDate;
    /**
     * @type MedicalEntity $guidelineSubject The medical conditions, treatments, etc. that are the subject of the guideline.
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $guidelineSubject;
}
