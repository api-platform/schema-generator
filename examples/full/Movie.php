<?php

namespace SchemaOrg;

/**
 * Movie
 *
 * @link http://schema.org/Movie
 */
class Movie extends CreativeWork
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
     * Duration
     *
     * @var Duration The duration of the item (movie, audio recording, event, etc.) in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 date format</a>.
     */
    protected $duration;
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
     * Trailer
     *
     * @var VideoObject The trailer of a movie or tv/radio series, season, or episode.
     */
    protected $trailer;
}
