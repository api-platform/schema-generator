<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of managing by changing/editing the state of the object.
 * 
 * @see http://schema.org/UpdateAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UpdateAction extends Action
{
    /**
     * @type Thing $collection A sub property of object. The collection target of the action.
     * @ORM\ManyToOne(targetEntity="Thing")
     */
    private $collection;
}
