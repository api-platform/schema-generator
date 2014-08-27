<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A short TV or radio program or a segment/part of a program.
 * 
 * @see http://schema.org/Clip Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Clip extends CreativeWork
{
    /**
     * @type integer $clipNumber Position of the clip within an ordered group of clips.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $clipNumber;
    /**
     * @type Episode $partOfEpisode The episode to which this clip belongs.
     * @ORM\ManyToOne(targetEntity="Episode")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfEpisode;
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
     * @type PublicationEvent $publication A publication event associated with the episode, clip or media object.
     * @ORM\ManyToOne(targetEntity="PublicationEvent")
     */
    private $publication;
}
