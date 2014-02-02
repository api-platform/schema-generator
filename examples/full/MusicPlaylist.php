<?php

namespace SchemaOrg;

/**
 * Music Playlist
 *
 * @link http://schema.org/MusicPlaylist
 */
class MusicPlaylist extends CreativeWork
{
    /**
     * Num Tracks
     *
     * @var integer The number of tracks in this album or playlist.
     */
    protected $numTracks;
    /**
     * Track
     *
     * @var MusicRecording A music recording (track)—usually a single song.
     */
    protected $track;
}
