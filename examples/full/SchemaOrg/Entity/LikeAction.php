<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of expressing a positive sentiment about the object. An agent likes an object (a proposition, topic or theme) with participants.
 * 
 * @see http://schema.org/LikeAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LikeAction extends ReactAction
{
}
