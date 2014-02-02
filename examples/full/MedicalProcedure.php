<?php

namespace SchemaOrg;

/**
 * Medical Procedure
 *
 * @link http://schema.org/MedicalProcedure
 */
class MedicalProcedure extends MedicalEntity
{
    /**
     * Followup
     *
     * @var string Typical or recommended followup care after the procedure is performed.
     */
    protected $followup;
    /**
     * How Performed
     *
     * @var string How the procedure is performed.
     */
    protected $howPerformed;
    /**
     * Preparation
     *
     * @var string Typical preparation that a patient must undergo before having the procedure performed.
     */
    protected $preparation;
    /**
     * Procedure Type
     *
     * @var MedicalProcedureType The type of procedure, for example Surgical, Noninvasive, or Percutaneous.
     */
    protected $procedureType;
}
