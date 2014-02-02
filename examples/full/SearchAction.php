<?php

namespace SchemaOrg;

/**
 * Search Action
 *
 * @link http://schema.org/SearchAction
 */
class SearchAction extends Action
{
    /**
     * Query (Class)
     *
     * @var Class A sub property of instrument. The query used on this action.
     */
    protected $queryClass;
    /**
     * Query (Text)
     *
     * @var string A sub property of instrument. The query used on this action.
     */
    protected $queryText;
}
