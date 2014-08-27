<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An article, such as a news article or piece of investigative report. Newspapers and magazines have articles of many different types and this is intended to cover them all.
 * 
 * @see http://schema.org/Article Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Article extends CreativeWork
{
    /**
     * @type string $articleBody The actual body of the article.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $articleBody;
    /**
     * @type string $articleSection Articles may belong to one or more 'sections' in a magazine or newspaper, such as Sports, Lifestyle, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $articleSection;
    /**
     * @type integer $wordCount The number of words in the text of the Article.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $wordCount;
    /**
     * @type integer $pageEnd The page on which the work ends; for example "138" or "xvi".
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $pageEnd;
    /**
     * @type integer $pageStart The page on which the work starts; for example "135" or "xiii".
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $pageStart;
    /**
     * @type string $pagination Any description of pages that is not separated into pageStart and pageEnd; for example, "1-6, 9, 55" or "10-12, 46-49".
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $pagination;
}
