<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An indication for a medical therapy that has been formally specified or approved by a regulatory body that regulates use of the therapy; for example, the US FDA approves indications for most drugs in the US.
 * 
 * @see http://schema.org/ApprovedIndication Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ApprovedIndication extends MedicalIndication
{
}
