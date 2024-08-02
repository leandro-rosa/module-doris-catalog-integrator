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

use LeandroRosa\DorisCatalogIntegrator\Api\Data\DorisExportPipelineInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use LeandroRosa\DorisCatalogIntegrator\Model\ResourceModel\DorisExportPipeline as ResourceModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class DorisExportPipeline extends AbstractModel implements DorisExportPipelineInterface
{
    /**
     * @var CategoryAssociatedFactory
     */
    protected CategoryAssociatedFactory $categoryAssociatedFactory;

    /**
     * @param CategoryAssociatedFactory $categoryAssociatedFactory
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        CategoryAssociatedFactory $categoryAssociatedFactory,
        Context                   $context,
        Registry                  $registry,
        AbstractResource          $resource = null,
        AbstractDb                $resourceCollection = null,
        array                     $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->categoryAssociatedFactory = $categoryAssociatedFactory;
    }

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
    protected function _afterLoad()
    {
        $model = parent::_afterLoad();

        $associatedCategoriesData = json_decode($model->getAssociatedCategories(), true);

        if (!is_array($associatedCategoriesData)) {
            return $model;
        }

        $associatedCategories = [];
        foreach ($associatedCategoriesData as $websiteCategoryId => $data) {
            $data['website_category_id'] = $websiteCategoryId;
            $associatedCategories[] = $this->categoryAssociatedFactory->create(['data' => $data]);
        }

        $model->setAssociatedCategories($associatedCategories);

        return $model;

    }

    /**
     * @inheritDoc
     */
    public function getRunBy()
    {
        return $this->_getData(self::RUN_BY);
    }

    /**
     * @inheritDoc
     */
    public function getAssociatedCategories()
    {
        return $this->_getData(self::ASSOCIATED_CATEGORIES);
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
    public function getRunWebsiteId()
    {
        return (int)$this->_getData(self::RUN_WEBSITE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setRunBy($runBy): DorisExportPipelineInterface
    {
        return $this->setData(self::RUN_BY, $runBy);
    }

    /**
     * @inheritDoc
     */
    public function setAssociatedCategories($associatedCategories): DorisExportPipelineInterface
    {
        return $this->setData(self::ASSOCIATED_CATEGORIES, $associatedCategories);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt($createdAt): DorisExportPipelineInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt($updatedAt): DorisExportPipelineInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @inheritDoc
     */
    public function setRunWebsiteId($value): DorisExportPipelineInterface
    {
        return $this->setData(self::RUN_WEBSITE_ID, $value);
    }
}
