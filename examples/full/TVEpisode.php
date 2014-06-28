<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * TV Episode
 * 
 * @link http://schema.org/TVEpisode
 * 
 * @ORM\Entity
 */
class TVEpisode extends Episode
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
