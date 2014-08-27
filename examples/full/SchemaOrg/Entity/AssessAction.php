<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of forming one's opinion, reaction or sentiment.
 * 
 * @see http://schema.org/AssessAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AssessAction extends Action
{
}
