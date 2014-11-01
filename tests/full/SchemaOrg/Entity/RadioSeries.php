<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Series dedicated to radio broadcast and associated online delivery.
 * 
 * @see http://schema.org/RadioSeries Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RadioSeries extends Series
{
    /**
     */
    private $actor;
    /**
     */
    private $director;
    /**
     */
    private $episode;
    /**
     */
    private $musicBy;
    /**
     */
    private $numberOfEpisodes;
    /**
     */
    private $producer;
    /**
     */
    private $productionCompany;
    /**
     */
    private $season;
    /**
     */
    private $trailer;
}
