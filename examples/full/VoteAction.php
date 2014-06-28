<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vote Action
 * 
 * @link http://schema.org/VoteAction
 * 
 * @ORM\Entity
 */
class VoteAction extends ChooseAction
{
    /**
     * Candidate
     * 
     * @var Person $candidate A sub property of object. The candidate subject of this action.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $candidate;
}
