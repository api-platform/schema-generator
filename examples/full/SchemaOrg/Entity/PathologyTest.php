<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A medical test performed by a laboratory that typically involves examination of a tissue sample by a pathologist.
 * 
 * @see http://schema.org/PathologyTest Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PathologyTest extends MedicalTest
{
    /**
     * @type string $tissueSample The type of tissue sample required for the test.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $tissueSample;
}
