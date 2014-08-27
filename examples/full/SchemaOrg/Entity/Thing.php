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
     * @type string $additionalType An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax. This is a relationship between something and a class that the thing is in. In RDFa syntax, it is better to use the native RDFa syntax - the 'typeof' attribute - for multiple types. Schema.org tools may have only weaker understanding of extra types, in particular those defined externally.
     * @Assert\Url
     * @ORM\Column
     */
    private $additionalType;
    /**
     * @type string $alternateName An alias for the item.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $alternateName;
    /**
     * @type string $description A short description of the item.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $description;
    /**
     * @type string $image URL of an image of the item.
     * @Assert\Url
     * @ORM\Column
     */
    private $image;
    /**
     * @type string $name The name of the item.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $name;
    /**
     * @type string $sameAs URL of a reference Web page that unambiguously indicates the item's identity. E.g. the URL of the item's Wikipedia page, Freebase page, or official website.
     * @Assert\Url
     * @ORM\Column
     */
    private $sameAs;
    /**
     * @type string $url URL of the item.
     * @Assert\Url
     * @ORM\Column
     */
    private $url;
    /**
     * @type Action $potentialAction Indicates a potential Action, which describes an idealized action in which this thing would play an 'object' role.
     */
    private $potentialAction;
}
