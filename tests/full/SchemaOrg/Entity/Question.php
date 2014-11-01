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
     */
    private $upvoteCount;
    /**
     */
    private $downvoteCount;
    /**
     */
    private $answerCount;
    /**
     */
    private $acceptedAnswer;
    /**
     */
    private $suggestedAnswer;
}
