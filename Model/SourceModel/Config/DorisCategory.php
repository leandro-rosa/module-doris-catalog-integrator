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

use LeandroRosa\DorisCatalogIntegrator\Model\Services\DorisCategoryService;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Serialize\Serializer\Json as Serializer;

class DorisCategory extends AbstractSource
{
    const  ATTRIBUTE_TO_DISPLAY = 'name';

    /**
     * @var DorisCategoryService
     */
    protected DorisCategoryService $dorisCategoryService;

    /**
     * @var Serializer
     */
    protected Serializer $serializer;

    /**
     * @param DorisCategoryService $dorisCategoryService
     * @param Serializer $serializer
     */
    public function __construct(
        DorisCategoryService $dorisCategoryService,
        Serializer           $serializer,
    )
    {
        $this->dorisCategoryService = $dorisCategoryService;
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [['label' => 'Please Select', 'value' => '']];
            try {
                $dorisCategories = $this->dorisCategoryService->getDorisCategoryList();
            } catch (\Exception $exception) {
                $this->_options = [];
                return [];
            }

            if (empty($dorisCategories['response']['category'])) {
                $this->_options = [];
                return [];
            }

            foreach ($dorisCategories['response']['category'] as $category) {
                $this->_options[] = ['label' => $category[self::ATTRIBUTE_TO_DISPLAY], 'value' => $this->serializer->serialize($category)];
            }

        }
        return $this->_options;
    }
}
