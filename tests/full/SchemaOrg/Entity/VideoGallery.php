<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web page type: Video gallery page.
 * 
 * @see http://schema.org/VideoGallery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class VideoGallery extends CollectionPage
{
}
