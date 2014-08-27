<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Childcare center.
 * 
 * @see http://schema.org/ChildCare Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ChildCare extends LocalBusiness
{
}
