<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A condition or factor that indicates use of a medical therapy, including signs, symptoms, risk factors, anatomical states, etc.
 * 
 * @see http://schema.org/MedicalIndication Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalIndication extends MedicalEntity
{
}
