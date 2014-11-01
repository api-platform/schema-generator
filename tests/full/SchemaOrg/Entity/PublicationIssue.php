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
     */
    private $issueNumber;
    /**
     */
    private $pageEnd;
    /**
     */
    private $pageStart;
    /**
     */
    private $pagination;
}
