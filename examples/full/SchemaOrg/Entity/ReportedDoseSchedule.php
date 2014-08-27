<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A patient-reported or observed dosing schedule for a drug or supplement.
 * 
 * @see http://schema.org/ReportedDoseSchedule Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReportedDoseSchedule extends DoseSchedule
{
}
