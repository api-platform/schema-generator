<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Item List
 * 
 * @link http://schema.org/ItemList
 * 
 * @ORM\Entity
 */
class ItemList extends CreativeWork
{
    /**
     * Item List Element
     * 
     * @var string $itemListElement A single list item.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $itemListElement;
    /**
     * Item List Order
     * 
     * @var string $itemListOrder Type of ordering (e.g. Ascending, Descending, Unordered).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $itemListOrder;
}
