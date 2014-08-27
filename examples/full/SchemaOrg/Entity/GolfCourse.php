<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A golf course.
 * 
 * @see http://schema.org/GolfCourse Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GolfCourse extends SportsActivityLocation
{
}
