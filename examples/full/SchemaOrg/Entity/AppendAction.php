<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of inserting at the end if an ordered collection.
 * 
 * @see http://schema.org/AppendAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AppendAction extends InsertAction
{
}
