<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A movie rental store.
 * 
 * @see http://schema.org/MovieRentalStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MovieRentalStore extends Store
{
}
