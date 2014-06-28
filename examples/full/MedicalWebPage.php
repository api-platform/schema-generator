<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Web Page
 * 
 * @link http://schema.org/MedicalWebPage
 * 
 * @ORM\Entity
 */
class MedicalWebPage extends WebPage
{
    /**
     * Aspect
     * 
     * @var string $aspect An aspect of medical practice that is considered on the page, such as 'diagnosis', 'treatment', 'causes', 'prognosis', 'etiology', 'epidemiology', etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $aspect;
}
