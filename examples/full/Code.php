<?php

namespace SchemaOrg;

/**
 * Code
 *
 * @link http://schema.org/Code
 */
class Code extends CreativeWork
{
    /**
     * Code Repository
     *
     * @var string Link to the repository where the un-compiled, human readable code and related code is located (SVN, github, CodePlex)
     */
    protected $codeRepository;
    /**
     * Programming Language
     *
     * @var Thing The computer programming language.
     */
    protected $programmingLanguage;
    /**
     * Runtime
     *
     * @var string Runtime platform or script interpreter dependencies (Example - Java v1, Python2.3, .Net Framework 3.0)
     */
    protected $runtime;
    /**
     * Sample Type
     *
     * @var string Full (compile ready) solution, code snippet, inline code, scripts, template.
     */
    protected $sampleType;
    /**
     * Target Product
     *
     * @var SoftwareApplication Target Operating System / Product to which the code applies.  If applies to several versions, just the product name can be used.
     */
    protected $targetProduct;
}
