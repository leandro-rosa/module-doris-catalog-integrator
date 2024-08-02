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

namespace LeandroRosa\DorisCatalogIntegrator\Model\ResourceModel\DorisExportPipelineItem;


use LeandroRosa\DorisCatalogIntegrator\Model\DorisExportPipelineItem as DorisExportPipelineItemModel;
use LeandroRosa\DorisCatalogIntegrator\Model\ResourceModel\DorisExportPipelineItem as DorisExportPipelineItemResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(DorisExportPipelineItemModel::class, DorisExportPipelineItemResourceModel::class);
    }
}
