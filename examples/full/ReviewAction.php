<?php

namespace SchemaOrg;

/**
 * Review Action
 *
 * @link http://schema.org/ReviewAction
 */
class ReviewAction extends AssessAction
{
    /**
     * Result Review
     *
     * @var Review A sub property of result. The review that resulted in the performing of the action.
     */
    protected $resultReview;
}
