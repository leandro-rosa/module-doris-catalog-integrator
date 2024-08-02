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

use LeandroRosa\DorisCatalogIntegrator\Api\Data\DorisExportPipelineInterface;

interface CatalogIntegratorApiInterface
{
    /**
     * @param int $pipelineId
     *
     * @return array
     */
    public function createDorisProduct($pipelineId);

    /**
     * @param CreateExportPipelineParamsInterface $pipeline
     *
     * @return DorisExportPipelineInterface
     */
    public function createPipeline(CreateExportPipelineParamsInterface $pipeline): DorisExportPipelineInterface;

    /**
     * @return string
     */
    public function flushPipelines(): string;
}
