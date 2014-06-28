<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Thing
 * 
 * @link http://schema.org/Thing
 * 
 * @ORM\MappedSuperclass
 */
class Thing
{
    /**
     * Additional Type
     * 
     * @var string $additionalType An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax. This is a relationship between something and a class that the thing is in. In RDFa syntax, it is better to use the native RDFa syntax - the 'typeof' attribute - for multiple types. Schema.org tools may have only weaker understanding of extra types, in particular those defined externally.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $additionalType;
    /**
     * Alternate Name
     * 
     * @var string $alternateName An alias for the item.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $alternateName;
    /**
     * Description
     * 
     * @var string $description A short description of the item.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $description;
    /**
     * Image
     * 
     * @var string $image URL of an image of the item.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $image;
    /**
     * Name
     * 
     * @var string $name The name of the item.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $name;
    /**
     * Same As
     * 
     * @var string $sameAs URL of a reference Web page that unambiguously indicates the item's identity. E.g. the URL of the item's Wikipedia page, Freebase page, or official website.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $sameAs;
    /**
     * URL
     * 
     * @var string $url URL of the item.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $url;
}
