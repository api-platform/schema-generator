<?php

namespace SchemaOrg;

/**
 * Video Object
 *
 * @link http://schema.org/VideoObject
 */
class VideoObject extends MediaObject
{
    /**
     * Caption
     *
     * @var string The caption for this object.
     */
    protected $caption;
    /**
     * Thumbnail
     *
     * @var ImageObject Thumbnail image for an image or video.
     */
    protected $thumbnail;
    /**
     * Transcript
     *
     * @var string If this MediaObject is an AudioObject or VideoObject, the transcript of that object.
     */
    protected $transcript;
    /**
     * Video Frame Size
     *
     * @var string The frame size of the video.
     */
    protected $videoFrameSize;
    /**
     * Video Quality
     *
     * @var string The quality of the video.
     */
    protected $videoQuality;
}
