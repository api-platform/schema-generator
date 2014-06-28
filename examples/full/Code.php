<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Code
 * 
 * @link http://schema.org/Code
 * 
 * @ORM\Entity
 */
class Code extends CreativeWork
{
    /**
     * Code Repository
     * 
     * @var string $codeRepository Link to the repository where the un-compiled, human readable code and related code is located (SVN, github, CodePlex)
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $codeRepository;
    /**
     * Programming Language
     * 
     * @var Thing $programmingLanguage The computer programming language.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $programmingLanguage;
    /**
     * Runtime
     * 
     * @var string $runtime Runtime platform or script interpreter dependencies (Example - Java v1, Python2.3, .Net Framework 3.0)
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $runtime;
    /**
     * Sample Type
     * 
     * @var string $sampleType Full (compile ready) solution, code snippet, inline code, scripts, template.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $sampleType;
    /**
     * Target Product
     * 
     * @var SoftwareApplication $targetProduct Target Operating System / Product to which the code applies.  If applies to several versions, just the product name can be used.
     * 
     */
    private $targetProduct;
}
