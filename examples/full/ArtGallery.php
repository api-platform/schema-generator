<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Art Gallery
 * 
 * @link http://schema.org/ArtGallery
 * 
 * @ORM\Entity
 */
class ArtGallery extends EntertainmentBusiness
{
}
