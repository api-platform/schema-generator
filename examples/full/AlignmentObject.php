<?php

namespace SchemaOrg;

/**
 * Alignment Object
 *
 * @link http://schema.org/AlignmentObject
 */
class AlignmentObject extends Intangible
{
    /**
     * Alignment Type
     *
     * @var string A category of alignment between the learning resource and the framework node. Recommended values include: 'assesses', 'teaches', 'requires', 'textComplexity', 'readingLevel', 'educationalSubject', and 'educationLevel'.
     */
    protected $alignmentType;
    /**
     * Educational Framework
     *
     * @var string The framework to which the resource being described is aligned.
     */
    protected $educationalFramework;
    /**
     * Target Description
     *
     * @var string The description of a node in an established educational framework.
     */
    protected $targetDescription;
    /**
     * Target Name
     *
     * @var string The name of a node in an established educational framework.
     */
    protected $targetName;
    /**
     * Target Url
     *
     * @var string The URL of a node in an established educational framework.
     */
    protected $targetUrl;
}
