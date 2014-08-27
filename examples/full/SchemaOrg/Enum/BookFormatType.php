<?php


namespace SchemaOrg\Enum;

use MyCLabs\Enum\Enum;

/**
 * The publication format of the book.
 * 
 * @see http://schema.org/BookFormatType Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BookFormatType extends Enum
{
    /**
     * @type string E_BOOK Book format: Ebook.
    */
    const E_BOOK = 'http://schema.org/EBook';
    /**
     * @type string HARDCOVER Book format: Hardcover.
    */
    const HARDCOVER = 'http://schema.org/Hardcover';
    /**
     * @type string PAPERBACK Book format: Paperback.
    */
    const PAPERBACK = 'http://schema.org/Paperback';
}
