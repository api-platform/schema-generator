<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of posing a question / favor to someone.<p>Related actions:</p><ul><li><a href="http://schema.org/ReplyAction">ReplyAction</a>: Appears generally as a response to AskAction.</li></ul>
 * 
 * @see http://schema.org/AskAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AskAction extends CommunicateAction
{
    /**
     * @type string $question A sub property of object. A question.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $question;
}
