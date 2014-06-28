<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dance Group
 * 
 * @link http://schema.org/DanceGroup
 * 
 * @ORM\Entity
 */
class DanceGroup extends PerformingGroup
{
}
