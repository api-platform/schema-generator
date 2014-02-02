<?php

namespace SchemaOrg;

/**
 * Music Recording
 *
 * @link http://schema.org/MusicRecording
 */
class MusicRecording extends CreativeWork
{
    /**
     * By Artist
     *
     * @var MusicGroup The artist that performed this album or recording.
     */
    protected $byArtist;
    /**
     * Duration
     *
     * @var Duration The duration of the item (movie, audio recording, event, etc.) in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 date format</a>.
     */
    protected $duration;
    /**
     * In Album
     *
     * @var MusicAlbum The album to which this recording belongs.
     */
    protected $inAlbum;
    /**
     * In Playlist
     *
     * @var MusicPlaylist The playlist to which this recording belongs.
     */
    protected $inPlaylist;
}
