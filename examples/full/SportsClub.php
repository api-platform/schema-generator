<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sports Club
 * 
 * @link http://schema.org/SportsClub
 * 
 * @ORM\Entity
 */
class SportsClub extends SportsActivityLocation
{
}
