<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Organization
 * 
 * @link http://schema.org/Organization
 * 
 * @ORM\MappedSuperclass
 */
class Organization extends Thing
{
    /**
     * Address
     * 
     * @var PostalAddress $address Physical address of the item.
     * 
     */
    private $address;
    /**
     * Aggregate Rating
     * 
     * @var AggregateRating $aggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     * 
     * @ORM\ManyToOne(targetEntity="AggregateRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregateRating;
    /**
     * Brand
     * 
     * @var Organization $brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $brand;
    /**
     * Contact Point
     * 
     * @var ContactPoint $contactPoint A contact point for a person or organization.
     * 
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     */
    private $contactPoint;
    /**
     * Department
     * 
     * @var Organization $department A relationship between an organization and a department of that organization, also described as an organization (allowing different urls, logos, opening hours). For example: a store with a pharmacy, or a bakery with a cafe.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $department;
    /**
     * Duns
     * 
     * @var string $duns The Dun & Bradstreet DUNS number for identifying an organization or business person.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $duns;
    /**
     * Email
     * 
     * @var string $email Email address.
     * 
     * @Assert\Email
     * @ORM\Column
     */
    private $email;
    /**
     * Employee
     * 
     * @var Person $employee Someone working for this organization.
     * 
     */
    private $employee;
    /**
     * Event
     * 
     * @var Event $event Upcoming or past event associated with this place or organization.
     * 
     */
    private $event;
    /**
     * Fax Number
     * 
     * @var string $faxNumber The fax number.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $faxNumber;
    /**
     * Founder
     * 
     * @var Person $founder A person who founded this organization.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $founder;
    /**
     * Founding Date
     * 
     * @var \DateTime $foundingDate The date that this organization was founded.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $foundingDate;
    /**
     * Global Location Number
     * 
     * @var string $globalLocationNumber The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $globalLocationNumber;
    /**
     * Has POS
     * 
     * @var Place $hasPOS Points-of-Sales operated by the organization or person.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $hasPOS;
    /**
     * Interaction Count
     * 
     * @var string $interactionCount A count of a specific user interactions with this item—for example, 20 UserLikes, 5 UserComments, or 300 UserDownloads. The user interaction type should be one of the sub types of UserInteraction.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $interactionCount;
    /**
     * Isic V4
     * 
     * @var string $isicV4 The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $isicV4;
    /**
     * Legal Name
     * 
     * @var string $legalName The official name of the organization, e.g. the registered company name.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $legalName;
    /**
     * Location
     * 
     * @var PostalAddress $location The location of the event, organization or action.
     * 
     * @ORM\ManyToOne(targetEntity="PostalAddress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;
    /**
     * Logo
     * 
     * @var string $logo A logo associated with an organization.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $logo;
    /**
     * Makes Offer
     * 
     * @var Offer $makesOffer A pointer to products or services offered by the organization or person.
     * 
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $makesOffer;
    /**
     * Member
     * 
     * @var Organization $member A member of this organization.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $member;
    /**
     * Naics
     * 
     * @var string $naics The North American Industry Classification System (NAICS) code for a particular organization or business person.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $naics;
    /**
     * Owns
     * 
     * @var OwnershipInfo $owns Products owned by the organization or person.
     * 
     * @ORM\ManyToOne(targetEntity="OwnershipInfo")
     */
    private $owns;
    /**
     * Review
     * 
     * @var Review $review A review of the item.
     * 
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $review;
    /**
     * Seeks
     * 
     * @var Demand $seeks A pointer to products or services sought by the organization or person (demand).
     * 
     * @ORM\ManyToOne(targetEntity="Demand")
     */
    private $seeks;
    /**
     * Sub Organization
     * 
     * @var Organization $subOrganization A relationship between two organizations where the first includes the second, e.g., as a subsidiary. See also: the more specific 'department' property.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $subOrganization;
    /**
     * Tax ID
     * 
     * @var string $taxID The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $taxID;
    /**
     * Telephone
     * 
     * @var string $telephone The telephone number.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $telephone;
    /**
     * Vat ID
     * 
     * @var string $vatID The Value-added Tax ID of the organisation or person.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $vatID;
}
