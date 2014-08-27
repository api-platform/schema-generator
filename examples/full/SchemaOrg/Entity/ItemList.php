<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A list of items of any sort&#x2014;for example, Top 10 Movies About Weathermen, or Top 100 Party Songs. Not to be confused with HTML lists, which are often used only for formatting.
 * 
 * @see http://schema.org/ItemList Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ItemList extends CreativeWork
{
    /**
     * @type string $itemListElement A single list item.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $itemListElement;
    /**
     * @type string $itemListOrder Type of ordering (e.g. Ascending, Descending, Unordered).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $itemListOrder;
}
