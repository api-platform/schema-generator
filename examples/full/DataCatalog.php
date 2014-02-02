<?php

namespace SchemaOrg;

/**
 * Data Catalog
 *
 * @link http://schema.org/DataCatalog
 */
class DataCatalog extends CreativeWork
{
    /**
     * Dataset
     *
     * @var Dataset A dataset contained in a catalog.
     */
    protected $dataset;
}
