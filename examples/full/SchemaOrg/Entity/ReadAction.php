<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of consuming written content.
 * 
 * @see http://schema.org/ReadAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReadAction extends ConsumeAction
{
}
