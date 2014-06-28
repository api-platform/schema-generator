<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Condition Stage
 * 
 * @link http://schema.org/MedicalConditionStage
 * 
 * @ORM\Entity
 */
class MedicalConditionStage extends MedicalIntangible
{
    /**
     * Stage As Number
     * 
     * @var float $stageAsNumber The stage represented as a number, e.g. 3.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $stageAsNumber;
    /**
     * Sub Stage Suffix
     * 
     * @var string $subStageSuffix The substage, e.g. 'a' for Stage IIIa.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $subStageSuffix;
}
