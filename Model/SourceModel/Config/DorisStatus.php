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

namespace LeandroRosa\DorisCatalogIntegrator\Model\SourceModel\Config;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class DorisStatus extends AbstractSource
{
    /**
     * @return array|array[]|null
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => 'PENDING', 'label' => __('Pending')],
                ['value' => 'PROCESSING', 'label' => __('Processing')],
                ['value' => 'PROCESSED', 'label' => __('Processed')],
                ['value' => 'PROCESSED_ERROR', 'label' => __('Processed Error')]
            ];
        }
        return $this->_options;
    }
}
