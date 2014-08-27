<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A recommended dosing schedule for a drug or supplement as prescribed or recommended by an authority or by the drug/supplement's manufacturer. Capture the recommending authority in the recognizingAuthority property of MedicalEntity.
 * 
 * @see http://schema.org/RecommendedDoseSchedule Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RecommendedDoseSchedule extends DoseSchedule
{
}
