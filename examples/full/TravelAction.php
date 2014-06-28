<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Travel Action
 * 
 * @link http://schema.org/TravelAction
 * 
 * @ORM\Entity
 */
class TravelAction extends MoveAction
{
    /**
     * Distance
     * 
     * @var Distance $distance A sub property of asset. The distance travelled.
     * 
     * @ORM\ManyToOne(targetEntity="Distance")
     */
    private $distance;
}
