<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web page type: Image gallery page.
 * 
 * @see http://schema.org/ImageGallery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ImageGallery extends CollectionPage
{
}
