<?php

namespace SchemaOrg;

/**
 * Image Object
 *
 * @link http://schema.org/ImageObject
 */
class ImageObject extends MediaObject
{
    /**
     * Caption
     *
     * @var string The caption for this object.
     */
    protected $caption;
    /**
     * Exif Data
     *
     * @var string exif data for this object.
     */
    protected $exifData;
    /**
     * Representative of Page
     *
     * @var boolean Indicates whether this image is representative of the content of the page.
     */
    protected $representativeOfPage;
    /**
     * Thumbnail
     *
     * @var ImageObject Thumbnail image for an image or video.
     */
    protected $thumbnail;
}
