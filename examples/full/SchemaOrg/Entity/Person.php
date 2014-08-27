<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A person (alive, dead, undead, or fictional).
 * 
 * @see http://schema.org/Person Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Person extends Thing
{
    /**
     * @type string $additionalName An additional name for a Person, can be used for a middle name.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $additionalName;
    /**
     * @type PostalAddress $address Physical address of the item.
     */
    private $address;
    /**
     * @type Organization $affiliation An organization that this person is affiliated with. For example, a school/university, a club, or a team.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $affiliation;
    /**
     * @type EducationalOrganization $alumniOf An educational organizations that the person is an alumni of.
     * @ORM\ManyToOne(targetEntity="EducationalOrganization")
     */
    private $alumniOf;
    /**
     * @type string $award An award won by this person or for this creative work.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $award;
    /**
     * @type \DateTime $birthDate Date of birth.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $birthDate;
    /**
     * @type Brand $brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     * @ORM\ManyToOne(targetEntity="Brand")
     */
    private $brand;
    /**
     * @type Person $children A child of the person.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $children;
    /**
     * @type Person $colleague A colleague of the person.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $colleague;
    /**
     * @type ContactPoint $contactPoint A contact point for a person or organization.
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     */
    private $contactPoint;
    /**
     * @type \DateTime $deathDate Date of death.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $deathDate;
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
     * @type string $familyName Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the Name property.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $familyName;
    /**
     * @type string $faxNumber The fax number.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $faxNumber;
    /**
     * @type Person $follows The most generic uni-directional social relation.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $follows;
    /**
     * @type string $gender Gender of the person.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gender;
    /**
     * @type string $givenName Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the Name property.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $givenName;
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
     * @type ContactPoint $homeLocation A contact location for a person's residence.
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     */
    private $homeLocation;
    /**
     * @type string $honorificPrefix An honorific prefix preceding a Person's name such as Dr/Mrs/Mr.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $honorificPrefix;
    /**
     * @type string $honorificSuffix An honorific suffix preceding a Person's name such as M.D. /PhD/MSCSW.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $honorificSuffix;
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
     * @type string $jobTitle The job title of the person (for example, Financial Manager).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $jobTitle;
    /**
     * @type Person $knows The most generic bi-directional social/work relation.
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $knows;
    /**
     * @type Offer $makesOffer A pointer to products or services offered by the organization or person.
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $makesOffer;
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
     * @type Country $nationality Nationality of the person.
     */
    private $nationality;
    /**
     * @type OwnershipInfo $owns Products owned by the organization or person.
     * @ORM\ManyToOne(targetEntity="OwnershipInfo")
     */
    private $owns;
    /**
     * @type Person $parent A parent of this person.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $parent;
    /**
     * @type Event $performerIn Event that this person is a performer or participant in.
     */
    private $performerIn;
    /**
     * @type Person $relatedTo The most generic familial relation.
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $relatedTo;
    /**
     * @type Demand $seeks A pointer to products or services sought by the organization or person (demand).
     * @ORM\ManyToOne(targetEntity="Demand")
     */
    private $seeks;
    /**
     * @type Person $sibling A sibling of the person.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $sibling;
    /**
     * @type Person $spouse The person's spouse.
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spouse;
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
    /**
     * @type ContactPoint $workLocation A contact location for a person's place of work.
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     */
    private $workLocation;
    /**
     * @type Organization $worksFor Organizations that the person works for.
     */
    private $worksFor;
}
