<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 * 
 * @link http://schema.org/Article
 * 
 * @ORM\MappedSuperclass
 */
class Article extends CreativeWork
{
    /**
     * Article Body
     * 
     * @var string $articleBody The actual body of the article.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $articleBody;
    /**
     * Article Section
     * 
     * @var string $articleSection Articles may belong to one or more 'sections' in a magazine or newspaper, such as Sports, Lifestyle, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $articleSection;
    /**
     * Word Count
     * 
     * @var integer $wordCount The number of words in the text of the Article.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $wordCount;
}
