<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Drug Class
 * 
 * @link http://schema.org/DrugClass
 * 
 * @ORM\Entity
 */
class DrugClass extends MedicalTherapy
{
    /**
     * Drug
     * 
     * @var Drug $drug A drug in this drug class.
     * 
     * @ORM\ManyToOne(targetEntity="Drug")
     */
    private $drug;
}
