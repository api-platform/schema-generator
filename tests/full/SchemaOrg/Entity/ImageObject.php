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
     */
    private $caption;
    /**
     */
    private $exifData;
    /**
     */
    private $representativeOfPage;
    /**
     */
    private $thumbnail;
}
