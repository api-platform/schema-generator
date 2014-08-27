<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A news article
 * 
 * @see http://schema.org/NewsArticle Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class NewsArticle extends Article
{
    /**
     * @type string $dateline The location where the NewsArticle was produced.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $dateline;
    /**
     * @type string $printColumn The number of the column in which the NewsArticle appears in the print edition.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $printColumn;
    /**
     * @type string $printEdition The edition of the print product in which the NewsArticle appears.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $printEdition;
    /**
     * @type string $printPage If this NewsArticle appears in print, this field indicates the name of the page on which the article is found. Please note that this field is intended for the exact page name (e.g. A5, B18).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $printPage;
    /**
     * @type string $printSection If this NewsArticle appears in print, this field indicates the print section in which the article appeared.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $printSection;
}
