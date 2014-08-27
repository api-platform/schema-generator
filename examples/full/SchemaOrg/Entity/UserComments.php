<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The UserInteraction event in which a user comments on an item.
 * 
 * @see http://schema.org/UserComments Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserComments extends UserInteraction
{
    /**
     * @type string $commentText The text of the UserComment.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $commentText;
    /**
     * @type \DateTime $commentTime The time at which the UserComment was made.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $commentTime;
    /**
     * @type Organization $creator The creator/author of this CreativeWork or UserComments. This is the same as the Author property for CreativeWork.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;
    /**
     * @type CreativeWork $discusses Specifies the CreativeWork associated with the UserComment.
     */
    private $discusses;
    /**
     * @type string $replyToUrl The URL at which a reply may be posted to the specified UserComment.
     * @Assert\Url
     * @ORM\Column
     */
    private $replyToUrl;
}
