<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * On Demand Event
 * 
 * @link http://schema.org/OnDemandEvent
 * 
 * @ORM\Entity
 */
class OnDemandEvent extends PublicationEvent
{
}
