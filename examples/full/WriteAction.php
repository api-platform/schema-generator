<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Write Action
 * 
 * @link http://schema.org/WriteAction
 * 
 * @ORM\Entity
 */
class WriteAction extends CreateAction
{
    /**
     * Language
     * 
     * @var Language $language A sub property of instrument. The languaged used on this action.
     * 
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $language;
}
