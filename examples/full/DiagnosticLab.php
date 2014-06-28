<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Diagnostic Lab
 * 
 * @link http://schema.org/DiagnosticLab
 * 
 * @ORM\Entity
 */
class DiagnosticLab extends MedicalOrganization
{
    /**
     * Available Test
     * 
     * @var MedicalTest $availableTest A diagnostic test or procedure offered by this lab.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalTest")
     */
    private $availableTest;
}
