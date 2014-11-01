<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of consuming audio content.
 * 
 * @see http://schema.org/ListenAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ListenAction extends ConsumeAction
{
}
