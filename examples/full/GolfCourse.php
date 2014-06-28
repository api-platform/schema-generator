<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Golf Course
 * 
 * @link http://schema.org/GolfCourse
 * 
 * @ORM\Entity
 */
class GolfCourse extends SportsActivityLocation
{
}
