<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of consuming static visual content.
 * 
 * @see http://schema.org/ViewAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ViewAction extends ConsumeAction
{
}
