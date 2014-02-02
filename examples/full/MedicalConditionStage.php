<?php

namespace SchemaOrg;

/**
 * Medical Condition Stage
 *
 * @link http://schema.org/MedicalConditionStage
 */
class MedicalConditionStage extends MedicalIntangible
{
    /**
     * Stage As Number
     *
     * @var float The stage represented as a number, e.g. 3.
     */
    protected $stageAsNumber;
    /**
     * Sub Stage Suffix
     *
     * @var string The substage, e.g. 'a' for Stage IIIa.
     */
    protected $subStageSuffix;
}
