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
use Echoppe\CoreBundle\Model\QuantitativeValueInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @ORM\MappedSuperclass
 */
class QuantitativeValue extends StructuredValue implements QuantitativeValueInterface
{
    /**
     * @type string $unitCode The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $unitCode;
    /**
     * @type float $value The value of the product characteristic.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * Sets unitCode.
     *
     * @param  string $unitCode
     * @return $this
     */
    public function setUnitCode($unitCode)
    {
        $this->unitCode = $unitCode;

        return $this;
    }

    /**
    * Gets unitCode.
    *
    * @return string
    */
    public function getUnitCode()
    {
        return $this->unitCode;
    }

    /**
     * Sets value.
     *
     * @param  float $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
    * Gets value.
    *
    * @return float
    */
    public function getValue()
    {
        return $this->value;
    }
}
