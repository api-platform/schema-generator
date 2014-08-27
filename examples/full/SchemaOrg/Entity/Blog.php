<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A blog
 * 
 * @see http://schema.org/Blog Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Blog
{
    /**
     * @type BlogPosting $blogPost A posting that is part of this blog.
     * @ORM\ManyToOne(targetEntity="BlogPosting")
     */
    private $blogPost;
}
