<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of allocating an action/event/task to some destination (someone or something).
 * 
 * @see http://schema.org/AssignAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AssignAction extends AllocateAction
{
}
