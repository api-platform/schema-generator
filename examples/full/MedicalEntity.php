<?php

namespace SchemaOrg;

/**
 * Medical Entity
 *
 * @link http://schema.org/MedicalEntity
 */
class MedicalEntity extends Thing
{
    /**
     * Code
     *
     * @var MedicalCode A medical code for the entity, taken from a controlled vocabulary or ontology such as ICD-9, DiseasesDB, MeSH, SNOMED-CT, RxNorm, etc.
     */
    protected $code;
    /**
     * Guideline
     *
     * @var MedicalGuideline A medical guideline related to this entity.
     */
    protected $guideline;
    /**
     * Medicine System
     *
     * @var MedicineSystem The system of medicine that includes this MedicalEntity, for example 'evidence-based', 'homeopathic', 'chiropractic', etc.
     */
    protected $medicineSystem;
    /**
     * Recognizing Authority
     *
     * @var Organization If applicable, the organization that officially recognizes this entity as part of its endorsed system of medicine.
     */
    protected $recognizingAuthority;
    /**
     * Relevant Specialty
     *
     * @var MedicalSpecialty If applicable, a medical specialty in which this entity is relevant.
     */
    protected $relevantSpecialty;
    /**
     * Study
     *
     * @var MedicalStudy A medical study or trial related to this entity.
     */
    protected $study;
}
