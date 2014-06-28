<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Alignment Object
 * 
 * @link http://schema.org/AlignmentObject
 * 
 * @ORM\Entity
 */
class AlignmentObject extends Intangible
{
    /**
     * Alignment Type
     * 
     * @var string $alignmentType A category of alignment between the learning resource and the framework node. Recommended values include: 'assesses', 'teaches', 'requires', 'textComplexity', 'readingLevel', 'educationalSubject', and 'educationLevel'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $alignmentType;
    /**
     * Educational Framework
     * 
     * @var string $educationalFramework The framework to which the resource being described is aligned.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $educationalFramework;
    /**
     * Target Description
     * 
     * @var string $targetDescription The description of a node in an established educational framework.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetDescription;
    /**
     * Target Name
     * 
     * @var string $targetName The name of a node in an established educational framework.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetName;
    /**
     * Target Url
     * 
     * @var string $targetUrl The URL of a node in an established educational framework.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $targetUrl;
}
