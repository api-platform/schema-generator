<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of searching for an object.<p>Related actions:</p><ul><li><a href="http://schema.org/FindAction">FindAction</a>: SearchAction generally leads to a FindAction, but not necessarily.</li></ul>
 * 
 * @see http://schema.org/SearchAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SearchAction extends Action
{
    /**
     * @type Class $query A sub property of instrument. The query used on this action.
     * @ORM\ManyToOne(targetEntity="Class")
     */
    private $query;
}
