<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A complex mathematical calculation requiring an online calculator, used to assess prognosis. Note: use the url property of Thing to record any URLs for online calculators.
 * 
 * @see http://schema.org/MedicalRiskCalculator Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalRiskCalculator extends MedicalRiskEstimator
{
}
