<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An agent approves/certifies/likes/supports/sanction an object.
 * 
 * @see http://schema.org/EndorseAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EndorseAction extends ReactAction
{
    /**
     */
    private $endorsee;
}
