<?php

namespace SchemaOrg;

/**
 * Job Posting
 *
 * @link http://schema.org/JobPosting
 */
class JobPosting extends Intangible
{
    /**
     * Base Salary
     *
     * @var float The base salary of the job.
     */
    protected $baseSalary;
    /**
     * Benefits
     *
     * @var string Description of benefits associated with the job.
     */
    protected $benefits;
    /**
     * Date Posted
     *
     * @var \DateTime Publication date for the job posting.
     */
    protected $datePosted;
    /**
     * Education Requirements
     *
     * @var string Educational background needed for the position.
     */
    protected $educationRequirements;
    /**
     * Employment Type
     *
     * @var string Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship).
     */
    protected $employmentType;
    /**
     * Experience Requirements
     *
     * @var string Description of skills and experience needed for the position.
     */
    protected $experienceRequirements;
    /**
     * Hiring Organization
     *
     * @var Organization Organization offering the job position.
     */
    protected $hiringOrganization;
    /**
     * Incentives
     *
     * @var string Description of bonus and commission compensation aspects of the job.
     */
    protected $incentives;
    /**
     * Industry
     *
     * @var string The industry associated with the job position.
     */
    protected $industry;
    /**
     * Job Location
     *
     * @var Place A (typically single) geographic location associated with the job position.
     */
    protected $jobLocation;
    /**
     * Occupational Category
     *
     * @var string Category or categories describing the job. Use BLS O*NET-SOC taxonomy: http://www.onetcenter.org/taxonomy.html. Ideally includes textual label and formal code, with the property repeated for each applicable value.
     */
    protected $occupationalCategory;
    /**
     * Qualifications
     *
     * @var string Specific qualifications required for this role.
     */
    protected $qualifications;
    /**
     * Responsibilities
     *
     * @var string Responsibilities associated with this role.
     */
    protected $responsibilities;
    /**
     * Salary Currency
     *
     * @var string The currency (coded using ISO 4217, http://en.wikipedia.org/wiki/ISO_4217 used for the main salary information in this job posting.
     */
    protected $salaryCurrency;
    /**
     * Skills
     *
     * @var string Skills required to fulfill this role.
     */
    protected $skills;
    /**
     * Special Commitments
     *
     * @var string Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.
     */
    protected $specialCommitments;
    /**
     * Title
     *
     * @var string The title of the job.
     */
    protected $title;
    /**
     * Work Hours
     *
     * @var string The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm).
     */
    protected $workHours;
}
