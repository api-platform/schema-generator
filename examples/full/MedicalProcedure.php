<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Procedure
 * 
 * @link http://schema.org/MedicalProcedure
 * 
 * @ORM\MappedSuperclass
 */
class MedicalProcedure extends MedicalEntity
{
    /**
     * Followup
     * 
     * @var string $followup Typical or recommended followup care after the procedure is performed.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $followup;
    /**
     * How Performed
     * 
     * @var string $howPerformed How the procedure is performed.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $howPerformed;
    /**
     * Preparation
     * 
     * @var string $preparation Typical preparation that a patient must undergo before having the procedure performed.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $preparation;
    /**
     * Procedure Type
     * 
     * @var MedicalProcedureType $procedureType The type of procedure, for example Surgical, Noninvasive, or Percutaneous.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalProcedureType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $procedureType;
}
