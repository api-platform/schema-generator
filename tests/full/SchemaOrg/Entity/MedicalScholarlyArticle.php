<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A scholarly article in the medical domain.
 * 
 * @see http://schema.org/MedicalScholarlyArticle Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalScholarlyArticle extends ScholarlyArticle
{
    /**
     */
    private $publicationType;
}
