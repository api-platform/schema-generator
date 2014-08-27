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
     * @type string $dependencies Prerequisites needed to fulfill steps in article.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $dependencies;
    /**
     * @type string $proficiencyLevel Proficiency needed for this content; expected values: 'Beginner', 'Expert'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $proficiencyLevel;
}
