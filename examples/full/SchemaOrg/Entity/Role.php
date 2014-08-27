<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents additional information about a relationship or property. For example a Role can be used to say that a 'member' role linking some SportsTeam to a player occurred during a particular time period. Or that a Person's 'actor' role in a Movie was for some particular characterName. Such properties can be attached to a Role entity, which is then associated with the main entities using ordinary properties like 'member' or 'actor'.
 *     
 * 
 * @see http://schema.org/Role Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Role extends Intangible
{
    /**
     * @type \DateTime $endDate The end date and time of the role, event or item (in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>).
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $endDate;
    /**
     * @type \DateTime $startDate The start date and time of the event, role or item (in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>).
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $startDate;
}
