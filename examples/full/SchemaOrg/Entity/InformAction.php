<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of notifying someone of information pertinent to them, with no expectation of a response.
 * 
 * @see http://schema.org/InformAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class InformAction extends CommunicateAction
{
    /**
     * @type Event $event Upcoming or past event associated with this place or organization.
     */
    private $event;
}
