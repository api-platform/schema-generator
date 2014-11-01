<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A listing that describes a job opening in a certain organization.
 * 
 * @see http://schema.org/JobPosting Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class JobPosting extends Intangible
{
    /**
     */
    private $baseSalary;
    /**
     */
    private $benefits;
    /**
     */
    private $datePosted;
    /**
     */
    private $educationRequirements;
    /**
     */
    private $employmentType;
    /**
     */
    private $experienceRequirements;
    /**
     */
    private $hiringOrganization;
    /**
     */
    private $incentives;
    /**
     */
    private $industry;
    /**
     */
    private $jobLocation;
    /**
     */
    private $occupationalCategory;
    /**
     */
    private $qualifications;
    /**
     */
    private $responsibilities;
    /**
     */
    private $salaryCurrency;
    /**
     */
    private $skills;
    /**
     */
    private $specialCommitments;
    /**
     */
    private $title;
    /**
     */
    private $workHours;
}
