<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Choose Action
 * 
 * @link http://schema.org/ChooseAction
 * 
 * @ORM\MappedSuperclass
 */
class ChooseAction extends AssessAction
{
    /**
     * Option
     * 
     * @var string $option A sub property of object. The options subject to this action.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $option;
}
