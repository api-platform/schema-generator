<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An email message.
 * 
 * @see http://schema.org/EmailMessage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EmailMessage extends CreativeWork
{
}
