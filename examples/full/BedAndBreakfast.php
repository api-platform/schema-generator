<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bed And Breakfast
 * 
 * @link http://schema.org/BedAndBreakfast
 * 
 * @ORM\Entity
 */
class BedAndBreakfast extends LodgingBusiness
{
}
