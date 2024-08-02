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

namespace LeandroRosa\DorisCatalogIntegrator\Helper;


use LeandroRosa\DorisCatalogIntegrator\Model\CategoryAssociatedFactory;
use LeandroRosa\DorisCatalogIntegrator\Api\CategoryAssociatedInterface;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class DorisCatalogIntegratorConfiguration extends AbstractHelper
{
    const DORIS_CATEGORIES_ASSOCIATION_PATH = 'doris_catalog_integrator/categories_association/association_map';
    const PRODUCT_SIZE_ATTRIBUTE_PATH = 'doris_catalog_integrator/product_attributes/size';
    const PRODUCT_COLOR_ATTRIBUTE_PATH = 'doris_catalog_integrator/product_attributes/color';
    const PRODUCT_BRAND_ATTRIBUTE_PATH = 'doris_catalog_integrator/product_attributes/brand';

    /**
     * @var CategoryAssociatedFactory
     */
    protected CategoryAssociatedFactory $categoryAssociatedFactory;

    /**
     * @param Context $context
     * @param CategoryAssociatedFactory $categoryAssociatedFactory
     */
    public function __construct(
        Context                   $context,
        CategoryAssociatedFactory $categoryAssociatedFactory
    )
    {
        parent::__construct($context);
        $this->categoryAssociatedFactory = $categoryAssociatedFactory;
    }

    /**
     * @param string|null $scopeType
     * @param string|null $scopeCode
     *
     * @return array|null
     */
    public function getSizeAttribute($scopeType = 'website', $scopeCode = null): ?array
    {
        return $this->getAttribute(static::PRODUCT_SIZE_ATTRIBUTE_PATH, $scopeType, $scopeCode);
    }

    /**
     * @param string|null $scopeType
     * @param string|null $scopeCode
     *
     * @return array|null
     */
    public function getColorAttribute($scopeType = 'website', $scopeCode = null): ?array
    {
        return $this->getAttribute(static::PRODUCT_COLOR_ATTRIBUTE_PATH, $scopeType, $scopeCode);
    }

    /**
     * @param string|null $scopeType
     * @param string|null $scopeCode
     *
     * @return array|null
     */
    public function getBrandAttribute($scopeType = 'website', $scopeCode = null): ?array
    {
        return $this->getAttribute(static::PRODUCT_BRAND_ATTRIBUTE_PATH, $scopeType, $scopeCode);
    }


    /**
     * @param ?string $scopeType
     * @param ?string $scopeCode
     *
     * @return CategoryAssociatedInterface[]
     */
    public function getCategoriesAssociation($scopeType = 'website', $scopeCode = null): array
    {
        $configValue = $this->scopeConfig->getValue(static::DORIS_CATEGORIES_ASSOCIATION_PATH, $scopeType, $scopeCode);
        $categoriesAssociated = $this->parseCategoriesAssociatedConfig($configValue);

        $result = [];
        foreach ($categoriesAssociated as $association) {
            $categoryAssociated = $this->categoryAssociatedFactory->create();
            $categoryAssociated->setWebsiteCategoryId($association['website_category_id']);
            $categoryAssociated->setDorisCategoryId($association['doris_category']['id']);
            $categoryAssociated->setDorisCategoryName($association['doris_category']['name']);
            $categoryAssociated->setDorisCategoryType($association['doris_category']['type']);
            $categoryAssociated->setDorisCategoryGender($association['doris_category']['doris_gender']);
            $result[$association['website_category_id']] = $categoryAssociated;
        }

        return $result;
    }

    /**
     * @param string|null $value
     *
     * @return array
     */
    public function parseCategoriesAssociatedConfig(?string $value): array
    {
        $categoriesAssociated = json_decode((string)$value, true);
        if (empty($categoriesAssociated)) {
            return [];
        }

        $result = [];
        foreach ($categoriesAssociated as $websiteCategoryId => $association) {
            $result[$websiteCategoryId]['website_category_id'] = $websiteCategoryId;
            $result[$websiteCategoryId]['doris_category'] = $association;
        }

        return $result;
    }

    /**
     * @param string $attributePath
     * @param string|null $scopeType
     * @param string|null $scopeCode
     *
     * @return array|null
     */
    protected function getAttribute(string $attributePath, $scopeType = 'website', $scopeCode = null): ?array
    {
        $attributeConfig = $this->scopeConfig->getValue($attributePath, $scopeType, $scopeCode);
        $attribute = explode('-', (string)$attributeConfig);

        if (count($attribute) < 2) {
            return null;
        }
        return empty($attribute) ? null : ['attribute_id' => $attribute[1], 'attribute_code' => $attribute[0]];
    }
}
