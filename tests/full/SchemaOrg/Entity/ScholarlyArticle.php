<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A scholarly article.
 * 
 * @see http://schema.org/ScholarlyArticle Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ScholarlyArticle extends Article
{
}
