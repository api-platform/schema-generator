<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of expressing a negative sentiment about the object. An agent dislikes an object (a proposition, topic or theme) with participants.
 * 
 * @see http://schema.org/DislikeAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DislikeAction extends ReactAction
{
}
