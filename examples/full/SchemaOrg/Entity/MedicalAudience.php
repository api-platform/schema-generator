<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Target audiences for medical web pages. Enumerated type.
 * 
 * @see http://schema.org/MedicalAudience Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalAudience extends Audience
{
}
