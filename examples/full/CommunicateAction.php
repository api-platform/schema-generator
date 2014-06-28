<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Communicate Action
 * 
 * @link http://schema.org/CommunicateAction
 * 
 * @ORM\MappedSuperclass
 */
class CommunicateAction extends InteractAction
{
    /**
     * About
     * 
     * @var Thing $about The subject matter of the content.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $about;
    /**
     * Language
     * 
     * @var Language $language A sub property of instrument. The languaged used on this action.
     * 
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $language;
    /**
     * Recipient
     * 
     * @var Organization $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $recipient;
}
