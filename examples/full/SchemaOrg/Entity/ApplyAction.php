<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of registering to an organization/service without the guarantee to receive it. NOTE(goto): should this be under InteractAction instead?<p>Related actions:</p><ul><li><a href="http://schema.org/RegisterAction">RegisterAction</a>: Unlike RegisterAction, ApplyAction has no guarantees that the application will be accepted.</li></ul>
 * 
 * @see http://schema.org/ApplyAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ApplyAction extends OrganizeAction
{
}
