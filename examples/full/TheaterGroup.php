<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Theater Group
 * 
 * @link http://schema.org/TheaterGroup
 * 
 * @ORM\Entity
 */
class TheaterGroup extends PerformingGroup
{
}
