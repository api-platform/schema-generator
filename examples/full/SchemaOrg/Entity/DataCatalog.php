<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A collection of datasets.
 * 
 * @see http://schema.org/DataCatalog Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DataCatalog extends CreativeWork
{
    /**
     * @type Dataset $dataset A dataset contained in a catalog.
     * @ORM\ManyToOne(targetEntity="Dataset")
     */
    private $dataset;
}
