<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Performing Group
 * 
 * @link http://schema.org/PerformingGroup
 * 
 * @ORM\MappedSuperclass
 */
class PerformingGroup extends Organization
{
}
