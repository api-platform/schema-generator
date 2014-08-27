<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of committing to/adopting an object.<p>Related actions:</p><ul><li><a href="http://schema.org/RejectAction">RejectAction</a>: The antagonym of AcceptAction.</li></ul>
 * 
 * @see http://schema.org/AcceptAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AcceptAction extends AllocateAction
{
}
