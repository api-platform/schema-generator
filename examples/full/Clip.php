<?php

namespace SchemaOrg;

/**
 * Clip
 *
 * @link http://schema.org/Clip
 */
class Clip extends CreativeWork
{
    /**
     * Clip Number
     *
     * @var integer Position of the clip within an ordered group of clips.
     */
    protected $clipNumber;
    /**
     * Part of Episode
     *
     * @var Episode The episode to which this clip belongs.
     */
    protected $partOfEpisode;
    /**
     * Part of Season
     *
     * @var Season The season to which this episode belongs.
     */
    protected $partOfSeason;
    /**
     * Part of Series
     *
     * @var Series The series to which this episode or season belongs.
     */
    protected $partOfSeries;
    /**
     * Position
     *
     * @var string Free text to define other than pure numerical ranking of an episode or a season in an ordered list of items (further formatting restrictions may apply within particular user groups).
     */
    protected $position;
    /**
     * Publication
     *
     * @var PublicationEvent A publication event associated with the episode, clip or media object.
     */
    protected $publication;
}
