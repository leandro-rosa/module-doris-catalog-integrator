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

use LeandroRosa\DorisCatalogIntegrator\Api\CreateDorisProductRequestInterface;
use Magento\Framework\DataObject;

class CreateDorisProductRequest extends DataObject implements CreateDorisProductRequestInterface
{
    /**
     * @inheritDoc
     */
    public function setName($name): CreateDorisProductRequest
    {
        return $this->setData(static::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(static::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier($identifier): CreateDorisProductRequest
    {
        return $this->setData(static::IDENTIFIER, $identifier);
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier()
    {
        return $this->getData('identifier');
    }

    /**
     * @inheritDoc
     */
    public function setUrl($url): CreateDorisProductRequest
    {
        return $this->setData(static::URL, $url);
    }

    /**
     * @inheritDoc
     */
    public function getUrl()
    {
        return $this->getData(static::URL);
    }

    /**
     * @inheritDoc
     */
    public function setImageUrls($imageUrls): CreateDorisProductRequest
    {
        return $this->setData(static::IMAGE_URLS, $imageUrls);
    }

    /**
     * @inheritDoc
     */
    public function getImageUrls()
    {
        return $this->getData(static::IMAGE_URLS);
    }

    /**
     * @inheritDoc
     */
    public function setRegularPrice($regularPrice): CreateDorisProductRequest
    {
        return $this->setData(static::REGULAR_PRICE, $regularPrice);
    }

    /**
     * @inheritDoc
     */
    public function getRegularPrice()
    {
        return $this->getData(static::REGULAR_PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setSpecialPrice($specialPrice): CreateDorisProductRequest
    {
        return $this->setData(static::SPECIAL_PRICE, $specialPrice);
    }

    /**
     * @inheritDoc
     */
    public function getSpecialPrice()
    {
        return $this->getData(static::SPECIAL_PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setDorisCategoryId($dorisCategoryId): CreateDorisProductRequest
    {
        return $this->setData(static::DORIS_CATEGORY_ID, $dorisCategoryId);
    }

    /**
     * @inheritDoc
     */
    public function getDorisCategoryId()
    {
        return $this->getData(static::DORIS_CATEGORY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setDorisCategoryName($dorisCategoryName): CreateDorisProductRequest
    {
        return $this->setData(static::DORIS_CATEGORY_NAME, $dorisCategoryName);
    }

    /**
     * @inheritDoc
     */
    public function getDorisCategoryName()
    {
        return $this->getData(static::DORIS_CATEGORY_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setDorisCategoryType($dorisCategoryType): CreateDorisProductRequest
    {
        return $this->setData(static::DORIS_CATEGORY_TYPE, $dorisCategoryType);
    }

    /**
     * @inheritDoc
     */
    public function getDorisCategoryType()
    {
        return $this->getData(static::DORIS_CATEGORY_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setSizeLabel($sizeLabel): CreateDorisProductRequest
    {
        return $this->setData(static::SIZE_LABEL, $sizeLabel);
    }

    /**
     * @inheritDoc
     */
    public function getSizeLabel()
    {
        return $this->getData(static::SIZE_LABEL);
    }

    /**
     * @inheritDoc
     */
    public function setHasStock(bool $hasStock): CreateDorisProductRequest
    {
        return $this->setData(static::HAS_STOCK, $hasStock);
    }

    /**
     * @inheritDoc
     */
    public function getHasStock(): bool
    {
        return $this->getData(static::HAS_STOCK);
    }

    /**
     * @inheritDoc
     */
    public function setParentIdentifier($parentIdentifier): CreateDorisProductRequest
    {
        return $this->setData(static::PARENT_IDENTIFIER, $parentIdentifier);
    }

    /**
     * @inheritDoc
     */
    public function getParentIdentifier()
    {
        return $this->getData(static::PARENT_IDENTIFIER);
    }

    /**
     * @inheritDoc
     */
    public function setSkuId($skuId): CreateDorisProductRequest
    {
        return $this->setData(static::SKU_ID, $skuId);
    }

    /**
     * @inheritDoc
     */
    public function getSkuId()
    {
        return $this->getData(static::SKU_ID);
    }

    /**
     * @inheritDoc
     */
    public function setInstallment($installment): CreateDorisProductRequest
    {
        return $this->setData(static::INSTALLMENT, $installment);
    }

    /**
     * @inheritDoc
     */
    public function getInstallment()
    {
        return $this->getData(static::INSTALLMENT);
    }

    /**
     * @inheritDoc
     */
    public function setInstallmentValue($installmentValue): CreateDorisProductRequest
    {
        return $this->setData(static::INSTALLMENT_VALUE, $installmentValue);
    }

    /**
     * @inheritDoc
     */
    public function getInstallmentValue()
    {
        return $this->getData(static::INSTALLMENT_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setGender($gender): CreateDorisProductRequest
    {
        return $this->setData(static::GENDER, $gender);
    }

    /**
     * @inheritDoc
     */
    public function getGender()
    {
        return $this->getData(static::GENDER);
    }

    /**
     * @inheritDoc
     */
    public function setDescription($description): CreateDorisProductRequest
    {
        return $this->setData(static::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return $this->getData(static::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setTuckInDefault($tuckInDefault): CreateDorisProductRequest
    {
        return $this->setData(static::TUCK_IN_DEFAULT, $tuckInDefault);
    }

    /**
     * @inheritDoc
     */
    public function getTuckInDefault()
    {
        return $this->getData(static::TUCK_IN_DEFAULT);
    }

    /**
     * @inheritDoc
     */
    public function setBrand($brand): CreateDorisProductRequest
    {
        return $this->setData(static::BRAND, $brand);
    }

    /**
     * @inheritDoc
     */
    public function getBrand()
    {
        return $this->getData(static::BRAND);
    }
}
