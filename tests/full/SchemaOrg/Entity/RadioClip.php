<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A short radio program or a segment/part of a radio program.
 * 
 * @see http://schema.org/RadioClip Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RadioClip extends Clip
{
    /**
     */
    private $partOfSeason;
    /**
     */
    private $partOfSeries;
}
