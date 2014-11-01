<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The maximum dosing schedule considered safe for a drug or supplement as recommended by an authority or by the drug/supplement's manufacturer. Capture the recommending authority in the recognizingAuthority property of MedicalEntity.
 * 
 * @see http://schema.org/MaximumDoseSchedule Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MaximumDoseSchedule extends DoseSchedule
{
}
