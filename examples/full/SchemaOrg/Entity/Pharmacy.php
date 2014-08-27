<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A pharmacy or drugstore.
 * 
 * @see http://schema.org/Pharmacy Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Pharmacy extends MedicalOrganization
{
}
