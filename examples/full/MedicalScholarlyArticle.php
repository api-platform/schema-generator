<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Scholarly Article
 * 
 * @link http://schema.org/MedicalScholarlyArticle
 * 
 * @ORM\Entity
 */
class MedicalScholarlyArticle extends ScholarlyArticle
{
    /**
     * Publication Type
     * 
     * @var string $publicationType The type of the medical article, taken from the US NLM MeSH publication type catalog.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $publicationType;
}
