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

namespace LeandroRosa\DorisCatalogIntegrator\Api\Data;

use LeandroRosa\DorisCatalogIntegrator\Api\CategoryAssociatedInterface;

interface DorisExportPipelineInterface
{
    const ENTITY_ID = 'entity_id';
    const RUN_BY = 'run_by';
    const STATUS = 'status';
    const ASSOCIATED_CATEGORIES = 'associated_categories';
    const RUN_WEBSITE_ID = 'run_website_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @return int|null
     */
    public function getEntityId();

    /**
     * @return string|null
     */
    public function getRunBy();

    /**
     * @return string|CategoryAssociatedInterface[]|null
     */
    public function getAssociatedCategories();

    /**
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * @return int|null
     */
    public function getRunWebsiteId();

    /**
     * @param int $entityId
     *
     * @return self
     */
    public function setEntityId($entityId);

    /**
     * @param string $runBy
     *
     * @return self
     */
    public function setRunBy($runBy): self;

    /**
     * @param string|CategoryAssociatedInterface[] $associatedCategories
     *
     * @return self
     */
    public function setAssociatedCategories($associatedCategories): self;

    /**
     * @param string $createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt): self;

    /**
     * @param string $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt): self;

    /**
     * @param int $value
     *
     * @return self
     */
    public function setRunWebsiteId($value): self;
}
