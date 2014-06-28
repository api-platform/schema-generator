<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Entity
 * 
 * @link http://schema.org/MedicalEntity
 * 
 * @ORM\MappedSuperclass
 */
class MedicalEntity extends Thing
{
    /**
     * Code
     * 
     * @var MedicalCode $code A medical code for the entity, taken from a controlled vocabulary or ontology such as ICD-9, DiseasesDB, MeSH, SNOMED-CT, RxNorm, etc.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalCode")
     */
    private $code;
    /**
     * Guideline
     * 
     * @var MedicalGuideline $guideline A medical guideline related to this entity.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalGuideline")
     */
    private $guideline;
    /**
     * Medicine System
     * 
     * @var MedicineSystem $medicineSystem The system of medicine that includes this MedicalEntity, for example 'evidence-based', 'homeopathic', 'chiropractic', etc.
     * 
     * @ORM\ManyToOne(targetEntity="MedicineSystem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medicineSystem;
    /**
     * Recognizing Authority
     * 
     * @var Organization $recognizingAuthority If applicable, the organization that officially recognizes this entity as part of its endorsed system of medicine.
     * 
     */
    private $recognizingAuthority;
    /**
     * Relevant Specialty
     * 
     * @var MedicalSpecialty $relevantSpecialty If applicable, a medical specialty in which this entity is relevant.
     * 
     */
    private $relevantSpecialty;
    /**
     * Study
     * 
     * @var MedicalStudy $study A medical study or trial related to this entity.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalStudy")
     */
    private $study;
}
