<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of notifying someone that a future event/action is going to happen as expected.<p>Related actions:</p><ul><li><a href="http://schema.org/CancelAction">CancelAction</a>: The antagonym of ConfirmAction.</li></ul>
 * 
 * @see http://schema.org/ConfirmAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ConfirmAction extends InformAction
{
}
