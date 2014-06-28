<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ask Action
 * 
 * @link http://schema.org/AskAction
 * 
 * @ORM\Entity
 */
class AskAction extends CommunicateAction
{
    /**
     * Question
     * 
     * @var string $question A sub property of object. A question.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $question;
}
