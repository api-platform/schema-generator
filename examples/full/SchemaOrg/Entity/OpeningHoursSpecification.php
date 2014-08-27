<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A structured value providing information about the opening hours of a place or a certain service inside a place.
 * 
 * @see http://schema.org/OpeningHoursSpecification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OpeningHoursSpecification extends StructuredValue
{
    /**
     * @type \DateTime $closes The closing hour of the place or service on the given day(s) of the week.
     * @Assert\Time
     * @ORM\Column(type="time")
     */
    private $closes;
    /**
     * @type DayOfWeek $dayOfWeek The day of the week for which these opening hours are valid.
     * @ORM\ManyToOne(targetEntity="DayOfWeek")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dayOfWeek;
    /**
     * @type \DateTime $opens The opening hour of the place or service on the given day(s) of the week.
     * @Assert\Time
     * @ORM\Column(type="time")
     */
    private $opens;
    /**
     * @type \DateTime $validFrom The date when the item becomes valid.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validFrom;
    /**
     * @type \DateTime $validThrough The end of the validity of offer, price specification, or opening hours data.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validThrough;
}
