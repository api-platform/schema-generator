<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Scholarly Article
 * 
 * @link http://schema.org/ScholarlyArticle
 * 
 * @ORM\MappedSuperclass
 */
class ScholarlyArticle extends Article
{
}
