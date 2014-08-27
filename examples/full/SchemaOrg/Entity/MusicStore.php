<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A music store.
 * 
 * @see http://schema.org/MusicStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MusicStore extends Store
{
}
