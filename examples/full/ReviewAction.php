<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Review Action
 * 
 * @link http://schema.org/ReviewAction
 * 
 * @ORM\Entity
 */
class ReviewAction extends AssessAction
{
    /**
     * Result Review
     * 
     * @var Review $resultReview A sub property of result. The review that resulted in the performing of the action.
     * 
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $resultReview;
}
