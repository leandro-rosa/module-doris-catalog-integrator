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

use LeandroRosa\DorisCatalogIntegrator\Api\Data\DorisExportPipelineItemInterface;
use Magento\Framework\Model\AbstractModel;
use LeandroRosa\DorisCatalogIntegrator\Model\ResourceModel\DorisExportPipelineItem as ResourceModel;

class DorisExportPipelineItem extends AbstractModel implements DorisExportPipelineItemInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getPipelineId()
    {
        return (int)$this->_getData(self::PIPELINE_ID);
    }

    /**
     * @inheritDoc
     */
    public function getDorisIdentifier()
    {
        return $this->_getData(self::DORIS_IDENTIFIER);
    }

    /**
     * @inheritDoc
     */
    public function getProductId()
    {
        return (int)$this->_getData(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt()
    {
        return $this->_getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getProductParentId()
    {
        return (int)$this->_getData(self::PRODUCT_PARENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setPipelineId($pipelineId): DorisExportPipelineItemInterface
    {
        return $this->setData(self::PIPELINE_ID, $pipelineId);
    }

    /**
     * @inheritDoc
     */
    public function setDorisIdentifier($dorisIdentifier): DorisExportPipelineItemInterface
    {
        return $this->setData(self::DORIS_IDENTIFIER, $dorisIdentifier);
    }

    /**
     * @inheritDoc
     */
    public function setProductId($productId): DorisExportPipelineItemInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status): DorisExportPipelineItemInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt($createdAt): DorisExportPipelineItemInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt($updatedAt): DorisExportPipelineItemInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @inheritDoc
     */
    public function setProductParentId($productParentId): DorisExportPipelineItemInterface
    {
        return $this->setData(self::PRODUCT_PARENT_ID, $productParentId);
    }
}
