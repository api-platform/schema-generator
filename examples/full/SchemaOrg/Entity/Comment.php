<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A comment on an item - for example, a comment on a blog post. The comment's content is expressed via the "text" property, and its topic via "about", properties shared with all CreativeWorks.
 * 
 * @see http://schema.org/Comment Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Comment extends CreativeWork
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
