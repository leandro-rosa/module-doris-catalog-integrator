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


interface CreateDorisProductRequestInterface
{
    const NAME = 'name';
    const IDENTIFIER = 'identifier';
    const URL = 'url';
    const IMAGE_URLS = 'image_urls';
    const REGULAR_PRICE = 'regular_price';
    const SPECIAL_PRICE = 'special_price';
    const DORIS_CATEGORY_ID = 'doris_category_id';
    const DORIS_CATEGORY_NAME = 'doris_category_name';
    const DORIS_CATEGORY_TYPE = 'doris_category_type';
    const SIZE_LABEL = 'size_label';
    const HAS_STOCK = 'has_stock';
    const PARENT_IDENTIFIER = 'parent_identifier';
    const SKU_ID = 'sku_id';
    const INSTALLMENT = 'installment';
    const INSTALLMENT_VALUE = 'installment_value';
    const GENDER = 'gender';
    const DESCRIPTION = 'description';
    const TUCK_IN_DEFAULT = 'tuck_in_default';
    const BRAND = 'brand';

    /**
     * Set product name
     *
     * @param ?string $name
     * @return $this
     */
    public function setName($name): CreateDorisProductRequestInterface;

    /**
     * Get product name
     *
     * @return string
     */
    public function getName();

    /**
     * Set product identifier
     *
     * @param ?string $identifier
     * @return $this
     */
    public function setIdentifier($identifier): CreateDorisProductRequestInterface;

    /**
     * Get product identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Set product URL
     *
     * @param ?string $url
     * @return $this
     */
    public function setUrl($url): CreateDorisProductRequestInterface;

    /**
     * Get product URL
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set image URLs
     *
     * @param array|string $imageUrls
     * @return $this
     */
    public function setImageUrls($imageUrls): CreateDorisProductRequestInterface;

    /**
     * Get image URLs
     *
     * @return array
     */
    public function getImageUrls();

    /**
     * Set regular price
     *
     * @param ?int $regularPrice
     * @return $this
     */
    public function setRegularPrice($regularPrice): CreateDorisProductRequestInterface;

    /**
     * Get regular price
     *
     * @return int
     */
    public function getRegularPrice();

    /**
     * Set special price
     *
     * @param ?int $specialPrice
     * @return $this
     */
    public function setSpecialPrice($specialPrice): CreateDorisProductRequestInterface;

    /**
     * Get special price
     *
     * @return int
     */
    public function getSpecialPrice();

    /**
     * Set Doris category ID
     *
     * @param ?int $dorisCategoryId
     * @return $this
     */
    public function setDorisCategoryId($dorisCategoryId): CreateDorisProductRequestInterface;

    /**
     * Get Doris category ID
     *
     * @return int
     */
    public function getDorisCategoryId();

    /**
     * Set Doris category name
     *
     * @param ?string $dorisCategoryName
     * @return $this
     */
    public function setDorisCategoryName($dorisCategoryName): CreateDorisProductRequestInterface;

    /**
     * Get Doris category name
     *
     * @return string
     */
    public function getDorisCategoryName();

    /**
     * Set Doris category type
     *
     * @param ?string $dorisCategoryType
     * @return $this
     */
    public function setDorisCategoryType($dorisCategoryType): CreateDorisProductRequestInterface;

    /**
     * Get Doris category type
     *
     * @return string
     */
    public function getDorisCategoryType();

    /**
     * Set size label
     *
     * @param ?string $sizeLabel
     * @return $this
     */
    public function setSizeLabel($sizeLabel): CreateDorisProductRequestInterface;

    /**
     * Get size label
     *
     * @return string
     */
    public function getSizeLabel();

    /**
     * Set has stock
     *
     * @param ?bool $hasStock
     * @return $this
     */
    public function setHasStock(bool $hasStock): CreateDorisProductRequestInterface;

    /**
     * Get has stock
     *
     * @return bool
     */
    public function getHasStock();

    /**
     * Set parent identifier
     *
     * @param ?string $parentIdentifier
     * @return $this
     */
    public function setParentIdentifier($parentIdentifier): CreateDorisProductRequestInterface;

    /**
     * Get parent identifier
     *
     * @return string
     */
    public function getParentIdentifier();

    /**
     * Set SKU ID
     *
     * @param ?string $skuId
     * @return $this
     */
    public function setSkuId($skuId): CreateDorisProductRequestInterface;

    /**
     * Get SKU ID
     *
     * @return int
     */
    public function getSkuId();

    /**
     * Set installment
     *
     * @param ?int $installment
     * @return $this
     */
    public function setInstallment($installment): CreateDorisProductRequestInterface;

    /**
     * Get installment
     *
     * @return int
     */
    public function getInstallment();

    /**
     * Set installment value
     *
     * @param ?float $installmentValue
     * @return $this
     */
    public function setInstallmentValue($installmentValue): CreateDorisProductRequestInterface;

    /**
     * Get installment value
     *
     * @return float
     */
    public function getInstallmentValue();

    /**
     * Set gender
     *
     * @param ?string $gender
     * @return $this
     */
    public function setGender($gender): CreateDorisProductRequestInterface;

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender();

    /**
     * Set description
     *
     * @param ?string $description
     * @return $this
     */
    public function setDescription($description): CreateDorisProductRequestInterface;

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set tuck in default
     *
     * @param ?string $tuckInDefault
     * @return $this
     */
    public function setTuckInDefault($tuckInDefault): CreateDorisProductRequestInterface;

    /**
     * Get tuck in default
     *
     * @return string
     */
    public function getTuckInDefault();

    /**
     * Set brand
     *
     * @param ?string $brand
     * @return $this
     */
    public function setBrand($brand): CreateDorisProductRequestInterface;

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand();
}
