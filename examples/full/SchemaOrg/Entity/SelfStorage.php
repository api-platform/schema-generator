<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A self-storage facility.
 * 
 * @see http://schema.org/SelfStorage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SelfStorage extends LocalBusiness
{
}
