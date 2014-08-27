<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web page type: Search results page.
 * 
 * @see http://schema.org/SearchResultsPage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SearchResultsPage extends WebPage
{
}
