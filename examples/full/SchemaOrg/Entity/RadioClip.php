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
     * @type Season $partOfSeason The season to which this episode belongs.
     * @ORM\ManyToOne(targetEntity="Season")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfSeason;
    /**
     * @type Series $partOfSeries The series to which this episode or season belongs.
     * @ORM\ManyToOne(targetEntity="Series")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfSeries;
}
