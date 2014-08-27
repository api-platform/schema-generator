<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of responding to a question/message asked/sent by the object. Related to <a href="AskAction">AskAction</a>.<p>Related actions:</p><ul><li><a href="http://schema.org/AskAction">AskAction</a>: Appears generally as an origin of a ReplyAction.</li></ul>
 * 
 * @see http://schema.org/ReplyAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReplyAction extends CommunicateAction
{
}
