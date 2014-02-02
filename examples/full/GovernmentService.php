<?php

namespace SchemaOrg;

/**
 * Government Service
 *
 * @link http://schema.org/GovernmentService
 */
class GovernmentService extends Service
{
    /**
     * Service Operator
     *
     * @var Organization The operating organization, if different from the provider.  This enables the representation of services that are provided by an organization, but operated by another organization like a subcontractor.
     */
    protected $serviceOperator;
}
