<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tech Article
 * 
 * @link http://schema.org/TechArticle
 * 
 * @ORM\MappedSuperclass
 */
class TechArticle extends Article
{
    /**
     * Dependencies
     * 
     * @var string $dependencies Prerequisites needed to fulfill steps in article.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $dependencies;
    /**
     * Proficiency Level
     * 
     * @var string $proficiencyLevel Proficiency needed for this content; expected values: 'Beginner', 'Expert'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $proficiencyLevel;
}
