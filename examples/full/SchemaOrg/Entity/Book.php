<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A book.
 * 
 * @see http://schema.org/Book Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Book extends CreativeWork
{
    /**
     * @type string $bookEdition The edition of the book.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $bookEdition;
    /**
     * @type BookFormatType $bookFormat The format of the book.
     * @ORM\ManyToOne(targetEntity="BookFormatType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookFormat;
    /**
     * @type Person $illustrator The illustrator of the book.
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $illustrator;
    /**
     * @type string $isbn The ISBN of the book.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $isbn;
    /**
     * @type integer $numberOfPages The number of pages in the book.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $numberOfPages;
}
