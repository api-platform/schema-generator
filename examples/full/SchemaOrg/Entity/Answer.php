<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An answer offered to a question; perhaps correct, perhaps opinionated or wrong.
 * 
 * @see http://schema.org/Answer Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Answer extends CreativeWork
{
    /**
     * @type integer $upvoteCount The number of upvotes this question has received from the community.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $upvoteCount;
    /**
     * @type integer $downvoteCount The number of downvotes this question has received from the community.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $downvoteCount;
    /**
     * @type Question $parentItem The parent of a question, answer or item in general.
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parentItem;
}
