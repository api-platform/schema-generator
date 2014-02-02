<?php

namespace SchemaOrg;

/**
 * Series
 *
 * @link http://schema.org/Series
 */
class Series extends CreativeWork
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
     * End Date
     *
     * @var \DateTime The end date and time of the event or item (in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 date format</a>).
     */
    protected $endDate;
    /**
     * Episode
     *
     * @var Episode An episode of a TV/radio series or season
     */
    protected $episode;
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
     * Number of Episodes
     *
     * @var float The number of episodes in this season or series.
     */
    protected $numberOfEpisodes;
    /**
     * Number of Seasons
     *
     * @var float The number of seasons in this series.
     */
    protected $numberOfSeasons;
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
     * Season
     *
     * @var Season A season in a tv/radio series.
     */
    protected $season;
    /**
     * Start Date
     *
     * @var \DateTime The start date and time of the event or item (in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 date format</a>).
     */
    protected $startDate;
    /**
     * Trailer
     *
     * @var VideoObject The trailer of a movie or tv/radio series, season, or episode.
     */
    protected $trailer;
}
