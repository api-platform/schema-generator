<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of expressing a preference from a fixed/finite/structured set of choices/options.
 * 
 * @see http://schema.org/VoteAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class VoteAction extends ChooseAction
{
    /**
     * @type Person $candidate A sub property of object. The candidate subject of this action.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $candidate;
}
