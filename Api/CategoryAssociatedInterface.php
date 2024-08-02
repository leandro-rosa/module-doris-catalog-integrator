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


interface CategoryAssociatedInterface
{
    const WEBSITE_CATEGORY_ID = 'website_category_id';
    const DORIS_CATEGORY_ID = 'doris_category_id';
    const DORIS_CATEGORY_NAME = 'doris_category_name';
    const DORIS_CATEGORY_TYPE = 'doris_category_type';
    const DORIS_CATEGORY_GENDER = 'doris_category_gender';

    /**
     * @return int|null
     */
    public function getWebsiteCategoryId();

    /**
     * @return int|null
     */
    public function getDorisCategoryId();

    /**
     * @return string|null
     */
    public function getDorisCategoryName();

    /**
     * @return string|null
     */
    public function getDorisCategoryType();

    /**
     * @return string|null
     */
    public function getDorisCategoryGender();

    /**
     * @param int $value
     *
     * @return CategoryAssociatedInterface
     */
    public function setWebsiteCategoryId($value): CategoryAssociatedInterface;

    /**
     * @param int $value
     *
     * @return CategoryAssociatedInterface
     */
    public function setDorisCategoryId($value): CategoryAssociatedInterface;

    /**
     * @param string $value
     *
     * @return CategoryAssociatedInterface
     */
    public function setDorisCategoryName($value): CategoryAssociatedInterface;

    /**
     * @param string $value
     *
     * @return CategoryAssociatedInterface
     */
    public function setDorisCategoryType($value): CategoryAssociatedInterface;

    /**
     * @param string $value
     *
     * @return CategoryAssociatedInterface
     */
    public function setDorisCategoryGender($value): CategoryAssociatedInterface;
}
