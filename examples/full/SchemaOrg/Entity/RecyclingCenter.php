<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A recycling center.
 * 
 * @see http://schema.org/RecyclingCenter Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RecyclingCenter extends LocalBusiness
{
}
