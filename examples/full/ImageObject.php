<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Image Object
 * 
 * @link http://schema.org/ImageObject
 * 
 * @ORM\Entity
 */
class ImageObject extends MediaObject
{
    /**
     * Caption
     * 
     * @var string $caption The caption for this object.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $caption;
    /**
     * Exif Data
     * 
     * @var string $exifData exif data for this object.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $exifData;
    /**
     * Representative of Page
     * 
     * @var boolean $representativeOfPage Indicates whether this image is representative of the content of the page.
     * 
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $representativeOfPage;
    /**
     * Thumbnail
     * 
     * @var ImageObject $thumbnail Thumbnail image for an image or video.
     * 
     */
    private $thumbnail;
}
