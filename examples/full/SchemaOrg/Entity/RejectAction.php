<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of rejecting to/adopting an object.<p>Related actions:</p><ul><li><a href="http://schema.org/AcceptAction">AcceptAction</a>: The antagonym of RejectAction.</li></ul>
 * 
 * @see http://schema.org/RejectAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RejectAction extends AllocateAction
{
}
