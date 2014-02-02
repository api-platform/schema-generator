<?php

namespace SchemaOrg;

/**
 * Medical Risk Factor
 *
 * @link http://schema.org/MedicalRiskFactor
 */
class MedicalRiskFactor extends MedicalEntity
{
    /**
     * Increases Risk of
     *
     * @var MedicalEntity The condition, complication, etc. influenced by this factor.
     */
    protected $increasesRiskOf;
}
