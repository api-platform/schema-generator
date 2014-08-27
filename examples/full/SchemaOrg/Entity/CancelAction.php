<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of asserting that a future event/action is no longer going to happen.<p>Related actions:</p><ul><li><a href="http://schema.org/ConfirmAction">ConfirmAction</a>: The antagonym of CancelAction.</li></ul>
 * 
 * @see http://schema.org/CancelAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CancelAction extends PlanAction
{
}
