<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bowling Alley
 * 
 * @link http://schema.org/BowlingAlley
 * 
 * @ORM\Entity
 */
class BowlingAlley extends SportsActivityLocation
{
}
