<?php

namespace SchemaOrg;

/**
 * Organization
 *
 * @link http://schema.org/Organization
 */
class Organization extends Thing
{
    /**
     * Address
     *
     * @var PostalAddress Physical address of the item.
     */
    protected $address;
    /**
     * Aggregate Rating
     *
     * @var AggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     */
    protected $aggregateRating;
    /**
     * Brand (Organization)
     *
     * @var Organization The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     */
    protected $brandOrganization;
    /**
     * Brand (Brand)
     *
     * @var Brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     */
    protected $brandBrand;
    /**
     * Contact Point
     *
     * @var ContactPoint A contact point for a person or organization.
     */
    protected $contactPoint;
    /**
     * Department
     *
     * @var Organization A relationship between an organization and a department of that organization, also described as an organization (allowing different urls, logos, opening hours). For example: a store with a pharmacy, or a bakery with a cafe.
     */
    protected $department;
    /**
     * Duns
     *
     * @var string The Dun & Bradstreet DUNS number for identifying an organization or business person.
     */
    protected $duns;
    /**
     * Email
     *
     * @var string Email address.
     */
    protected $email;
    /**
     * Employee
     *
     * @var Person Someone working for this organization.
     */
    protected $employee;
    /**
     * Event
     *
     * @var Event Upcoming or past event associated with this place or organization.
     */
    protected $event;
    /**
     * Fax Number
     *
     * @var string The fax number.
     */
    protected $faxNumber;
    /**
     * Founder
     *
     * @var Person A person who founded this organization.
     */
    protected $founder;
    /**
     * Founding Date
     *
     * @var \DateTime The date that this organization was founded.
     */
    protected $foundingDate;
    /**
     * Global Location Number
     *
     * @var string The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.
     */
    protected $globalLocationNumber;
    /**
     * Has POS
     *
     * @var Place Points-of-Sales operated by the organization or person.
     */
    protected $hasPOS;
    /**
     * Interaction Count
     *
     * @var string A count of a specific user interactions with this item—for example, <code>20 UserLikes</code>, <code>5 UserComments</code>, or <code>300 UserDownloads</code>. The user interaction type should be one of the sub types of <a href="http://schema.org/UserInteraction">UserInteraction</a>.
     */
    protected $interactionCount;
    /**
     * Isic V4
     *
     * @var string The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.
     */
    protected $isicV4;
    /**
     * Legal Name
     *
     * @var string The official name of the organization, e.g. the registered company name.
     */
    protected $legalName;
    /**
     * Location (PostalAddress)
     *
     * @var PostalAddress The location of the event, organization or action.
     */
    protected $locationPostalAddress;
    /**
     * Location (Place)
     *
     * @var Place The location of the event, organization or action.
     */
    protected $locationPlace;
    /**
     * Logo (URL)
     *
     * @var string A logo associated with an organization.
     */
    protected $logoURL;
    /**
     * Logo (ImageObject)
     *
     * @var ImageObject A logo associated with an organization.
     */
    protected $logoImageObject;
    /**
     * Makes Offer
     *
     * @var Offer A pointer to products or services offered by the organization or person.
     */
    protected $makesOffer;
    /**
     * Member (Organization)
     *
     * @var Organization A member of this organization.
     */
    protected $memberOrganization;
    /**
     * Member (Person)
     *
     * @var Person A member of this organization.
     */
    protected $memberPerson;
    /**
     * Naics
     *
     * @var string The North American Industry Classification System (NAICS) code for a particular organization or business person.
     */
    protected $naics;
    /**
     * Owns (OwnershipInfo)
     *
     * @var OwnershipInfo Products owned by the organization or person.
     */
    protected $ownsOwnershipInfo;
    /**
     * Owns (Product)
     *
     * @var Product Products owned by the organization or person.
     */
    protected $ownsProduct;
    /**
     * Review
     *
     * @var Review A review of the item.
     */
    protected $review;
    /**
     * Seeks
     *
     * @var Demand A pointer to products or services sought by the organization or person (demand).
     */
    protected $seeks;
    /**
     * Sub Organization
     *
     * @var Organization A relationship between two organizations where the first includes the second, e.g., as a subsidiary. See also: the more specific 'department' property.
     */
    protected $subOrganization;
    /**
     * Tax ID
     *
     * @var string The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.
     */
    protected $taxID;
    /**
     * Telephone
     *
     * @var string The telephone number.
     */
    protected $telephone;
    /**
     * Vat ID
     *
     * @var string The Value-added Tax ID of the organisation or person.
     */
    protected $vatID;
}
