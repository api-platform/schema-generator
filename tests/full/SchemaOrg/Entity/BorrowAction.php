<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of obtaining an object under an agreement to return it at a later date. Reciprocal of LendAction.<p>Related actions:</p><ul><li><a href="http://schema.org/LendAction">LendAction</a>: Reciprocal of BorrowAction.</li></ul>
 * 
 * @see http://schema.org/BorrowAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BorrowAction extends TransferAction
{
    /**
     */
    private $lender;
}
