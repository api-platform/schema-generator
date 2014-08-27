<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A bookstore.
 * 
 * @see http://schema.org/BookStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BookStore extends Store
{
}
