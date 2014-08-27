<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of distributing content to people for their amusement or edification.
 * 
 * @see http://schema.org/ShareAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ShareAction extends CommunicateAction
{
}
