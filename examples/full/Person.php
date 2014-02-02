<?php

namespace SchemaOrg;

/**
 * Person
 *
 * @link http://schema.org/Person
 */
class Person extends Thing
{
    /**
     * Additional Name
     *
     * @var string An additional name for a Person, can be used for a middle name.
     */
    protected $additionalName;
    /**
     * Address
     *
     * @var PostalAddress Physical address of the item.
     */
    protected $address;
    /**
     * Affiliation
     *
     * @var Organization An organization that this person is affiliated with. For example, a school/university, a club, or a team.
     */
    protected $affiliation;
    /**
     * Alumni of
     *
     * @var EducationalOrganization An educational organizations that the person is an alumni of.
     */
    protected $alumniOf;
    /**
     * Award
     *
     * @var string An award won by this person or for this creative work.
     */
    protected $award;
    /**
     * Birth Date
     *
     * @var \DateTime Date of birth.
     */
    protected $birthDate;
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
     * Children
     *
     * @var Person A child of the person.
     */
    protected $children;
    /**
     * Colleague
     *
     * @var Person A colleague of the person.
     */
    protected $colleague;
    /**
     * Contact Point
     *
     * @var ContactPoint A contact point for a person or organization.
     */
    protected $contactPoint;
    /**
     * Death Date
     *
     * @var \DateTime Date of death.
     */
    protected $deathDate;
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
     * Family Name
     *
     * @var string Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the Name property.
     */
    protected $familyName;
    /**
     * Fax Number
     *
     * @var string The fax number.
     */
    protected $faxNumber;
    /**
     * Follows
     *
     * @var Person The most generic uni-directional social relation.
     */
    protected $follows;
    /**
     * Gender
     *
     * @var string Gender of the person.
     */
    protected $gender;
    /**
     * Given Name
     *
     * @var string Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the Name property.
     */
    protected $givenName;
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
     * Home Location (ContactPoint)
     *
     * @var ContactPoint A contact location for a person's residence.
     */
    protected $homeLocationContactPoint;
    /**
     * Home Location (Place)
     *
     * @var Place A contact location for a person's residence.
     */
    protected $homeLocationPlace;
    /**
     * Honorific Prefix
     *
     * @var string An honorific prefix preceding a Person's name such as Dr/Mrs/Mr.
     */
    protected $honorificPrefix;
    /**
     * Honorific Suffix
     *
     * @var string An honorific suffix preceding a Person's name such as M.D. /PhD/MSCSW.
     */
    protected $honorificSuffix;
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
     * Job Title
     *
     * @var string The job title of the person (for example, Financial Manager).
     */
    protected $jobTitle;
    /**
     * Knows
     *
     * @var Person The most generic bi-directional social/work relation.
     */
    protected $knows;
    /**
     * Makes Offer
     *
     * @var Offer A pointer to products or services offered by the organization or person.
     */
    protected $makesOffer;
    /**
     * Member of
     *
     * @var Organization An organization to which the person belongs.
     */
    protected $memberOf;
    /**
     * Naics
     *
     * @var string The North American Industry Classification System (NAICS) code for a particular organization or business person.
     */
    protected $naics;
    /**
     * Nationality
     *
     * @var Country Nationality of the person.
     */
    protected $nationality;
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
     * Parent
     *
     * @var Person A parent of this person.
     */
    protected $parent;
    /**
     * Performer in
     *
     * @var Event Event that this person is a performer or participant in.
     */
    protected $performerIn;
    /**
     * Related to
     *
     * @var Person The most generic familial relation.
     */
    protected $relatedTo;
    /**
     * Seeks
     *
     * @var Demand A pointer to products or services sought by the organization or person (demand).
     */
    protected $seeks;
    /**
     * Sibling
     *
     * @var Person A sibling of the person.
     */
    protected $sibling;
    /**
     * Spouse
     *
     * @var Person The person's spouse.
     */
    protected $spouse;
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
    /**
     * Work Location (ContactPoint)
     *
     * @var ContactPoint A contact location for a person's place of work.
     */
    protected $workLocationContactPoint;
    /**
     * Work Location (Place)
     *
     * @var Place A contact location for a person's place of work.
     */
    protected $workLocationPlace;
    /**
     * Works for
     *
     * @var Organization Organizations that the person works for.
     */
    protected $worksFor;
}
