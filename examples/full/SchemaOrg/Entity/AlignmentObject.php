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
     * @type string $alignmentType A category of alignment between the learning resource and the framework node. Recommended values include: 'assesses', 'teaches', 'requires', 'textComplexity', 'readingLevel', 'educationalSubject', and 'educationLevel'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $alignmentType;
    /**
     * @type string $educationalFramework The framework to which the resource being described is aligned.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $educationalFramework;
    /**
     * @type string $targetDescription The description of a node in an established educational framework.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetDescription;
    /**
     * @type string $targetName The name of a node in an established educational framework.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetName;
    /**
     * @type string $targetUrl The URL of a node in an established educational framework.
     * @Assert\Url
     * @ORM\Column
     */
    private $targetUrl;
}
