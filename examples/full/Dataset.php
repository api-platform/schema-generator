<?php

namespace SchemaOrg;

/**
 * Dataset
 *
 * @link http://schema.org/Dataset
 */
class Dataset extends CreativeWork
{
    /**
     * Catalog
     *
     * @var DataCatalog A data catalog which contains a dataset.
     */
    protected $catalog;
    /**
     * Distribution
     *
     * @var DataDownload A downloadable form of this dataset, at a specific location, in a specific format.
     */
    protected $distribution;
    /**
     * Spatial
     *
     * @var Place The range of spatial applicability of a dataset, e.g. for a dataset of New York weather, the state of New York.
     */
    protected $spatial;
    /**
     * Temporal
     *
     * @var \DateTime The range of temporal applicability of a dataset, e.g. for a 2011 census dataset, the year 2011 (in ISO 8601 time interval format).
     */
    protected $temporal;
}
