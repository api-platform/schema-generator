<?php

namespace SchemaOrg;

/**
 * TV Season
 *
 * @link http://schema.org/TVSeason
 */
class TVSeason extends CreativeWork
{
    /**
     * Part of TV Series
     *
     * @var TVSeries The TV series to which this episode or season belongs. (legacy form; partOfSeries is preferred)
     */
    protected $partOfTVSeries;
}
