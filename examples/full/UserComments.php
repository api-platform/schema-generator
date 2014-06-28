<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User Comments
 * 
 * @link http://schema.org/UserComments
 * 
 * @ORM\Entity
 */
class UserComments extends UserInteraction
{
    /**
     * Comment Text
     * 
     * @var string $commentText The text of the UserComment.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $commentText;
    /**
     * Comment Time
     * 
     * @var \DateTime $commentTime The time at which the UserComment was made.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $commentTime;
    /**
     * Creator
     * 
     * @var Organization $creator The creator/author of this CreativeWork or UserComments. This is the same as the Author property for CreativeWork.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;
    /**
     * Discusses
     * 
     * @var CreativeWork $discusses Specifies the CreativeWork associated with the UserComment.
     * 
     */
    private $discusses;
    /**
     * Reply to Url
     * 
     * @var string $replyToUrl The URL at which a reply may be posted to the specified UserComment.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $replyToUrl;
}
