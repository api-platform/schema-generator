<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Collection Page
 * 
 * @link http://schema.org/CollectionPage
 * 
 * @ORM\MappedSuperclass
 */
class CollectionPage extends WebPage
{
}
