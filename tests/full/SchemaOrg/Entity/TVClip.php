<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A short TV program or a segment/part of a TV program.
 * 
 * @see http://schema.org/TVClip Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TVClip extends Clip
{
    /**
     */
    private $partOfSeason;
    /**
     */
    private $partOfSeries;
    /**
     */
    private $partOfTVSeries;
}
