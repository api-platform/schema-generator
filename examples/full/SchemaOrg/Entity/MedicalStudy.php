<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A medical study is an umbrella type covering all kinds of research studies relating to human medicine or health, including observational studies and interventional trials and registries, randomized, controlled or not. When the specific type of study is known, use one of the extensions of this type, such as MedicalTrial or MedicalObservationalStudy. Also, note that this type should be used to mark up data that describes the study itself; to tag an article that publishes the results of a study, use MedicalScholarlyArticle. Note: use the code property of MedicalEntity to store study IDs, e.g. clinicaltrials.gov ID.
 * 
 * @see http://schema.org/MedicalStudy Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalStudy extends MedicalEntity
{
    /**
     * @type string $outcome Expected or actual outcomes of the study.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $outcome;
    /**
     * @type string $population Any characteristics of the population used in the study, e.g. 'males under 65'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $population;
    /**
     * @type Organization $sponsor Sponsor of the study.
     */
    private $sponsor;
    /**
     * @type MedicalStudyStatus $status The status of the study (enumerated).
     * @ORM\ManyToOne(targetEntity="MedicalStudyStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;
    /**
     * @type AdministrativeArea $studyLocation The location in which the study is taking/took place.
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $studyLocation;
    /**
     * @type MedicalEntity $studySubject A subject of the study, i.e. one of the medical conditions, therapies, devices, drugs, etc. investigated by the study.
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     */
    private $studySubject;
}
