<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A medical organization, such as a doctor's office or clinic.
 * 
 * @see http://schema.org/MedicalOrganization Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalOrganization extends LocalBusiness
{
}
