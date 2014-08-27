<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A map.
 * 
 * @see http://schema.org/Map Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Map extends CreativeWork
{
    /**
     * @type MapCategoryType $mapType Indicates the kind of Map, from the MapCategoryType Enumeration.
     */
    private $mapType;
}
