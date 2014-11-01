<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A blog post.
 * 
 * @see http://schema.org/BlogPosting Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BlogPosting extends Article
{
}
