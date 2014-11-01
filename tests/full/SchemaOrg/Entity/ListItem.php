<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An list item, e.g. a step in a checklist or how-to description.
 * 
 * @see http://schema.org/ListItem Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ListItem extends Intangible
{
    /**
     */
    private $position;
    /**
     */
    private $item;
    /**
     */
    private $previousItem;
    /**
     */
    private $nextItem;
}
