<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Public Swimming Pool
 * 
 * @link http://schema.org/PublicSwimmingPool
 * 
 * @ORM\Entity
 */
class PublicSwimmingPool extends SportsActivityLocation
{
}
