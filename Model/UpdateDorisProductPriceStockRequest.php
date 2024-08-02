<?php
/**
 * Leandro Rosa
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Doris Module to newer
 * versions in the future. If you wish to customize it for your
 * needs please refer to https://developer.adobe.com/commerce/docs/ for more information.
 *
 * @category LeandroRosa
 *
 * @copyright Copyright (c) 2024 Leandro Rosa (https:www.rosa-planet.com.br)
 *
 * @author Leandro Rosa <dev.leandrorosa@gmail.com>
 */
declare(strict_types=1);

namespace LeandroRosa\DorisCatalogIntegrator\Model;

use LeandroRosa\DorisCatalogIntegrator\Api\UpdateDorisProductPriceStockRequestInterface;
use Magento\Framework\DataObject;

class UpdateDorisProductPriceStockRequest extends DataObject implements UpdateDorisProductPriceStockRequestInterface
{
    /**
     * @inheritDoc
     */
    public function setSkuId($value): UpdateDorisProductPriceStockRequestInterface
    {
        return $this->setData(static::SKU_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getSkuId()
    {
        return $this->_getData(static::SKU_ID);
    }

    /**
     * @inheritDoc
     */
    public function setHasStock($value): UpdateDorisProductPriceStockRequestInterface
    {
        return $this->setData(static::HAS_STOCK, $value);
    }

    /**
     * @inheritDoc
     */
    public function getHasStock()
    {
        return (bool)$this->_getData(static::HAS_STOCK);
    }

    /**
     * @inheritDoc
     */
    public function setRegularPrice($value): UpdateDorisProductPriceStockRequestInterface
    {
        return $this->setData(static::REGULAR_PRICE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getRegularPrice()
    {
        return (int)$this->_getData(static::REGULAR_PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setSpecialPrice($value): UpdateDorisProductPriceStockRequestInterface
    {
        return $this->setData(static::SPECIAL_PRICE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getSpecialPrice()
    {
        return (int)$this->_getData(static::SPECIAL_PRICE);
    }

}
