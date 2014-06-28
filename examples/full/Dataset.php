<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dataset
 * 
 * @link http://schema.org/Dataset
 * 
 * @ORM\Entity
 */
class Dataset extends CreativeWork
{
    /**
     * Catalog
     * 
     * @var DataCatalog $catalog A data catalog which contains a dataset.
     * 
     * @ORM\ManyToOne(targetEntity="DataCatalog")
     */
    private $catalog;
    /**
     * Distribution
     * 
     * @var DataDownload $distribution A downloadable form of this dataset, at a specific location, in a specific format.
     * 
     * @ORM\ManyToOne(targetEntity="DataDownload")
     */
    private $distribution;
    /**
     * Spatial
     * 
     * @var Place $spatial The range of spatial applicability of a dataset, e.g. for a dataset of New York weather, the state of New York.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spatial;
    /**
     * Temporal
     * 
     * @var \DateTime $temporal The range of temporal applicability of a dataset, e.g. for a 2011 census dataset, the year 2011 (in ISO 8601 time interval format).
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $temporal;
}
