<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Civic Structure
 * 
 * @link http://schema.org/CivicStructure
 * 
 * @ORM\MappedSuperclass
 */
class CivicStructure extends Place
{
    /**
     * Opening Hours
     * 
     * @var Duration $openingHours The opening hours for a business. Opening hours can be specified as a weekly time range, starting with days, then times per day. Multiple days can be listed with commas ',' separating each day. Day or time ranges are specified using a hyphen '-'.- Days are specified using the following two-letter combinations: Mo, Tu, We, Th, Fr, Sa, Su.- Times are specified using 24:00 time. For example, 3pm is specified as 15:00. - Here is an example: <time itemprop="openingHours" datetime="Tu,Th 16:00-20:00">Tuesdays and Thursdays 4-8pm</time>. - If a business is open 7 days a week, then it can be specified as <time itemprop="openingHours" datetime="Mo-Su">Monday through Sunday, all day</time>.
     * 
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $openingHours;
}
