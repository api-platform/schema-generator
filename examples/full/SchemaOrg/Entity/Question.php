<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A specific question - e.g. from a user seeking answers online, or collected in a Frequently Asked Questions (FAQ) document.
 * 
 * @see http://schema.org/Question Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Question extends CreativeWork
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
     * @type integer $answerCount The number of answers this question has received.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $answerCount;
    /**
     * @type Answer $acceptedAnswer The answer that has been accepted as best, typically on a Question/Answer site. Sites vary in their selection mechanisms, e.g. drawing on community opinion and/or the view of the Question author.
     * @ORM\ManyToOne(targetEntity="Answer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acceptedAnswer;
    /**
     * @type Answer $suggestedAnswer An answer (possibly one of several, possibly incorrect) to a Question, e.g. on a Question/Answer site.
     * @ORM\ManyToOne(targetEntity="Answer")
     */
    private $suggestedAnswer;
}
