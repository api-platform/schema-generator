<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A chemical or biologic substance, used as a medical therapy, that has a physiological effect on an organism.
 * 
 * @see http://schema.org/Drug Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Drug extends MedicalTherapy
{
    /**
     */
    private $activeIngredient;
    /**
     */
    private $administrationRoute;
    /**
     */
    private $alcoholWarning;
    /**
     */
    private $availableStrength;
    /**
     */
    private $breastfeedingWarning;
    /**
     */
    private $clincalPharmacology;
    /**
     */
    private $cost;
    /**
     */
    private $dosageForm;
    /**
     */
    private $doseSchedule;
    /**
     */
    private $drugClass;
    /**
     */
    private $foodWarning;
    /**
     */
    private $interactingDrug;
    /**
     */
    private $isAvailableGenerically;
    /**
     */
    private $isProprietary;
    /**
     */
    private $labelDetails;
    /**
     */
    private $legalStatus;
    /**
     */
    private $manufacturer;
    /**
     */
    private $mechanismOfAction;
    /**
     */
    private $nonProprietaryName;
    /**
     */
    private $overdosage;
    /**
     */
    private $pregnancyCategory;
    /**
     */
    private $pregnancyWarning;
    /**
     */
    private $prescribingInfo;
    /**
     */
    private $prescriptionStatus;
    /**
     */
    private $relatedDrug;
    /**
     */
    private $warning;
}
