<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Search Action
 * 
 * @link http://schema.org/SearchAction
 * 
 * @ORM\Entity
 */
class SearchAction extends Action
{
    /**
     * Query
     * 
     * @var Class $query A sub property of instrument. The query used on this action.
     * 
     * @ORM\ManyToOne(targetEntity="Class")
     */
    private $query;
}
