<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pathology Test
 * 
 * @link http://schema.org/PathologyTest
 * 
 * @ORM\Entity
 */
class PathologyTest extends MedicalTest
{
    /**
     * Tissue Sample
     * 
     * @var string $tissueSample The type of tissue sample required for the test.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $tissueSample;
}
