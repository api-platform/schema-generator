<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Opening Hours Specification
 * 
 * @link http://schema.org/OpeningHoursSpecification
 * 
 * @ORM\Entity
 */
class OpeningHoursSpecification extends StructuredValue
{
    /**
     * Closes
     * 
     * @var \DateTime $closes The closing hour of the place or service on the given day(s) of the week.
     * 
     * @Assert\Time
     * @ORM\Column(type="time")
     */
    private $closes;
    /**
     * Day of Week
     * 
     * @var DayOfWeek $dayOfWeek The day of the week for which these opening hours are valid.
     * 
     * @ORM\ManyToOne(targetEntity="DayOfWeek")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dayOfWeek;
    /**
     * Opens
     * 
     * @var \DateTime $opens The opening hour of the place or service on the given day(s) of the week.
     * 
     * @Assert\Time
     * @ORM\Column(type="time")
     */
    private $opens;
    /**
     * Valid From
     * 
     * @var \DateTime $validFrom The date when the item becomes valid.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validFrom;
    /**
     * Valid Through
     * 
     * @var \DateTime $validThrough The end of the validity of offer, price specification, or opening hours data.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validThrough;
}
