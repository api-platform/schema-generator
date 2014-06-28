<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Inform Action
 * 
 * @link http://schema.org/InformAction
 * 
 * @ORM\MappedSuperclass
 */
class InformAction extends CommunicateAction
{
    /**
     * Event
     * 
     * @var Event $event Upcoming or past event associated with this place or organization.
     * 
     */
    private $event;
}
