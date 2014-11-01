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
     */
    private $address;
    /**
     */
    private $aggregateRating;
    /**
     */
    private $brand;
    /**
     */
    private $contactPoint;
    /**
     */
    private $department;
    /**
     */
    private $duns;
    /**
     */
    private $email;
    /**
     */
    private $employee;
    /**
     */
    private $event;
    /**
     */
    private $faxNumber;
    /**
     */
    private $founder;
    /**
     */
    private $dissolutionDate;
    /**
     */
    private $foundingDate;
    /**
     */
    private $globalLocationNumber;
    /**
     */
    private $hasPOS;
    /**
     */
    private $interactionCount;
    /**
     */
    private $isicV4;
    /**
     */
    private $legalName;
    /**
     */
    private $location;
    /**
     */
    private $logo;
    /**
     */
    private $makesOffer;
    /**
     */
    private $member;
    /**
     */
    private $memberOf;
    /**
     */
    private $naics;
    /**
     */
    private $owns;
    /**
     */
    private $review;
    /**
     */
    private $seeks;
    /**
     */
    private $subOrganization;
    /**
     */
    private $taxID;
    /**
     */
    private $telephone;
    /**
     */
    private $vatID;
}
