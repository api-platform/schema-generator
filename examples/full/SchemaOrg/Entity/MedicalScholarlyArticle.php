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
     * @type string $publicationType The type of the medical article, taken from the US NLM MeSH <a href=http://www.nlm.nih.gov/mesh/pubtypes.html>publication type catalog.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $publicationType;
}
