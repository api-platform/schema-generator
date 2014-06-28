<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 * 
 * @link http://schema.org/Book
 * 
 * @ORM\Entity
 */
class Book extends CreativeWork
{
    /**
     * Book Edition
     * 
     * @var string $bookEdition The edition of the book.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $bookEdition;
    /**
     * Book Format
     * 
     * @var BookFormatType $bookFormat The format of the book.
     * 
     * @ORM\ManyToOne(targetEntity="BookFormatType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookFormat;
    /**
     * Illustrator
     * 
     * @var Person $illustrator The illustrator of the book.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $illustrator;
    /**
     * ISBN
     * 
     * @var string $isbn The ISBN of the book.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $isbn;
    /**
     * Number of Pages
     * 
     * @var integer $numberOfPages The number of pages in the book.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $numberOfPages;
}
