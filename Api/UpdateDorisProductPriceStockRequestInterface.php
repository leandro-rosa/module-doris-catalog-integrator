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

namespace LeandroRosa\DorisCatalogIntegrator\Api;


interface UpdateDorisProductPriceStockRequestInterface
{
    public const SKU_ID = 'sku_id';
    public const HAS_STOCK = 'has_stock';
    public const REGULAR_PRICE = 'regular_price';
    public const SPECIAL_PRICE = 'special_price';

    /**
     * @param string $value
     * @return self
     */
    public function setSkuId($value): self;

    /**
     * @return string|null
     */
    public function getSkuId();

    /**
     * @param bool $value
     * @return self
     */
    public function setHasStock($value): self;

    /**
     * @return bool|null
     */
    public function getHasStock();

    /**
     * @param int $value
     * @return self
     */
    public function setRegularPrice($value): self;

    /**
     * @return int|null
     */
    public function getRegularPrice();

    /**
     * @param int $value
     * @return self
     */
    public function setSpecialPrice($value): self;

    /**
     * @return int|null
     */
    public function getSpecialPrice();
}
