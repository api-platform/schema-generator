<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Intended audience for an item, i.e. the group for whom the item was created.
 * 
 * @see http://schema.org/Audience Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Audience extends Intangible
{
    /**
     */
    private $audienceType;
    /**
     */
    private $geographicArea;
}
