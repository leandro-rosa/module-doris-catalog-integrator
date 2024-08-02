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

use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as AttributeCollectionFactory;

class ProductAttributes implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var AttributeCollectionFactory
     */
    protected AttributeCollectionFactory $attributeCollectionFactory;

    /**
     * @param AttributeCollectionFactory $attributeCollectionFactory
     */
    public function __construct(AttributeCollectionFactory $attributeCollectionFactory)
    {
        $this->attributeCollectionFactory = $attributeCollectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = [['value' => '', 'label' => __('Select Attribute')]];

        $attributes = $this->attributeCollectionFactory->create()
            ->addFieldToFilter('frontend_input', 'select')
            ->addVisibleFilter()
            ->setOrder('frontend_label', 'ASC');

        foreach ($attributes as $attribute) {
            $options[] = [
                'value' => $attribute->getAttributeCode() . '-' . $attribute->getAttributeId(),
                'label' => $attribute->getFrontendLabel(),
            ];
        }

        return $options;
    }
}
