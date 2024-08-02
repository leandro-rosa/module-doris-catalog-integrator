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

namespace LeandroRosa\DorisCatalogIntegrator\Model\Builds;

use LeandroRosa\Core\Api\GenericBuildInterface;
use LeandroRosa\Core\Api\GenericCommandInterface;

class GetDorisCategoryListResponseBuild implements GenericBuildInterface
{
    /**
     * @inheritDoc
     */
    public function build(array $subject = [])
    {
        return $subject;
    }
}
