<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A performance group, such as a band, an orchestra, or a circus.
 * 
 * @see http://schema.org/PerformingGroup Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PerformingGroup extends Organization
{
}
