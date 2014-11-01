<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any part of the human body, typically a component of an anatomical system. Organs, tissues, and cells are all anatomical structures.
 * 
 * @see http://schema.org/AnatomicalStructure Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AnatomicalStructure extends MedicalEntity
{
    /**
     */
    private $associatedPathophysiology;
    /**
     */
    private $bodyLocation;
    /**
     */
    private $connectedTo;
    /**
     */
    private $diagram;
    /**
     */
    private $function;
    /**
     */
    private $partOfSystem;
    /**
     */
    private $relatedCondition;
    /**
     */
    private $relatedTherapy;
    /**
     */
    private $subStructure;
}
