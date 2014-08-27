<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A stage of a medical condition, such as 'Stage IIIa'.
 * 
 * @see http://schema.org/MedicalConditionStage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalConditionStage extends MedicalIntangible
{
    /**
     * @type float $stageAsNumber The stage represented as a number, e.g. 3.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $stageAsNumber;
    /**
     * @type string $subStageSuffix The substage, e.g. 'a' for Stage IIIa.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $subStageSuffix;
}
