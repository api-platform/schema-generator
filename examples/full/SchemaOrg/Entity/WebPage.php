<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A web page. Every web page is implicitly assumed to be declared to be of type WebPage, so the various properties about that webpage, such as <code>breadcrumb</code> may be used. We recommend explicit declaration if these properties are specified, but if they are found outside of an itemscope, they will be assumed to be about the page
 * 
 * @see http://schema.org/WebPage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WebPage extends CreativeWork
{
    /**
     * @type string $breadcrumb A set of links that can help a user understand and navigate a website hierarchy.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $breadcrumb;
    /**
     * @type \DateTime $lastReviewed Date on which the content on this web page was last reviewed for accuracy and/or completeness.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $lastReviewed;
    /**
     * @type WebPageElement $mainContentOfPage Indicates if this web page element is the main subject of the page.
     */
    private $mainContentOfPage;
    /**
     * @type ImageObject $primaryImageOfPage Indicates the main image on the page.
     */
    private $primaryImageOfPage;
    /**
     * @type string $relatedLink A link related to this web page, for example to other related web pages.
     * @Assert\Url
     * @ORM\Column
     */
    private $relatedLink;
    /**
     * @type Organization $reviewedBy People or organizations that have reviewed the content on this web page for accuracy and/or completeness.
     */
    private $reviewedBy;
    /**
     * @type string $significantLink One of the more significant URLs on the page. Typically, these are the non-navigation links that are clicked on the most.
     * @Assert\Url
     * @ORM\Column
     */
    private $significantLink;
    /**
     * @type Specialty $specialty One of the domain specialities to which this web page's content applies.
     */
    private $specialty;
}
