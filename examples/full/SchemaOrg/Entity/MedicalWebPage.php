<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A web page that provides medical information.
 * 
 * @see http://schema.org/MedicalWebPage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalWebPage extends WebPage
{
    /**
     * @type string $aspect An aspect of medical practice that is considered on the page, such as 'diagnosis', 'treatment', 'causes', 'prognosis', 'etiology', 'epidemiology', etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $aspect;
}
