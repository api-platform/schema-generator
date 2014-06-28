<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Borrow Action
 * 
 * @link http://schema.org/BorrowAction
 * 
 * @ORM\Entity
 */
class BorrowAction extends TransferAction
{
    /**
     * Lender
     * 
     * @var Person $lender A sub property of participant. The person that lends the object being borrowed.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $lender;
}
