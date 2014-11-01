<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The most generic type of item.
 * 
 * @see http://schema.org/Thing Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Thing
{
    /**
     */
    private $additionalType;
    /**
     */
    private $alternateName;
    /**
     */
    private $description;
    /**
     */
    private $image;
    /**
     */
    private $name;
    /**
     */
    private $sameAs;
    /**
     */
    private $url;
    /**
     */
    private $potentialAction;
}
