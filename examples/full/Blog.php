<?php

namespace SchemaOrg;

/**
 * Blog
 *
 * @link http://schema.org/Blog
 */
class Blog extends CreativeWork
{
    /**
     * Blog Post
     *
     * @var BlogPosting A posting that is part of this blog.
     */
    protected $blogPost;
}
