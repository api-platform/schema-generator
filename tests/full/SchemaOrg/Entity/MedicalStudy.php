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
     */
    private $outcome;
    /**
     */
    private $population;
    /**
     */
    private $sponsor;
    /**
     */
    private $status;
    /**
     */
    private $studyLocation;
    /**
     */
    private $studySubject;
}
