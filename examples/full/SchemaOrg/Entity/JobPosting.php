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
     * @type float $baseSalary The base salary of the job.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $baseSalary;
    /**
     * @type string $benefits Description of benefits associated with the job.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $benefits;
    /**
     * @type \DateTime $datePosted Publication date for the job posting.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $datePosted;
    /**
     * @type string $educationRequirements Educational background needed for the position.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $educationRequirements;
    /**
     * @type string $employmentType Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $employmentType;
    /**
     * @type string $experienceRequirements Description of skills and experience needed for the position.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $experienceRequirements;
    /**
     * @type Organization $hiringOrganization Organization offering the job position.
     */
    private $hiringOrganization;
    /**
     * @type string $incentives Description of bonus and commission compensation aspects of the job.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $incentives;
    /**
     * @type string $industry The industry associated with the job position.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $industry;
    /**
     * @type Place $jobLocation A (typically single) geographic location associated with the job position.
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $jobLocation;
    /**
     * @type string $occupationalCategory Category or categories describing the job. Use BLS O*NET-SOC taxonomy: http://www.onetcenter.org/taxonomy.html. Ideally includes textual label and formal code, with the property repeated for each applicable value.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $occupationalCategory;
    /**
     * @type string $qualifications Specific qualifications required for this role.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $qualifications;
    /**
     * @type string $responsibilities Responsibilities associated with this role.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $responsibilities;
    /**
     * @type string $salaryCurrency The currency (coded using ISO 4217, http://en.wikipedia.org/wiki/ISO_4217 used for the main salary information in this job posting.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $salaryCurrency;
    /**
     * @type string $skills Skills required to fulfill this role.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $skills;
    /**
     * @type string $specialCommitments Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $specialCommitments;
    /**
     * @type string $title The title of the job.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $title;
    /**
     * @type string $workHours The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $workHours;
}
