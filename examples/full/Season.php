<?php

namespace SchemaOrg;

/**
 * Season
 *
 * @link http://schema.org/Season
 */
class Season extends CreativeWork
{
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
     * Number of Episodes
     *
     * @var float The number of episodes in this season or series.
     */
    protected $numberOfEpisodes;
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
     * Season Number
     *
     * @var integer Position of the season within an ordered group of seasons.
     */
    protected $seasonNumber;
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
