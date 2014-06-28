<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vessel
 * 
 * @link http://schema.org/Vessel
 * 
 * @ORM\MappedSuperclass
 */
class Vessel extends AnatomicalStructure
{
}
