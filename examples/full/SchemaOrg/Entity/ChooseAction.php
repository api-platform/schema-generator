<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of expressing a preference from a set of options or a large or unbounded set of choices/options.
 * 
 * @see http://schema.org/ChooseAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ChooseAction extends AssessAction
{
    /**
     * @type string $option A sub property of object. The options subject to this action.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $option;
}
