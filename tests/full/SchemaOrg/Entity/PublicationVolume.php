<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A part of a successively published publication such as a periodical or multi-volume work, often numbered. It may represent a time span, such as a year.
 * 
 * @see http://schema.org/PublicationVolume Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PublicationVolume extends CreativeWork
{
    /**
     */
    private $pageEnd;
    /**
     */
    private $pageStart;
    /**
     */
    private $pagination;
    /**
     */
    private $volumeNumber;
}
