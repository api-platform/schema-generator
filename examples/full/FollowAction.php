<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Follow Action
 * 
 * @link http://schema.org/FollowAction
 * 
 * @ORM\Entity
 */
class FollowAction extends InteractAction
{
    /**
     * Followee
     * 
     * @var Organization $followee A sub property of object. The person or organization being followed.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $followee;
}
