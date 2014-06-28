<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hostel
 * 
 * @link http://schema.org/Hostel
 * 
 * @ORM\Entity
 */
class Hostel extends LodgingBusiness
{
}
