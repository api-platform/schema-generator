<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any specific branch of medical science or practice. Medical specialities include clinical specialties that pertain to particular organ systems and their respective disease states, as well as allied health specialties. Enumerated type.
 * 
 * @see http://schema.org/MedicalSpecialty Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalSpecialty extends MedicalEnumeration
{
}
