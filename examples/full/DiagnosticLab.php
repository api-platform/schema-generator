<?php

namespace SchemaOrg;

/**
 * Diagnostic Lab
 *
 * @link http://schema.org/DiagnosticLab
 */
class DiagnosticLab extends MedicalOrganization
{
    /**
     * Available Test
     *
     * @var MedicalTest A diagnostic test or procedure offered by this lab.
     */
    protected $availableTest;
}
