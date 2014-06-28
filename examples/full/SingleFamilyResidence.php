<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Single Family Residence
 * 
 * @link http://schema.org/SingleFamilyResidence
 * 
 * @ORM\Entity
 */
class SingleFamilyResidence extends Residence
{
}
