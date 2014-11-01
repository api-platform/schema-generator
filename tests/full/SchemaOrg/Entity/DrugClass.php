<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A class of medical drugs, e.g., statins. Classes can represent general pharmacological class, common mechanisms of action, common physiological effects, etc.
 * 
 * @see http://schema.org/DrugClass Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DrugClass extends MedicalTherapy
{
    /**
     */
    private $drug;
}
