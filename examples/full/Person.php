<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 * 
 * @link http://schema.org/Person
 * 
 * @ORM\Entity
 */
class Person extends Thing
{
    /**
     * Additional Name
     * 
     * @var string $additionalName An additional name for a Person, can be used for a middle name.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $additionalName;
    /**
     * Address
     * 
     * @var PostalAddress $address Physical address of the item.
     * 
     */
    private $address;
    /**
     * Affiliation
     * 
     * @var Organization $affiliation An organization that this person is affiliated with. For example, a school/university, a club, or a team.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $affiliation;
    /**
     * Alumni of
     * 
     * @var EducationalOrganization $alumniOf An educational organizations that the person is an alumni of.
     * 
     * @ORM\ManyToOne(targetEntity="EducationalOrganization")
     */
    private $alumniOf;
    /**
     * Award
     * 
     * @var string $award An award won by this person or for this creative work.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $award;
    /**
     * Birth Date
     * 
     * @var \DateTime $birthDate Date of birth.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $birthDate;
    /**
     * Brand
     * 
     * @var Organization $brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $brand;
    /**
     * Children
     * 
     * @var Person $children A child of the person.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $children;
    /**
     * Colleague
     * 
     * @var Person $colleague A colleague of the person.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $colleague;
    /**
     * Contact Point
     * 
     * @var ContactPoint $contactPoint A contact point for a person or organization.
     * 
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     */
    private $contactPoint;
    /**
     * Death Date
     * 
     * @var \DateTime $deathDate Date of death.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $deathDate;
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
     * Family Name
     * 
     * @var string $familyName Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the Name property.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $familyName;
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
     * Follows
     * 
     * @var Person $follows The most generic uni-directional social relation.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $follows;
    /**
     * Gender
     * 
     * @var string $gender Gender of the person.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gender;
    /**
     * Given Name
     * 
     * @var string $givenName Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the Name property.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $givenName;
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
     * Home Location
     * 
     * @var ContactPoint $homeLocation A contact location for a person's residence.
     * 
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     */
    private $homeLocation;
    /**
     * Honorific Prefix
     * 
     * @var string $honorificPrefix An honorific prefix preceding a Person's name such as Dr/Mrs/Mr.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $honorificPrefix;
    /**
     * Honorific Suffix
     * 
     * @var string $honorificSuffix An honorific suffix preceding a Person's name such as M.D. /PhD/MSCSW.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $honorificSuffix;
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
     * Job Title
     * 
     * @var string $jobTitle The job title of the person (for example, Financial Manager).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $jobTitle;
    /**
     * Knows
     * 
     * @var Person $knows The most generic bi-directional social/work relation.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $knows;
    /**
     * Makes Offer
     * 
     * @var Offer $makesOffer A pointer to products or services offered by the organization or person.
     * 
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $makesOffer;
    /**
     * Member of
     * 
     * @var Organization $memberOf An organization to which the person belongs.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $memberOf;
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
     * Nationality
     * 
     * @var Country $nationality Nationality of the person.
     * 
     */
    private $nationality;
    /**
     * Owns
     * 
     * @var OwnershipInfo $owns Products owned by the organization or person.
     * 
     * @ORM\ManyToOne(targetEntity="OwnershipInfo")
     */
    private $owns;
    /**
     * Parent
     * 
     * @var Person $parent A parent of this person.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $parent;
    /**
     * Performer in
     * 
     * @var Event $performerIn Event that this person is a performer or participant in.
     * 
     */
    private $performerIn;
    /**
     * Related to
     * 
     * @var Person $relatedTo The most generic familial relation.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $relatedTo;
    /**
     * Seeks
     * 
     * @var Demand $seeks A pointer to products or services sought by the organization or person (demand).
     * 
     * @ORM\ManyToOne(targetEntity="Demand")
     */
    private $seeks;
    /**
     * Sibling
     * 
     * @var Person $sibling A sibling of the person.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $sibling;
    /**
     * Spouse
     * 
     * @var Person $spouse The person's spouse.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spouse;
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
    /**
     * Work Location
     * 
     * @var ContactPoint $workLocation A contact location for a person's place of work.
     * 
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     */
    private $workLocation;
    /**
     * Works for
     * 
     * @var Organization $worksFor Organizations that the person works for.
     * 
     */
    private $worksFor;
}
