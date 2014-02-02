<?php

namespace SchemaOrg;

/**
 * Medical Sign
 *
 * @link http://schema.org/MedicalSign
 */
class MedicalSign extends MedicalSignOrSymptom
{
    /**
     * Identifying Exam
     *
     * @var PhysicalExam A physical examination that can identify this sign.
     */
    protected $identifyingExam;
    /**
     * Identifying Test
     *
     * @var MedicalTest A diagnostic test that can identify this sign.
     */
    protected $identifyingTest;
}
