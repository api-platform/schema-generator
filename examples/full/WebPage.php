<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web Page
 * 
 * @link http://schema.org/WebPage
 * 
 * @ORM\MappedSuperclass
 */
class WebPage extends CreativeWork
{
    /**
     * Breadcrumb
     * 
     * @var string $breadcrumb A set of links that can help a user understand and navigate a website hierarchy.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $breadcrumb;
    /**
     * Is Part of
     * 
     * @var CollectionPage $isPartOf Indicates the collection or gallery to which the item belongs.
     * 
     * @ORM\ManyToOne(targetEntity="CollectionPage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $isPartOf;
    /**
     * Last Reviewed
     * 
     * @var \DateTime $lastReviewed Date on which the content on this web page was last reviewed for accuracy and/or completeness.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $lastReviewed;
    /**
     * Main Content of Page
     * 
     * @var WebPageElement $mainContentOfPage Indicates if this web page element is the main subject of the page.
     * 
     */
    private $mainContentOfPage;
    /**
     * Primary Image of Page
     * 
     * @var ImageObject $primaryImageOfPage Indicates the main image on the page
     * 
     */
    private $primaryImageOfPage;
    /**
     * Related Link
     * 
     * @var string $relatedLink A link related to this web page, for example to other related web pages.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $relatedLink;
    /**
     * Reviewed by
     * 
     * @var Organization $reviewedBy People or organizations that have reviewed the content on this web page for accuracy and/or completeness.
     * 
     */
    private $reviewedBy;
    /**
     * Significant Link
     * 
     * @var string $significantLink One of the more significant URLs on the page. Typically, these are the non-navigation links that are clicked on the most.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $significantLink;
    /**
     * Specialty
     * 
     * @var Specialty $specialty One of the domain specialities to which this web page's content applies.
     * 
     */
    private $specialty;
}
