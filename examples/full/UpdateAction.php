<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Update Action
 * 
 * @link http://schema.org/UpdateAction
 * 
 * @ORM\MappedSuperclass
 */
class UpdateAction extends Action
{
    /**
     * Collection
     * 
     * @var Thing $collection A sub property of object. The collection target of the action.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     */
    private $collection;
}
