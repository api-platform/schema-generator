<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An organization such as a school, NGO, corporation, club, etc.
 * 
 * @see http://schema.org/Organization Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Organization extends Thing
{
    /**
     * @type PostalAddress $address Physical address of the item.
     */
    private $address;
    /**
     * @type AggregateRating $aggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     * @ORM\ManyToOne(targetEntity="AggregateRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregateRating;
    /**
     * @type Brand $brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     * @ORM\ManyToOne(targetEntity="Brand")
     */
    private $brand;
    /**
     * @type ContactPoint $contactPoint A contact point for a person or organization.
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     */
    private $contactPoint;
    /**
     * @type Organization $department A relationship between an organization and a department of that organization, also described as an organization (allowing different urls, logos, opening hours). For example: a store with a pharmacy, or a bakery with a cafe.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $department;
    /**
     * @type string $duns The Dun & Bradstreet DUNS number for identifying an organization or business person.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $duns;
    /**
     * @type string $email Email address.
     * @Assert\Email
     * @ORM\Column
     */
    private $email;
    /**
     * @type Person $employee Someone working for this organization.
     */
    private $employee;
    /**
     * @type Event $event Upcoming or past event associated with this place or organization.
     */
    private $event;
    /**
     * @type string $faxNumber The fax number.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $faxNumber;
    /**
     * @type Person $founder A person who founded this organization.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $founder;
    /**
     * @type \DateTime $dissolutionDate The date that this organization was dissolved.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $dissolutionDate;
    /**
     * @type \DateTime $foundingDate The date that this organization was founded.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $foundingDate;
    /**
     * @type string $globalLocationNumber The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $globalLocationNumber;
    /**
     * @type Place $hasPOS Points-of-Sales operated by the organization or person.
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $hasPOS;
    /**
     * @type string $interactionCount A count of a specific user interactions with this item&#x2014;for example, <code>20 UserLikes</code>, <code>5 UserComments</code>, or <code>300 UserDownloads</code>. The user interaction type should be one of the sub types of <a href='UserInteraction'>UserInteraction</a>.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $interactionCount;
    /**
     * @type string $isicV4 The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $isicV4;
    /**
     * @type string $legalName The official name of the organization, e.g. the registered company name.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $legalName;
    /**
     * @type Place $location The location of the event, organization or action.
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;
    /**
     * @type ImageObject $logo A logo associated with an organization.
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $logo;
    /**
     * @type Offer $makesOffer A pointer to products or services offered by the organization or person.
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $makesOffer;
    /**
     * @type Organization $member A member of an Organization or a ProgramMembership. Organizations can be members of organizations; ProgramMembership is typically for individuals.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $member;
    /**
     * @type Organization $memberOf An Organization (or ProgramMembership) to which this Person or Organization belongs.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $memberOf;
    /**
     * @type string $naics The North American Industry Classification System (NAICS) code for a particular organization or business person.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $naics;
    /**
     * @type OwnershipInfo $owns Products owned by the organization or person.
     * @ORM\ManyToOne(targetEntity="OwnershipInfo")
     */
    private $owns;
    /**
     * @type Review $review A review of the item.
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $review;
    /**
     * @type Demand $seeks A pointer to products or services sought by the organization or person (demand).
     * @ORM\ManyToOne(targetEntity="Demand")
     */
    private $seeks;
    /**
     * @type Organization $subOrganization A relationship between two organizations where the first includes the second, e.g., as a subsidiary. See also: the more specific 'department' property.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $subOrganization;
    /**
     * @type string $taxID The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $taxID;
    /**
     * @type string $telephone The telephone number.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $telephone;
    /**
     * @type string $vatID The Value-added Tax ID of the organization or person.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $vatID;
}
