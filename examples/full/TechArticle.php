<?php

namespace SchemaOrg;

/**
 * Tech Article
 *
 * @link http://schema.org/TechArticle
 */
class TechArticle extends Article
{
    /**
     * Dependencies
     *
     * @var string Prerequisites needed to fulfill steps in article.
     */
    protected $dependencies;
    /**
     * Proficiency Level
     *
     * @var string Proficiency needed for this content; expected values: 'Beginner', 'Expert'.
     */
    protected $proficiencyLevel;
}
