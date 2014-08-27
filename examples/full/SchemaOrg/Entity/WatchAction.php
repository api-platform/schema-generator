<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of consuming dynamic/moving visual content.
 * 
 * @see http://schema.org/WatchAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WatchAction extends ConsumeAction
{
}
