<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An art gallery.
 * 
 * @see http://schema.org/ArtGallery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ArtGallery extends EntertainmentBusiness
{
}
