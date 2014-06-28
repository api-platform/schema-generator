<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Data Catalog
 * 
 * @link http://schema.org/DataCatalog
 * 
 * @ORM\Entity
 */
class DataCatalog extends CreativeWork
{
    /**
     * Dataset
     * 
     * @var Dataset $dataset A dataset contained in a catalog.
     * 
     * @ORM\ManyToOne(targetEntity="Dataset")
     */
    private $dataset;
}
