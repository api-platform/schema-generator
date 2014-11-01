<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An intangible item that describes an alignment between a learning resource and a node in an educational framework.
 * 
 * @see http://schema.org/AlignmentObject Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AlignmentObject extends Intangible
{
    /**
     */
    private $alignmentType;
    /**
     */
    private $educationalFramework;
    /**
     */
    private $targetDescription;
    /**
     */
    private $targetName;
    /**
     */
    private $targetUrl;
}
