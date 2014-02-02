<?php

namespace SchemaOrg;

/**
 * Web Page
 *
 * @link http://schema.org/WebPage
 */
class WebPage extends CreativeWork
{
    /**
     * Breadcrumb
     *
     * @var string A set of links that can help a user understand and navigate a website hierarchy.
     */
    protected $breadcrumb;
    /**
     * Is Part of
     *
     * @var CollectionPage Indicates the collection or gallery to which the item belongs.
     */
    protected $isPartOf;
    /**
     * Last Reviewed
     *
     * @var \DateTime Date on which the content on this web page was last reviewed for accuracy and/or completeness.
     */
    protected $lastReviewed;
    /**
     * Main Content of Page
     *
     * @var WebPageElement Indicates if this web page element is the main subject of the page.
     */
    protected $mainContentOfPage;
    /**
     * Primary Image of Page
     *
     * @var ImageObject Indicates the main image on the page
     */
    protected $primaryImageOfPage;
    /**
     * Related Link
     *
     * @var string A link related to this web page, for example to other related web pages.
     */
    protected $relatedLink;
    /**
     * Reviewed by (Organization)
     *
     * @var Organization People or organizations that have reviewed the content on this web page for accuracy and/or completeness.
     */
    protected $reviewedByOrganization;
    /**
     * Reviewed by (Person)
     *
     * @var Person People or organizations that have reviewed the content on this web page for accuracy and/or completeness.
     */
    protected $reviewedByPerson;
    /**
     * Significant Link
     *
     * @var string One of the more significant URLs on the page. Typically, these are the non-navigation links that are clicked on the most.
     */
    protected $significantLink;
    /**
     * Specialty
     *
     * @var Specialty One of the domain specialities to which this web page's content applies.
     */
    protected $specialty;
}
