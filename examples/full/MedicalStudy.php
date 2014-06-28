<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Study
 * 
 * @link http://schema.org/MedicalStudy
 * 
 * @ORM\MappedSuperclass
 */
class MedicalStudy extends MedicalEntity
{
    /**
     * Outcome
     * 
     * @var string $outcome Expected or actual outcomes of the study.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $outcome;
    /**
     * Population
     * 
     * @var string $population Any characteristics of the population used in the study, e.g. 'males under 65'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $population;
    /**
     * Sponsor
     * 
     * @var Organization $sponsor Sponsor of the study.
     * 
     */
    private $sponsor;
    /**
     * Status
     * 
     * @var MedicalStudyStatus $status The status of the study (enumerated).
     * 
     * @ORM\ManyToOne(targetEntity="MedicalStudyStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;
    /**
     * Study Location
     * 
     * @var AdministrativeArea $studyLocation The location in which the study is taking/took place.
     * 
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $studyLocation;
    /**
     * Study Subject
     * 
     * @var MedicalEntity $studySubject A subject of the study, i.e. one of the medical conditions, therapies, devices, drugs, etc. investigated by the study.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     */
    private $studySubject;
}
