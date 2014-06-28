<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sports Activity Location
 * 
 * @link http://schema.org/SportsActivityLocation
 * 
 * @ORM\MappedSuperclass
 */
class SportsActivityLocation extends LocalBusiness
{
}
