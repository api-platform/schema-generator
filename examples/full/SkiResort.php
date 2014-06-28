<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ski Resort
 * 
 * @link http://schema.org/SkiResort
 * 
 * @ORM\Entity
 */
class SkiResort extends SportsActivityLocation
{
}
