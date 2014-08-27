<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A body of structured information describing some topic(s) of interest.
 * 
 * @see http://schema.org/Dataset Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Dataset extends CreativeWork
{
    /**
     * @type DataCatalog $catalog A data catalog which contains a dataset.
     * @ORM\ManyToOne(targetEntity="DataCatalog")
     */
    private $catalog;
    /**
     * @type DataDownload $distribution A downloadable form of this dataset, at a specific location, in a specific format.
     * @ORM\ManyToOne(targetEntity="DataDownload")
     */
    private $distribution;
    /**
     * @type Place $spatial The range of spatial applicability of a dataset, e.g. for a dataset of New York weather, the state of New York.
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spatial;
    /**
     * @type \DateTime $temporal The range of temporal applicability of a dataset, e.g. for a 2011 census dataset, the year 2011 (in ISO 8601 time interval format).
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $temporal;
}
