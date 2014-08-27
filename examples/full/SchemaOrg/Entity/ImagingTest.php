<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any medical imaging modality typically used for diagnostic purposes.
 * 
 * @see http://schema.org/ImagingTest Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ImagingTest extends MedicalTest
{
    /**
     * @type MedicalImagingTechnique $imagingTechnique Imaging technique used.
     */
    private $imagingTechnique;
}
