<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of authoring written creative content.
 * 
 * @see http://schema.org/WriteAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WriteAction extends CreateAction
{
    /**
     * @type Language $language A sub property of instrument. The language used on this action.
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $language;
}
