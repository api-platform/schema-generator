<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of producing a balanced opinion about the object for an audience. An agent reviews an object with participants resulting in a review.
 * 
 * @see http://schema.org/ReviewAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReviewAction extends AssessAction
{
    /**
     * @type Review $resultReview A sub property of result. The review that resulted in the performing of the action.
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $resultReview;
}
