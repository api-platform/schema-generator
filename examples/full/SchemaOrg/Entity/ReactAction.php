<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of responding instinctively and emotionally to an object, expressing a sentiment.
 * 
 * @see http://schema.org/ReactAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReactAction extends AssessAction
{
}
