<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A component of the human body circulatory system comprised of an intricate network of hollow tubes that transport blood throughout the entire body.
 * 
 * @see http://schema.org/Vessel Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Vessel extends AnatomicalStructure
{
}
