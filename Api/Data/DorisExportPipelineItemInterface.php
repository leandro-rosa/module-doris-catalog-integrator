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

interface DorisExportPipelineItemInterface
{
    const ENTITY_ID = 'entity_id';
    const PIPELINE_ID = 'pipeline_id';
    const DORIS_IDENTIFIER = 'doris_identifier';
    const PRODUCT_ID = 'product_id';
    const PRODUCT_PARENT_ID = 'product_parent_id';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @return int|null
     */
    public function getEntityId();

    /**
     * @return int|null
     */
    public function getPipelineId();

    /**
     * @return string|null
     */
    public function getDorisIdentifier();

    /**
     * @return int|null
     */
    public function getProductId();

    /**
     * @return string|null
     */
    public function getStatus();

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
    public function getProductParentId();

    /**
     * @param int $entityId
     *
     * @return self
     */
    public function setEntityId($entityId);

    /**
     * @param int $pipelineId
     *
     * @return self
     */
    public function setPipelineId($pipelineId): self;

    /**
     * @param string $dorisIdentifier
     *
     * @return self
     */
    public function setDorisIdentifier($dorisIdentifier): self;

    /**
     * @param int $productId
     *
     * @return self
     */
    public function setProductId($productId): self;

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus($status): self;

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
     * @param int $productParentId
     *
     * @return self
     */
    public function setProductParentId($productParentId): self;
}
