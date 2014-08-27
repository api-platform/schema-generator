<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web page type: Collection page.
 * 
 * @see http://schema.org/CollectionPage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CollectionPage extends WebPage
{
}
