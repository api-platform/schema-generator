<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The most generic type of entity related to health and the practice of medicine.
 * 
 * @see http://schema.org/MedicalEntity Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalEntity extends Thing
{
    /**
     * @type string $alternateName An alias for the item.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $alternateName;
    /**
     * @type MedicalCode $code A medical code for the entity, taken from a controlled vocabulary or ontology such as ICD-9, DiseasesDB, MeSH, SNOMED-CT, RxNorm, etc.
     * @ORM\ManyToOne(targetEntity="MedicalCode")
     */
    private $code;
    /**
     * @type MedicalGuideline $guideline A medical guideline related to this entity.
     * @ORM\ManyToOne(targetEntity="MedicalGuideline")
     */
    private $guideline;
    /**
     * @type MedicineSystem $medicineSystem The system of medicine that includes this MedicalEntity, for example 'evidence-based', 'homeopathic', 'chiropractic', etc.
     * @ORM\ManyToOne(targetEntity="MedicineSystem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medicineSystem;
    /**
     * @type Organization $recognizingAuthority If applicable, the organization that officially recognizes this entity as part of its endorsed system of medicine.
     */
    private $recognizingAuthority;
    /**
     * @type MedicalSpecialty $relevantSpecialty If applicable, a medical specialty in which this entity is relevant.
     */
    private $relevantSpecialty;
    /**
     * @type MedicalStudy $study A medical study or trial related to this entity.
     * @ORM\ManyToOne(targetEntity="MedicalStudy")
     */
    private $study;
}
