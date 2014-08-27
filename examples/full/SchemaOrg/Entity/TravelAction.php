<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of traveling from an fromLocation to a destination by a specified mode of transport, optionally with participants.
 * 
 * @see http://schema.org/TravelAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TravelAction extends MoveAction
{
    /**
     * @type Distance $distance The distance travelled, e.g. exercising or travelling.
     * @ORM\ManyToOne(targetEntity="Distance")
     * @ORM\JoinColumn(nullable=false)
     */
    private $distance;
}
