<?php

namespace SchemaOrg;

/**
 * User Comments
 *
 * @link http://schema.org/UserComments
 */
class UserComments extends UserInteraction
{
    /**
     * Comment Text
     *
     * @var string The text of the UserComment.
     */
    protected $commentText;
    /**
     * Comment Time
     *
     * @var \DateTime The time at which the UserComment was made.
     */
    protected $commentTime;
    /**
     * Creator (Organization)
     *
     * @var Organization The creator/author of this CreativeWork or UserComments. This is the same as the Author property for CreativeWork.
     */
    protected $creatorOrganization;
    /**
     * Creator (Person)
     *
     * @var Person The creator/author of this CreativeWork or UserComments. This is the same as the Author property for CreativeWork.
     */
    protected $creatorPerson;
    /**
     * Discusses
     *
     * @var CreativeWork Specifies the CreativeWork associated with the UserComment.
     */
    protected $discusses;
    /**
     * Reply to Url
     *
     * @var string The URL at which a reply may be posted to the specified UserComment.
     */
    protected $replyToUrl;
}
