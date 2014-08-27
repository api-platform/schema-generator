<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A part of a successively published publication such as a periodical or publication volume, often numbered, usually containing a grouping of works such as articles.
 * 
 * @see http://schema.org/PublicationIssue Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PublicationIssue extends CreativeWork
{
    /**
     * @type integer $issueNumber Identifies the issue of publication; for example, "iii" or "2".
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $issueNumber;
    /**
     * @type integer $pageEnd The page on which the work ends; for example "138" or "xvi".
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $pageEnd;
    /**
     * @type integer $pageStart The page on which the work starts; for example "135" or "xiii".
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $pageStart;
    /**
     * @type string $pagination Any description of pages that is not separated into pageStart and pageEnd; for example, "1-6, 9, 55" or "10-12, 46-49".
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $pagination;
}
