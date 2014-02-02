<?php

namespace SchemaOrg;

/**
 * Infectious Disease
 *
 * @link http://schema.org/InfectiousDisease
 */
class InfectiousDisease extends MedicalCondition
{
    /**
     * Infectious Agent
     *
     * @var string The actual infectious agent, such as a specific bacterium.
     */
    protected $infectiousAgent;
    /**
     * Infectious Agent Class
     *
     * @var InfectiousAgentClass The class of infectious agent (bacteria, prion, etc.) that causes the disease.
     */
    protected $infectiousAgentClass;
    /**
     * Transmission Method
     *
     * @var string How the disease spreads, either as a route or vector, for example 'direct contact', 'Aedes aegypti', etc.
     */
    protected $transmissionMethod;
}
