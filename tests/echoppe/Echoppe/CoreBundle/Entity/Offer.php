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
use Echoppe\CoreBundle\Model\OfferInterface;
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
class Offer extends Thing implements OfferInterface
{
    /**
     * @type string $acceptedPaymentMethod The payment method(s) accepted by seller for this offer.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $acceptedPaymentMethod;
    /**
     * @type string $availability The availability of this item—for example In stock, Out of stock, Pre-order, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $availability;
    /**
     * @type \DateTime $availabilityEnds The end of the availability of the product or service included in the offer.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availabilityEnds;
    /**
     * @type \DateTime $availabilityStarts The beginning of the availability of the product or service included in the offer.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availabilityStarts;
    /**
     * @type string $availableDeliveryMethod The delivery method(s) available for this offer.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $availableDeliveryMethod;
    /**
     * @type string $category A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $category;
    /**
     * @type QuantitativeValueInterface $deliveryLeadTime The typical delay between the receipt of the order and the goods leaving the warehouse.
     * @ORM\OneToOne(targetEntity="QuantitativeValueInterface")
     */
    private $deliveryLeadTime;
    /**
     * @type QuantitativeValueInterface $inventoryLevel The current approximate inventory level for the item or items.
     * @ORM\OneToOne(targetEntity="QuantitativeValueInterface")
     */
    private $inventoryLevel;
    /**
     * @type string $itemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $itemCondition;
    /**
     * @type PriceSpecificationInterface $priceSpecification One or more detailed price specifications, indicating the unit price and delivery or payment charges.
     * @ORM\ManyToOne(targetEntity="PriceSpecificationInterface")
     */
    private $priceSpecification;

    /**
     * Sets acceptedPaymentMethod.
     *
     * @param  string $acceptedPaymentMethod
     * @return $this
     */
    public function setAcceptedPaymentMethod($acceptedPaymentMethod)
    {
        $this->acceptedPaymentMethod = $acceptedPaymentMethod;

        return $this;
    }

    /**
    * Gets acceptedPaymentMethod.
    *
    * @return string
    */
    public function getAcceptedPaymentMethod()
    {
        return $this->acceptedPaymentMethod;
    }

    /**
     * Sets availability.
     *
     * @param  string $availability
     * @return $this
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
    * Gets availability.
    *
    * @return string
    */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Sets availabilityEnds.
     *
     * @param  \DateTime $availabilityEnds
     * @return $this
     */
    public function setAvailabilityEnds($availabilityEnds)
    {
        $this->availabilityEnds = $availabilityEnds;

        return $this;
    }

    /**
    * Gets availabilityEnds.
    *
    * @return \DateTime
    */
    public function getAvailabilityEnds()
    {
        return $this->availabilityEnds;
    }

    /**
     * Sets availabilityStarts.
     *
     * @param  \DateTime $availabilityStarts
     * @return $this
     */
    public function setAvailabilityStarts($availabilityStarts)
    {
        $this->availabilityStarts = $availabilityStarts;

        return $this;
    }

    /**
    * Gets availabilityStarts.
    *
    * @return \DateTime
    */
    public function getAvailabilityStarts()
    {
        return $this->availabilityStarts;
    }

    /**
     * Sets availableDeliveryMethod.
     *
     * @param  string $availableDeliveryMethod
     * @return $this
     */
    public function setAvailableDeliveryMethod($availableDeliveryMethod)
    {
        $this->availableDeliveryMethod = $availableDeliveryMethod;

        return $this;
    }

    /**
    * Gets availableDeliveryMethod.
    *
    * @return string
    */
    public function getAvailableDeliveryMethod()
    {
        return $this->availableDeliveryMethod;
    }

    /**
     * Sets category.
     *
     * @param  string $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
    * Gets category.
    *
    * @return string
    */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets deliveryLeadTime.
     *
     * @param  QuantitativeValueInterface $deliveryLeadTime
     * @return $this
     */
    public function setDeliveryLeadTime(QuantitativeValueInterface $deliveryLeadTime)
    {
        $this->deliveryLeadTime = $deliveryLeadTime;

        return $this;
    }

    /**
    * Gets deliveryLeadTime.
    *
    * @return QuantitativeValueInterface
    */
    public function getDeliveryLeadTime()
    {
        return $this->deliveryLeadTime;
    }

    /**
     * Sets inventoryLevel.
     *
     * @param  QuantitativeValueInterface $inventoryLevel
     * @return $this
     */
    public function setInventoryLevel(QuantitativeValueInterface $inventoryLevel)
    {
        $this->inventoryLevel = $inventoryLevel;

        return $this;
    }

    /**
    * Gets inventoryLevel.
    *
    * @return QuantitativeValueInterface
    */
    public function getInventoryLevel()
    {
        return $this->inventoryLevel;
    }

    /**
     * Sets itemCondition.
     *
     * @param  string $itemCondition
     * @return $this
     */
    public function setItemCondition($itemCondition)
    {
        $this->itemCondition = $itemCondition;

        return $this;
    }

    /**
    * Gets itemCondition.
    *
    * @return string
    */
    public function getItemCondition()
    {
        return $this->itemCondition;
    }

    /**
     * Sets priceSpecification.
     *
     * @param  PriceSpecificationInterface $priceSpecification
     * @return $this
     */
    public function setPriceSpecification(PriceSpecificationInterface $priceSpecification)
    {
        $this->priceSpecification = $priceSpecification;

        return $this;
    }

    /**
    * Gets priceSpecification.
    *
    * @return PriceSpecificationInterface
    */
    public function getPriceSpecification()
    {
        return $this->priceSpecification;
    }
}
