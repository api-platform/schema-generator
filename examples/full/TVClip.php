<?php

namespace SchemaOrg;

/**
 * TV Clip
 *
 * @link http://schema.org/TVClip
 */
class TVClip extends Clip
{
    /**
     * Part of TV Series
     *
     * @var TVSeries The TV series to which this episode or season belongs. (legacy form; partOfSeries is preferred)
     */
    protected $partOfTVSeries;
}
