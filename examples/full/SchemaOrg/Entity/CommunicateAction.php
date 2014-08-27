<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of conveying information to another person via a communication medium (instrument) such as speech, email, or telephone conversation.
 * 
 * @see http://schema.org/CommunicateAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CommunicateAction extends InteractAction
{
    /**
     * @type Thing $about The subject matter of the content.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $about;
    /**
     * @type Language $language A sub property of instrument. The language used on this action.
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $language;
    /**
     * @type Audience $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * @ORM\ManyToOne(targetEntity="Audience")
     */
    private $recipient;
}
