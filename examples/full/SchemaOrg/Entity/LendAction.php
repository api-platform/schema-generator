<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of providing an object under an agreement that it will be returned at a later date. Reciprocal of BorrowAction.<p>Related actions:</p><ul><li><a href="http://schema.org/BorrowAction">BorrowAction</a>: Reciprocal of LendAction.</li></ul>
 * 
 * @see http://schema.org/LendAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LendAction extends TransferAction
{
    /**
     * @type Person $borrower A sub property of participant. The person that borrows the object being lent.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $borrower;
}
