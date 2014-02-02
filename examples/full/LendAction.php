<?php

namespace SchemaOrg;

/**
 * Lend Action
 *
 * @link http://schema.org/LendAction
 */
class LendAction extends TransferAction
{
    /**
     * Borrower
     *
     * @var Person A sub property of participant. The person that borrows the object being lent.
     */
    protected $borrower;
}
