<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An alternative, closely-related condition typically considered later in the differential diagnosis process along with the signs that are used to distinguish it.
 * 
 * @see http://schema.org/DDxElement Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DDxElement extends MedicalIntangible
{
    /**
     * @type MedicalCondition $diagnosis One or more alternative conditions considered in the differential diagnosis process.
     * @ORM\ManyToOne(targetEntity="MedicalCondition")
     */
    private $diagnosis;
    /**
     * @type MedicalSignOrSymptom $distinguishingSign One of a set of signs and symptoms that can be used to distinguish this diagnosis from others in the differential diagnosis.
     */
    private $distinguishingSign;
}
