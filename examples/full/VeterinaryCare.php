<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Veterinary Care
 * 
 * @link http://schema.org/VeterinaryCare
 * 
 * @ORM\Entity
 */
class VeterinaryCare extends MedicalOrganization
{
}
