<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of expressing a consistency of opinion with the object. An agent agrees to/about an object (a proposition, topic or theme) with participants.
 * 
 * @see http://schema.org/AgreeAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AgreeAction extends ReactAction
{
}
