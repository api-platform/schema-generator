<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A QAPage is a WebPage focussed on a specific Question and its Answer(s), e.g. in a question answering site or documenting Frequently Asked Questions (FAQs).
 * 
 * @see http://schema.org/QAPage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class QAPage extends WebPage
{
}
