<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of generating a comment about a subject.
 * 
 * @see http://schema.org/CommentAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CommentAction extends CommunicateAction
{
}
