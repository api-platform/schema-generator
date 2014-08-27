<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A publication event e.g. catch-up TV or radio podcast, during which a program is available on-demand.
 * 
 * @see http://schema.org/OnDemandEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OnDemandEvent extends PublicationEvent
{
}
