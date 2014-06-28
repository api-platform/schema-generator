<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Replace Action
 * 
 * @link http://schema.org/ReplaceAction
 * 
 * @ORM\Entity
 */
class ReplaceAction extends UpdateAction
{
    /**
     * Replacee
     * 
     * @var Thing $replacee A sub property of object. The object that is being replaced.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     */
    private $replacee;
    /**
     * Replacer
     * 
     * @var Thing $replacer A sub property of object. The object that replaces.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     */
    private $replacer;
}
