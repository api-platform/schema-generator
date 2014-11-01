<?php

/*
 * This file is part of the Échoppe package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Echoppe\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Echoppe\CoreBundle\Model\PriceSpecificationInterface;
use Echoppe\CoreBundle\Model\QuantitativeValueInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @ORM\MappedSuperclass
 */
class PriceSpecification implements PriceSpecificationInterface
{
    /**
     * @type QuantitativeValueInterface $eligibleQuantity The interval and unit of measurement of ordering quantities for which the offer or price specification is valid. This allows e.g. specifying that a certain freight charge is valid only for a certain quantity.
     * @ORM\OneToOne(targetEntity="QuantitativeValueInterface")
     */
    private $eligibleQuantity;
    /**
     * @type PriceSpecificationInterface $eligibleTransactionVolume The transaction volume, in a monetary unit, for which the offer or price specification is valid, e.g. for indicating a minimal purchasing volume, to express free shipping above a certain order volume, or to limit the acceptance of credit cards to purchases to a certain minimal amount.
     * @ORM\OneToOne(targetEntity="PriceSpecificationInterface")
     */
    private $eligibleTransactionVolume;
    /**
     * @type float $price The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.
     *
     *     Usage guidelines:
     *
     *    - Use the [priceCurrency](/priceCurrency) property (with [ISO 4217 codes](http://en.wikipedia.org/wiki/ISO_4217#Active_codes) e.g. "USD") instead of including [ambiguous symbols](http://en.wikipedia.org/wiki/Dollar_sign#Currencies_that_use_the_dollar_or_peso_sign) such as '$' in the value.
     *    - Use '.' (Unicode 'FULL STOP' (U+002E)) rather than ',' to indicate a decimal point. Avoid using these symbols as a readability separator.
     *    - Note that both [RDFa](http://www.w3.org/TR/xhtml-rdfa-primer/#using-the-content-attribute) and Microdata syntax allow the use of a "content=" attribute for publishing simple machine-readable values alongside more human-friendly formatting.
     *    - Use values from 0123456789 (Unicode 'DIGIT ZERO' (U+0030) to 'DIGIT NINE' (U+0039)) rather than superficially similiar Unicode symbols.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $price;
    /**
     * @type \DateTime $validFrom The date when the item becomes valid.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validFrom;
    /**
     * @type \DateTime $validThrough The end of the validity of offer, price specification, or opening hours data.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validThrough;
    /**
     * @type boolean $valueAddedTaxIncluded Specifies whether the applicable value-added tax (VAT) is included in the price specification or not.
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $valueAddedTaxIncluded;

    /**
     * Sets eligibleQuantity.
     *
     * @param  QuantitativeValueInterface $eligibleQuantity
     * @return $this
     */
    public function setEligibleQuantity(QuantitativeValueInterface $eligibleQuantity)
    {
        $this->eligibleQuantity = $eligibleQuantity;

        return $this;
    }

    /**
    * Gets eligibleQuantity.
    *
    * @return QuantitativeValueInterface
    */
    public function getEligibleQuantity()
    {
        return $this->eligibleQuantity;
    }

    /**
     * Sets eligibleTransactionVolume.
     *
     * @param  PriceSpecificationInterface $eligibleTransactionVolume
     * @return $this
     */
    public function setEligibleTransactionVolume(PriceSpecificationInterface $eligibleTransactionVolume)
    {
        $this->eligibleTransactionVolume = $eligibleTransactionVolume;

        return $this;
    }

    /**
    * Gets eligibleTransactionVolume.
    *
    * @return PriceSpecificationInterface
    */
    public function getEligibleTransactionVolume()
    {
        return $this->eligibleTransactionVolume;
    }

    /**
     * Sets price.
     *
     * @param  float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
    * Gets price.
    *
    * @return float
    */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets validFrom.
     *
     * @param  \DateTime $validFrom
     * @return $this
     */
    public function setValidFrom($validFrom)
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    /**
    * Gets validFrom.
    *
    * @return \DateTime
    */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * Sets validThrough.
     *
     * @param  \DateTime $validThrough
     * @return $this
     */
    public function setValidThrough($validThrough)
    {
        $this->validThrough = $validThrough;

        return $this;
    }

    /**
    * Gets validThrough.
    *
    * @return \DateTime
    */
    public function getValidThrough()
    {
        return $this->validThrough;
    }

    /**
     * Sets valueAddedTaxIncluded.
     *
     * @param  boolean $valueAddedTaxIncluded
     * @return $this
     */
    public function setValueAddedTaxIncluded($valueAddedTaxIncluded)
    {
        $this->valueAddedTaxIncluded = $valueAddedTaxIncluded;

        return $this;
    }

    /**
    * Gets valueAddedTaxIncluded.
    *
    * @return boolean
    */
    public function getValueAddedTaxIncluded()
    {
        return $this->valueAddedTaxIncluded;
    }
}
