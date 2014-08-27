<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An agent bookmarks/flags/labels/tags/marks an object.
 * 
 * @see http://schema.org/BookmarkAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BookmarkAction extends OrganizeAction
{
}
