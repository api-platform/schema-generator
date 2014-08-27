<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of gaining ownership of an object from an origin. Reciprocal of GiveAction.<p>Related actions:</p><ul><li><a href="http://schema.org/GiveAction">GiveAction</a>: The reciprocal of TakeAction.</li><li><a href="http://schema.org/ReceiveAction">ReceiveAction</a>: Unlike ReceiveAction, TakeAction implies that ownership has been transfered.</li></ul>
 * 
 * @see http://schema.org/TakeAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TakeAction extends TransferAction
{
}
