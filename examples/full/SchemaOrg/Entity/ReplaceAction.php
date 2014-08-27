<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of editing a recipient by replacing an old object with a new object.
 * 
 * @see http://schema.org/ReplaceAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReplaceAction extends UpdateAction
{
    /**
     * @type Thing $replacee A sub property of object. The object that is being replaced.
     * @ORM\ManyToOne(targetEntity="Thing")
     */
    private $replacee;
    /**
     * @type Thing $replacer A sub property of object. The object that replaces.
     * @ORM\ManyToOne(targetEntity="Thing")
     */
    private $replacer;
}
