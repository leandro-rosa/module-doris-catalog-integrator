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

use LeandroRosa\DorisCatalogIntegrator\Api\CategoryAssociatedInterface;
use LeandroRosa\DorisCatalogIntegrator\Helper\DorisCatalogIntegratorConfiguration;
use LeandroRosa\DorisCatalogIntegrator\Model\CreateDorisProductRequestFactory;

use LeandroRosa\DorisCatalogIntegrator\Model\Repositories\DorisExportPipelineItemRepository;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\InventoryApi\Api\Data\SourceItemInterface;
use Magento\InventoryApi\Api\SourceItemRepositoryInterface;
use Magento\InventoryApi\Api\StockRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Website;
use Psr\Log\LoggerInterface;

class CreateDorisProductRequestBuild
{
    /**
     * @var CreateDorisProductRequestFactory
     */
    protected CreateDorisProductRequestFactory $requestFactory;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var DorisCatalogIntegratorConfiguration
     */
    protected DorisCatalogIntegratorConfiguration $catalogIntegratorConfig;

    /**
     * @var DorisExportPipelineItemRepository
     */
    protected DorisExportPipelineItemRepository $dorisExportPipelineItemRepository;

    /**
     * @var StockRepositoryInterface
     */
    protected StockRepositoryInterface $stockRepository;

