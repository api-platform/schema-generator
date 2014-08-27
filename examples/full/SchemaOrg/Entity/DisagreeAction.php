<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of expressing a difference of opinion with the object. An agent disagrees to/about an object (a proposition, topic or theme) with participants.
 * 
 * @see http://schema.org/DisagreeAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DisagreeAction extends ReactAction
{
}
