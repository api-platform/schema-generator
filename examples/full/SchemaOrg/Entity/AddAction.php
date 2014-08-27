<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of editing by adding an object to a collection.
 * 
 * @see http://schema.org/AddAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AddAction extends UpdateAction
{
}
