<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Infectious Disease
 * 
 * @link http://schema.org/InfectiousDisease
 * 
 * @ORM\Entity
 */
class InfectiousDisease extends MedicalCondition
{
    /**
     * Infectious Agent
     * 
     * @var string $infectiousAgent The actual infectious agent, such as a specific bacterium.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $infectiousAgent;
    /**
     * Infectious Agent Class
     * 
     * @var InfectiousAgentClass $infectiousAgentClass The class of infectious agent (bacteria, prion, etc.) that causes the disease.
     * 
     * @ORM\ManyToOne(targetEntity="InfectiousAgentClass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $infectiousAgentClass;
    /**
     * Transmission Method
     * 
     * @var string $transmissionMethod How the disease spreads, either as a route or vector, for example 'direct contact', 'Aedes aegypti', etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $transmissionMethod;
}
