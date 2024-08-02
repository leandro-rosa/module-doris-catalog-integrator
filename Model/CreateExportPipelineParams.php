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

use LeandroRosa\DorisCatalogIntegrator\Api\CreateExportPipelineParamsInterface;
use Magento\Framework\DataObject;

class CreateExportPipelineParams extends DataObject implements CreateExportPipelineParamsInterface
{
    /**
     * @inheritDoc
     */
    public function setRunBy ($value): CreateExportPipelineParamsInterface
    {
        return $this->setData(static::RUN_BY_PARAM, $value);
    }

    /**
     * @inheritDoc
     */
    public function getRunBy(): string
    {
        return $this->_getData(static::RUN_BY_PARAM);
    }
}
