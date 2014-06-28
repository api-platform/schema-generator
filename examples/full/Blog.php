<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Blog
 * 
 * @link http://schema.org/Blog
 * 
 * @ORM\Entity
 */
class Blog extends CreativeWork
{
    /**
     * Blog Post
     * 
     * @var BlogPosting $blogPost A posting that is part of this blog.
     * 
     * @ORM\ManyToOne(targetEntity="BlogPosting")
     */
    private $blogPost;
}
