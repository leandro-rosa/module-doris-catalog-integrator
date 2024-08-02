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

use LeandroRosa\DorisCatalogIntegrator\Api\CategoryAssociatedInterface;
use Magento\Framework\DataObject;

class CategoryAssociated extends DataObject implements CategoryAssociatedInterface
{
    /**
     * @inheritDoc
     */
    public function getWebsiteCategoryId()
    {
        return $this->getData(static::WEBSITE_CATEGORY_ID);
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
    public function getDorisCategoryName()
    {
        return $this->getData(static::DORIS_CATEGORY_NAME);
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
    public function getDorisCategoryGender()
    {
        return $this->getData(static::DORIS_CATEGORY_GENDER);
    }

    /**
     * @inheritDoc
     */
    public function setWebsiteCategoryId($value): CategoryAssociated
    {
        return $this->setData(static::WEBSITE_CATEGORY_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function setDorisCategoryId($value): CategoryAssociated
    {
        return $this->setData(static::DORIS_CATEGORY_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function setDorisCategoryName($value): CategoryAssociated
    {
        return $this->setData(static::DORIS_CATEGORY_NAME, $value);
    }

    /**
     * @inheritDoc
     */
    public function setDorisCategoryType($value): CategoryAssociated
    {
        return $this->setData(static::DORIS_CATEGORY_TYPE, $value);
    }

    /**
     * @inheritDoc
     */
    public function setDorisCategoryGender($value): CategoryAssociated
    {
        return $this->setData(static::DORIS_CATEGORY_GENDER, $value);
    }
}
