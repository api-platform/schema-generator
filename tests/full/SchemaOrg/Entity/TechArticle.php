<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A technical article - Example: How-to (task) topics, step-by-step, procedural troubleshooting, specifications, etc.
 * 
 * @see http://schema.org/TechArticle Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TechArticle extends Article
{
    /**
     */
    private $dependencies;
    /**
     */
    private $proficiencyLevel;
}
