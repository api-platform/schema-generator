<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Organization: Non-governmental Organization.
 * 
 * @see http://schema.org/NGO Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class NGO extends Organization
{
}
