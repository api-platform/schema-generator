<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An infectious disease is a clinically evident human disease resulting from the presence of pathogenic microbial agents, like pathogenic viruses, pathogenic bacteria, fungi, protozoa, multicellular parasites, and prions. To be considered an infectious disease, such pathogens are known to be able to cause this disease.
 * 
 * @see http://schema.org/InfectiousDisease Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class InfectiousDisease extends MedicalCondition
{
    /**
     * @type string $infectiousAgent The actual infectious agent, such as a specific bacterium.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $infectiousAgent;
    /**
     * @type InfectiousAgentClass $infectiousAgentClass The class of infectious agent (bacteria, prion, etc.) that causes the disease.
     * @ORM\ManyToOne(targetEntity="InfectiousAgentClass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $infectiousAgentClass;
    /**
     * @type string $transmissionMethod How the disease spreads, either as a route or vector, for example 'direct contact', 'Aedes aegypti', etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $transmissionMethod;
}
