<?php

namespace SchemaOrg;

/**
 * Book
 *
 * @link http://schema.org/Book
 */
class Book extends CreativeWork
{
    /**
     * Book Edition
     *
     * @var string The edition of the book.
     */
    protected $bookEdition;
    /**
     * Book Format
     *
     * @var BookFormatType The format of the book.
     */
    protected $bookFormat;
    /**
     * Illustrator
     *
     * @var Person The illustrator of the book.
     */
    protected $illustrator;
    /**
     * ISBN
     *
     * @var string The ISBN of the book.
     */
    protected $isbn;
    /**
     * Number of Pages
     *
     * @var integer The number of pages in the book.
     */
    protected $numberOfPages;
}
