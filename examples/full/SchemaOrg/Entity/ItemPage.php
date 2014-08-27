<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A page devoted to a single item, such as a particular product or hotel.
 * 
 * @see http://schema.org/ItemPage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ItemPage extends WebPage
{
}
