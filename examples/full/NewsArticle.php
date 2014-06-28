<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * News Article
 * 
 * @link http://schema.org/NewsArticle
 * 
 * @ORM\Entity
 */
class NewsArticle extends Article
{
    /**
     * Dateline
     * 
     * @var string $dateline The location where the NewsArticle was produced.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $dateline;
    /**
     * Print Column
     * 
     * @var string $printColumn The number of the column in which the NewsArticle appears in the print edition.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $printColumn;
    /**
     * Print Edition
     * 
     * @var string $printEdition The edition of the print product in which the NewsArticle appears.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $printEdition;
    /**
     * Print Page
     * 
     * @var string $printPage If this NewsArticle appears in print, this field indicates the name of the page on which the article is found. Please note that this field is intended for the exact page name (e.g. A5, B18).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $printPage;
    /**
     * Print Section
     * 
     * @var string $printSection If this NewsArticle appears in print, this field indicates the print section in which the article appeared.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $printSection;
}
