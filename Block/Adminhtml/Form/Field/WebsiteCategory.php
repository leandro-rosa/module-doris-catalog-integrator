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

use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Html\Select;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Context;

class WebsiteCategory extends Select
{
    /**
     * @var CategoryFactory
     */
    protected CategoryFactory $categoryFactory;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $categoryCollectionFactory;


    /**
     * @param Context $context
     * @param CategoryFactory $categoryFactory
     * @param CollectionFactory $categoryCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context           $context,
        CategoryFactory   $categoryFactory,
        CollectionFactory $categoryCollectionFactory,
        array             $data = []
    )
    {
        parent::__construct($context, $data);
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * @return string
     *
     * @throws LocalizedException
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * @param bool $isActive
     * @param bool $level
     * @param bool $sortBy
     * @param bool $pageSize
     *
     * @return Collection
     *
     * @throws LocalizedException
     */
    public function getCategoryCollection(
        bool $isActive = true,
        bool $level = false,
        bool $sortBy = false,
        bool $pageSize = false
    ): Collection
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        if ($isActive) {
            $collection->addIsActiveFilter();
        }

        if ($level) {
            $collection->addLevelFilter($level);
        }

        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }

        if ($pageSize) {
            $collection->setPageSize($pageSize);
        }

        return $collection;
    }

    /**
     * @return array
     *
     * @throws LocalizedException
     */
    protected function getSourceOptions(): array
    {
        $result = [];
        foreach ($this->getCategoryOptions() as $key => $value) {
            $result[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $result;
    }

    /**
     * @return array
     *
     * @throws LocalizedException
     */
    protected function getCategoryOptions(): array
    {
        $categories = $this->getCategoryCollection();
        $categoryList = [];
        foreach ($categories as $category) {
            $categoryList[$category->getEntityId()] = $this->getParentName($category->getPath()) . $category->getName();
        }

        return $categoryList;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getParentName($path): string
    {
        $parentName = '';
        $rootCats = array(1, 2);

        $catTree = explode("/", $path);
        array_pop($catTree);

        if (!$catTree || !(count($catTree) > count($rootCats))) {
            return '';
        }

        foreach ($catTree as $catId) {
            if (!in_array($catId, $rootCats)) {
                $category = $this->categoryFactory->create()->load($catId);
                $categoryName = $category->getName();
                $parentName .= $categoryName . ' -> ';
            }
        }

        return $parentName;
    }

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }
}
