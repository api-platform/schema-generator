<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An image file.
 * 
 * @see http://schema.org/ImageObject Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ImageObject extends MediaObject
{
    /**
     * @type string $caption The caption for this object.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $caption;
    /**
     * @type string $exifData exif data for this object.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $exifData;
    /**
     * @type boolean $representativeOfPage Indicates whether this image is representative of the content of the page.
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $representativeOfPage;
    /**
     * @type ImageObject $thumbnail Thumbnail image for an image or video.
     */
    private $thumbnail;
}
