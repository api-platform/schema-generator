<?php

namespace SchemaOrg;

/**
 * TV Episode
 *
 * @link http://schema.org/TVEpisode
 */
class TVEpisode extends Episode
{
    /**
     * Part of TV Series
     *
     * @var TVSeries The TV series to which this episode or season belongs. (legacy form; partOfSeries is preferred)
     */
    protected $partOfTVSeries;
}
