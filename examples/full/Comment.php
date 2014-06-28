<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 * 
 * @link http://schema.org/Comment
 * 
 * @ORM\Entity
 */
class Comment extends CreativeWork
{
}
