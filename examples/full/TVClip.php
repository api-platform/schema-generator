<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * TV Clip
 * 
 * @link http://schema.org/TVClip
 * 
 * @ORM\Entity
 */
class TVClip extends Clip
{
    /**
     * Part of TV Series
     * 
     * @var TVSeries $partOfTVSeries The TV series to which this episode or season belongs. (legacy form; partOfSeries is preferred)
     * 
     * @ORM\ManyToOne(targetEntity="TVSeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfTVSeries;
}
