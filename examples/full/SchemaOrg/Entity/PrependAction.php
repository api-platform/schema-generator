<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of inserting at the beginning if an ordered collection.
 * 
 * @see http://schema.org/PrependAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PrependAction extends InsertAction
{
}
