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

namespace LeandroRosa\DorisCatalogIntegrator\Model\SourceModel\Config\Backend;

use LeandroRosa\DorisCatalogIntegrator\Helper\DorisCatalogIntegratorConfiguration;
use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;

class CategoriesAssociation extends ArraySerialized
{
    /**
     * @var DorisCatalogIntegratorConfiguration
     */
    protected DorisCatalogIntegratorConfiguration $catalogIntegratorConfig;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param DorisCatalogIntegratorConfiguration $catalogIntegratorConfig
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param Json|null $serializer
     */
    public function __construct(
        Context                             $context,
        Registry                            $registry,
        ScopeConfigInterface                $config,
        TypeListInterface                   $cacheTypeList,
        DorisCatalogIntegratorConfiguration $catalogIntegratorConfig,
        AbstractResource                    $resource = null,
        AbstractDb                          $resourceCollection = null,
        array                               $data = [],
        Json                                $serializer = null
    )
    {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data, $serializer);
        $this->catalogIntegratorConfig = $catalogIntegratorConfig;
    }

    /**
     * @inheritDoc
     */
    protected function _afterLoad()
    {
        $value = $this->catalogIntegratorConfig->parseCategoriesAssociatedConfig($this->getValue());
        $this->setValue($value);
    }

    /**
     * @inheritDoc
     *
     * @return CategoriesAssociation
     *
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        $categoriesAssociation = $this->getValue();

        if (!is_array($categoriesAssociation)) {
            throw new LocalizedException(__('Invalid category association data·'));
        }

        if (in_array('__empty', $categoriesAssociation)) {
            unset($categoriesAssociation['__empty']);
        }

        $values = [];
        foreach ($categoriesAssociation as $association) {
            if (empty($association['website_category']) || empty($association['doris_category'])) {
                $this->_logger->warning(
                    'website_category or doris_category is empty',
                    ['category_association' => $association]
                );
                continue;
            }
            $websiteCategoryId = $association['website_category'];
            $dorisCategory = json_decode($association['doris_category'], true);
            $dorisCategory['doris_gender'] = $association['doris_gender'];
            if (!empty($values[$websiteCategoryId])) {
                $this->_logger->warning(
                    'Please associate the same website category only once.',
                    ['current_association' => $association, 'values' => $categoriesAssociation]
                );
                throw new LocalizedException(__('Please associate the same website category only once.'));
            }

            $values[$websiteCategoryId] = $dorisCategory;

        }

        $valueSerialized = \json_encode($values);
        $this->setValue($valueSerialized);
        return parent::beforeSave();
    }
}
