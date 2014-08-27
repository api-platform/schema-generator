<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Quantity: Duration (use  <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 duration format</a>).
 * 
 * @see http://schema.org/Duration Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Duration extends Quantity
{
}
