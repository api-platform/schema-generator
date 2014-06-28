<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Test Panel
 * 
 * @link http://schema.org/MedicalTestPanel
 * 
 * @ORM\Entity
 */
class MedicalTestPanel extends MedicalTest
{
    /**
     * Sub Test
     * 
     * @var MedicalTest $subTest A component test of the panel.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalTest")
     */
    private $subTest;
}
