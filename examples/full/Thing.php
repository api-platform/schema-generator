<?php

namespace SchemaOrg;

/**
 * Thing
 *
 * @link http://schema.org/Thing
 */
class Thing
{
    /**
     * Additional Type
     *
     * @var string An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax. This is a relationship between something and a class that the thing is in. In RDFa syntax, it is better to use the native RDFa syntax - the 'typeof' attribute - for multiple types. Schema.org tools may have only weaker understanding of extra types, in particular those defined externally.
     */
    protected $additionalType;
    /**
     * Alternate Name
     *
     * @var string An alias for the item.
     */
    protected $alternateName;
    /**
     * Description
     *
     * @var string A short description of the item.
     */
    protected $description;
    /**
     * Image
     *
     * @var string URL of an image of the item.
     */
    protected $image;
    /**
     * Name
     *
     * @var string The name of the item.
     */
    protected $name;
    /**
     * Same As
     *
     * @var string URL of a reference Web page that unambiguously indicates the item's identity. E.g. the URL of the item's Wikipedia page, Freebase page, or official website.
     */
    protected $sameAs;
    /**
     * URL
     *
     * @var string URL of the item.
     */
    protected $url;
}
