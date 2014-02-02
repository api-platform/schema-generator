<?php

namespace SchemaOrg;

/**
 * Episode
 *
 * @link http://schema.org/Episode
 */
class Episode extends CreativeWork
{
    /**
     * Actor
     *
     * @var Person A cast member of the movie, tv/radio series, season, episode, or video.
     */
    protected $actor;
    /**
     * Director
     *
     * @var Person The director of the movie, tv/radio episode or series.
     */
    protected $director;
    /**
     * Episode Number
     *
     * @var integer Position of the episode within an ordered group of episodes.
     */
    protected $episodeNumber;
    /**
     * Music by (Person)
     *
     * @var Person The composer of the movie or TV/radio soundtrack.
     */
    protected $musicByPerson;
    /**
     * Music by (MusicGroup)
     *
     * @var MusicGroup The composer of the movie or TV/radio soundtrack.
     */
    protected $musicByMusicGroup;
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
     * Producer
     *
     * @var Person The producer of the movie, tv/radio series, season, or episode, or video.
     */
    protected $producer;
    /**
     * Production Company
     *
     * @var Organization The production company or studio that made the movie, tv/radio series, season, or episode, or media object.
     */
    protected $productionCompany;
    /**
     * Publication
     *
     * @var PublicationEvent A publication event associated with the episode, clip or media object.
     */
    protected $publication;
    /**
     * Trailer
     *
     * @var VideoObject The trailer of a movie or tv/radio series, season, or episode.
     */
    protected $trailer;
}
