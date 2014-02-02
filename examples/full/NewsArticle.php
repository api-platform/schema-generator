<?php

namespace SchemaOrg;

/**
 * News Article
 *
 * @link http://schema.org/NewsArticle
 */
class NewsArticle extends Article
{
    /**
     * Dateline
     *
     * @var string The location where the NewsArticle was produced.
     */
    protected $dateline;
    /**
     * Print Column
     *
     * @var string The number of the column in which the NewsArticle appears in the print edition.
     */
    protected $printColumn;
    /**
     * Print Edition
     *
     * @var string The edition of the print product in which the NewsArticle appears.
     */
    protected $printEdition;
    /**
     * Print Page
     *
     * @var string If this NewsArticle appears in print, this field indicates the name of the page on which the article is found. Please note that this field is intended for the exact page name (e.g. A5, B18).
     */
    protected $printPage;
    /**
     * Print Section
     *
     * @var string If this NewsArticle appears in print, this field indicates the print section in which the article appeared.
     */
    protected $printSection;
}
