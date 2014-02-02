<?php

namespace SchemaOrg;

/**
 * Article
 *
 * @link http://schema.org/Article
 */
class Article extends CreativeWork
{
    /**
     * Article Body
     *
     * @var string The actual body of the article.
     */
    protected $articleBody;
    /**
     * Article Section
     *
     * @var string Articles may belong to one or more 'sections' in a magazine or newspaper, such as Sports, Lifestyle, etc.
     */
    protected $articleSection;
    /**
     * Word Count
     *
     * @var integer The number of words in the text of the Article.
     */
    protected $wordCount;
}
