<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Job Posting
 * 
 * @link http://schema.org/JobPosting
 * 
 * @ORM\Entity
 */
class JobPosting extends Intangible
{
    /**
     * Base Salary
     * 
     * @var float $baseSalary The base salary of the job.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $baseSalary;
    /**
     * Benefits
     * 
     * @var string $benefits Description of benefits associated with the job.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $benefits;
    /**
     * Date Posted
     * 
     * @var \DateTime $datePosted Publication date for the job posting.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $datePosted;
    /**
     * Education Requirements
     * 
     * @var string $educationRequirements Educational background needed for the position.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $educationRequirements;
    /**
     * Employment Type
     * 
     * @var string $employmentType Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $employmentType;
    /**
     * Experience Requirements
     * 
     * @var string $experienceRequirements Description of skills and experience needed for the position.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $experienceRequirements;
    /**
     * Hiring Organization
     * 
     * @var Organization $hiringOrganization Organization offering the job position.
     * 
     */
    private $hiringOrganization;
    /**
     * Incentives
     * 
     * @var string $incentives Description of bonus and commission compensation aspects of the job.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $incentives;
    /**
     * Industry
     * 
     * @var string $industry The industry associated with the job position.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $industry;
    /**
     * Job Location
     * 
     * @var Place $jobLocation A (typically single) geographic location associated with the job position.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $jobLocation;
    /**
     * Occupational Category
     * 
     * @var string $occupationalCategory Category or categories describing the job. Use BLS O*NET-SOC taxonomy: http://www.onetcenter.org/taxonomy.html. Ideally includes textual label and formal code, with the property repeated for each applicable value.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $occupationalCategory;
    /**
     * Qualifications
     * 
     * @var string $qualifications Specific qualifications required for this role.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $qualifications;
    /**
     * Responsibilities
     * 
     * @var string $responsibilities Responsibilities associated with this role.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $responsibilities;
    /**
     * Salary Currency
     * 
     * @var string $salaryCurrency The currency (coded using ISO 4217, http://en.wikipedia.org/wiki/ISO_4217 used for the main salary information in this job posting.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $salaryCurrency;
    /**
     * Skills
     * 
     * @var string $skills Skills required to fulfill this role.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $skills;
    /**
     * Special Commitments
     * 
     * @var string $specialCommitments Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $specialCommitments;
    /**
     * Title
     * 
     * @var string $title The title of the job.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $title;
    /**
     * Work Hours
     * 
     * @var string $workHours The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $workHours;
}
