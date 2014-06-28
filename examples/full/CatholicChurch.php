<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Catholic Church
 * 
 * @link http://schema.org/CatholicChurch
 * 
 * @ORM\Entity
 */
class CatholicChurch extends PlaceOfWorship
{
}
