<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Allocate Action
 * 
 * @link http://schema.org/AllocateAction
 * 
 * @ORM\MappedSuperclass
 */
class AllocateAction extends OrganizeAction
{
    /**
     * Purpose
     * 
     * @var Thing $purpose A goal towards an action is taken. Can be concrete or abstract.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     */
    private $purpose;
}
