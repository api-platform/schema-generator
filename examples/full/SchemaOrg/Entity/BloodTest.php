<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A medical test performed on a sample of a patient's blood.
 * 
 * @see http://schema.org/BloodTest Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BloodTest extends MedicalTest
{
}
