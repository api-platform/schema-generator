<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pharmacy
 * 
 * @link http://schema.org/Pharmacy
 * 
 * @ORM\Entity
 */
class Pharmacy extends MedicalOrganization
{
}
