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

namespace LeandroRosa\DorisCatalogIntegrator\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\Serialize\Serializer\Json as Serializer;


use LeandroRosa\DorisCatalogIntegrator\Model\Services\DorisCategoryService;

class DorisCategory extends Select
{
    /**
     * @var DorisCategoryService
     */
    protected DorisCategoryService $dorisCategoryService;

    /**
     * @var Serializer
     */
    protected Serializer $serializer;

    /**
     * @param Context $context
     * @param DorisCategoryService $dorisCategoryService
     * @param Serializer $serializer
     * @param array $data
     */
    public function __construct(
        Context              $context,
        DorisCategoryService $dorisCategoryService,
        Serializer           $serializer,
        array                $data = []
    )
    {
        parent::__construct($context, $data);
        $this->dorisCategoryService = $dorisCategoryService;
        $this->serializer = $serializer;
    }

    /**
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * @return array
     */
    protected function getSourceOptions(): array
    {
        try {
            $dorisCategories = $this->dorisCategoryService->getDorisCategoryList();
        } catch (\Exception $exception) {
            $dorisCategories = [];
        }

        if (empty($dorisCategories['response']['category'])) {
            return [];
        }

        $result = [];
        foreach ($dorisCategories['response']['category'] as $category) {
            $result[] = ['label' => $category['name'], 'value' => $this->serializer->serialize($category)];
        }

        return $result;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }
}
