<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A process of care used in either a diagnostic, therapeutic, or palliative capacity that relies on invasive (surgical), non-invasive, or percutaneous techniques.
 * 
 * @see http://schema.org/MedicalProcedure Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalProcedure extends MedicalEntity
{
    /**
     * @type string $followup Typical or recommended followup care after the procedure is performed.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $followup;
    /**
     * @type string $howPerformed How the procedure is performed.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $howPerformed;
    /**
     * @type string $preparation Typical preparation that a patient must undergo before having the procedure performed.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $preparation;
    /**
     * @type MedicalProcedureType $procedureType The type of procedure, for example Surgical, Noninvasive, or Percutaneous.
     * @ORM\ManyToOne(targetEntity="MedicalProcedureType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $procedureType;
}
