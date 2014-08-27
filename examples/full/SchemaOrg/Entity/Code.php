<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Computer programming source code. Example: Full (compile ready) solutions, code snippet samples, scripts, templates.
 * 
 * @see http://schema.org/Code Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Code extends CreativeWork
{
    /**
     * @type string $codeRepository Link to the repository where the un-compiled, human readable code and related code is located (SVN, github, CodePlex)
     * @Assert\Url
     * @ORM\Column
     */
    private $codeRepository;
    /**
     * @type Thing $programmingLanguage The computer programming language.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $programmingLanguage;
    /**
     * @type string $runtime Runtime platform or script interpreter dependencies (Example - Java v1, Python2.3, .Net Framework 3.0)
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $runtime;
    /**
     * @type string $sampleType Full (compile ready) solution, code snippet, inline code, scripts, template.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $sampleType;
    /**
     * @type SoftwareApplication $targetProduct Target Operating System / Product to which the code applies.  If applies to several versions, just the product name can be used.
     */
    private $targetProduct;
}
