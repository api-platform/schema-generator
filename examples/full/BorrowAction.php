<?php

namespace SchemaOrg;

/**
 * Borrow Action
 *
 * @link http://schema.org/BorrowAction
 */
class BorrowAction extends TransferAction
{
    /**
     * Lender
     *
     * @var Person A sub property of participant. The person that lends the object being borrowed.
     */
    protected $lender;
}
