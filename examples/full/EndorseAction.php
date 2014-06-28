<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Endorse Action
 * 
 * @link http://schema.org/EndorseAction
 * 
 * @ORM\Entity
 */
class EndorseAction extends ReactAction
{
    /**
     * Endorsee
     * 
     * @var Organization $endorsee A sub property of participant. The person/organization being supported.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $endorsee;
}
