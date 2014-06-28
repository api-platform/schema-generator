<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Perform Action
 * 
 * @link http://schema.org/PerformAction
 * 
 * @ORM\Entity
 */
class PerformAction extends PlayAction
{
    /**
     * Entertainment Business
     * 
     * @var EntertainmentBusiness $entertainmentBusiness A sub property of location. The entertainment business where the action occurred.
     * 
     * @ORM\ManyToOne(targetEntity="EntertainmentBusiness")
     */
    private $entertainmentBusiness;
}
