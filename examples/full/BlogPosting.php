<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Blog Posting
 * 
 * @link http://schema.org/BlogPosting
 * 
 * @ORM\Entity
 */
class BlogPosting extends Article
{
}
