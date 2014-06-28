<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reported Dose Schedule
 * 
 * @link http://schema.org/ReportedDoseSchedule
 * 
 * @ORM\Entity
 */
class ReportedDoseSchedule extends DoseSchedule
{
}
