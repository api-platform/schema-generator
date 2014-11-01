<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A post office.
 * 
 * @see http://schema.org/PostOffice Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PostOffice extends GovernmentOffice
{
}
