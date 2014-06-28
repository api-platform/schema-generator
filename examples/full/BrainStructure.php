<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brain Structure
 * 
 * @link http://schema.org/BrainStructure
 * 
 * @ORM\Entity
 */
class BrainStructure extends AnatomicalStructure
{
}
