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
    /**
     * @type TVSeries $partOfTVSeries The TV series to which this episode or season belongs. (legacy form; partOfSeries is preferred)
     * @ORM\ManyToOne(targetEntity="TVSeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfTVSeries;
}
