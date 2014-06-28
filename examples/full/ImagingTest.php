<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Imaging Test
 * 
 * @link http://schema.org/ImagingTest
 * 
 * @ORM\Entity
 */
class ImagingTest extends MedicalTest
{
    /**
     * Imaging Technique
     * 
     * @var MedicalImagingTechnique $imagingTechnique Imaging technique used.
     * 
     */
    private $imagingTechnique;
}
