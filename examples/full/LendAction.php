<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lend Action
 * 
 * @link http://schema.org/LendAction
 * 
 * @ORM\Entity
 */
class LendAction extends TransferAction
{
    /**
     * Borrower
     * 
     * @var Person $borrower A sub property of participant. The person that borrows the object being lent.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $borrower;
}
