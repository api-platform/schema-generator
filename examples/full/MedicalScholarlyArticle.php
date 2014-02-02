<?php

namespace SchemaOrg;

/**
 * Medical Scholarly Article
 *
 * @link http://schema.org/MedicalScholarlyArticle
 */
class MedicalScholarlyArticle extends ScholarlyArticle
{
    /**
     * Publication Type
     *
     * @var string The type of the medical article, taken from the US NLM MeSH <a href="http://www.nlm.nih.gov/mesh/pubtypes.html">publication type catalog.</a>
     */
    protected $publicationType;
}