    /**
     * @var SourceItemRepositoryInterface
     */
    protected SourceItemRepositoryInterface $sourceItemRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param CreateDorisProductRequestFactory $requestFactory
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param DorisCatalogIntegratorConfiguration $catalogIntegratorConfig
     * @param DorisExportPipelineItemRepository $dorisExportPipelineItemRepository
     * @param StockRepositoryInterface $stockRepository
     * @param SourceItemRepositoryInterface $sourceItemRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CreateDorisProductRequestFactory    $requestFactory,
        StoreManagerInterface               $storeManager,
        LoggerInterface                     $logger,
        DorisCatalogIntegratorConfiguration $catalogIntegratorConfig,
        DorisExportPipelineItemRepository   $dorisExportPipelineItemRepository,
        StockRepositoryInterface            $stockRepository,
        SourceItemRepositoryInterface       $sourceItemRepository,
        SearchCriteriaBuilder               $searchCriteriaBuilder
    )
    {
        $this->requestFactory = $requestFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->catalogIntegratorConfig = $catalogIntegratorConfig;
        $this->dorisExportPipelineItemRepository = $dorisExportPipelineItemRepository;
        $this->stockRepository = $stockRepository;
        $this->sourceItemRepository = $sourceItemRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param array $products
     * @param Product $configurableProduct
     * @param int|string $pipelineId
     * @param int|string $websiteId
     *
     * @return array
     *
     * @throws LocalizedException
     * @throws \Magento\Framework\Exception\InvalidArgumentException
     */
    public function buildRequest(array $products, Product $configurableProduct, $pipelineId, $websiteId): array
    {
        $colorAttribute = $this->catalogIntegratorConfig->getColorAttribute('website', $websiteId);
        $sizeAttribute = $this->catalogIntegratorConfig->getSizeAttribute('website', $websiteId);

        if (empty($colorAttribute || empty($sizeAttribute))) {
            $this->logger->error(
                'Attributes color and size are not configured.',
                [
                    'website' => $websiteId,
                    'color_attribute' => $colorAttribute,
                    'size_attribute' => $sizeAttribute,
                ]
            );
            throw new LocalizedException(__('Attributes color and size are not configured.'));
        }

        $brandAttribute = $this->catalogIntegratorConfig->getBrandAttribute('website', $websiteId);

        $requests = [];
        foreach ($products as $product) {
            $isAlreadyExported = $this->dorisExportPipelineItemRepository->getItemByProductId($product->getId());
            if (!empty($isAlreadyExported)) {
                continue;
            }

            $request = $this->requestFactory->create();

            $colorOptionId = $product->getData($colorAttribute['attribute_code']);
            if (!$colorOptionId) {
                $this->logger->warning(
                    'Skip Sku because color attribute is empty',
                    [
                        'parent_id' => $configurableProduct->getId(),
                        'parent_sku' => $configurableProduct->getSku(),
                        'variation_sku' => $product->getSku(),
                        'variation_id' => $product->getId()
                    ]
                );
                continue;
            }
            $colorOptionValue = $product->getResource()->getAttribute($colorAttribute['attribute_code'])->getSource()->getOptionText($colorOptionId);

            $sizeOptionId = $product->getData($sizeAttribute['attribute_code']);
            if (!$sizeOptionId) {
                $this->logger->warning(
                    'Skip Sku because size attribute is empty',
                    [
                        'parent_id' => $configurableProduct->getId(),
                        'parent_sku' => $configurableProduct->getSku(),
                        'variation_sku' => $product->getSku(),
                        'variation_id' => $product->getId()
                    ]
                );
                continue;
            }

            $sizeOptionValue = $product->getResource()->getAttribute($sizeAttribute['attribute_code'])->getSource()->getOptionText($sizeOptionId);


            $dorisCategory = $this->getDorisCategoryAssociationByProduct($configurableProduct, $websiteId);

            if (!$dorisCategory) {
                $this->logger->warning(
                    'Skip Sku because product has not doris category associated',
                    [
                        'parent_id' => $configurableProduct->getId(),
                        'parent_sku' => $configurableProduct->getSku(),
                        'variation_sku' => $product->getSku(),
                        'variation_id' => $product->getId()
                    ]
                );
                continue;
            }

            $request->setName($configurableProduct->getName() ?? $product->getName());
            $request->setIdentifier("{$configurableProduct->getSku()}-$colorOptionValue");
            $request->setUrl($configurableProduct->getProductUrl());
            $request->setImageUrls($this->getProductImages($product));
            $regularPrice = $configurableProduct->getPrice() ? ((float)$configurableProduct->getPrice()) * 100 : ((float)$product->getPrice() * 100);
            $request->setRegularPrice((int)$regularPrice);
            $specialPrice = $configurableProduct->getFinalPrice() ? ((float)$configurableProduct->getFinalPrice()) * 100 : ((float)$product->getFinalPrice() * 100);
            $request->setSpecialPrice((int)$specialPrice);

            $request->setDorisCategoryId($dorisCategory->getDorisCategoryId());
            $request->setDorisCategoryName($dorisCategory->getDorisCategoryName());
            $request->setDorisCategoryType($dorisCategory->getDorisCategoryType());
            $request->setGender($dorisCategory->getDorisCategoryGender());

            $request->setSizeLabel($sizeOptionValue);
            $stockItem = $this->getProductStock($product);

            $request->setHasStock($stockItem->getQuantity() > 0);
            $request->setParentIdentifier($configurableProduct->getSku());
            $request->setSkuId($product->getSku());

            $brandOptionValue = 'n/a';
            if (!empty($brandAttribute)) {
                $brandOptionId = $configurableProduct->getData($brandAttribute['attribute_code']);
                if ($brandOptionId) {
                    $brandOptionValue = $configurableProduct->getResource()->getAttribute($brandAttribute['attribute_code'])->getSource()->getOptionText($brandOptionId) ?? 'n/a';
                }
            }

            $request->setBrand($brandOptionValue);
            $requests["{$configurableProduct->getId()}-{$product->getId()}"] = $request->getData();
        }

        return $requests;
    }

    /**
     * @param Product $product
     * @param $websiteId
     * @return CategoryAssociatedInterface|null
     */
    public function getDorisCategoryAssociationByProduct(Product $product, $websiteId = null): ?CategoryAssociatedInterface
    {
        $categoriesAssociated = $this->catalogIntegratorConfig->getCategoriesAssociation('website', $websiteId);
        foreach ($categoriesAssociated as $websiteCategoryId => $dorisCategory) {
            if (in_array($websiteCategoryId, $product->getAvailableInCategories())) {
                return $dorisCategory;
            }
        }

        return null;
    }

    /**
     * @param Product $product
     *
     * @return array
     */
    protected function getProductImages(Product $product): array
    {
        $images = [];
        foreach ($product->getMediaGalleryImages() as $image) {
            try {
                $images[] = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $image->getFile();;
//                $images[] = 'https://doris-development-magento2.s3.us-east-2.amazonaws.com/catalog/product' . $image->getFile();;
            } catch (\Exception $exception) {
                $this->logger->warning(
                    'Error fetching image URL',
                    [
                        'error_message' => $exception->getMessage(),
                        'error_file' => $exception->getFile() . ':' . $exception->getLine(),
                        'images' => $images,
                        'image_failed' => $image->getData()
                    ]
                );
                continue;
            }
        }

        return $images;
    }

    /**
     * @param Product $product
     *
     * @return SourceItemInterface
     */
    protected function getProductStock(Product $product)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('sku', $product->getSku())
            ->addFilter('source_code', 'default')
            ->create();

        $items = $this->sourceItemRepository->getList($searchCriteria)->getItems();
        return reset($items);
    }
}
