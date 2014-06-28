<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Church
 * 
 * @link http://schema.org/Church
 * 
 * @ORM\Entity
 */
class Church extends PlaceOfWorship
{
}
