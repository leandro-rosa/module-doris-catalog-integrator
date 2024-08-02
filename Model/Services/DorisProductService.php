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

namespace LeandroRosa\DorisCatalogIntegrator\Model\Services;


use LeandroRosa\DorisCatalogIntegrator\Api\Data\DorisExportPipelineInterface;
use LeandroRosa\DorisCatalogIntegrator\Helper\DorisCatalogIntegratorConfiguration;
use LeandroRosa\DorisCatalogIntegrator\Model\Builds\CreateDorisProductRequestBuild;
use LeandroRosa\DorisCatalogIntegrator\Model\Builds\UpdateDorisProductPriceStockResponseBuildFactory;
use LeandroRosa\DorisCatalogIntegrator\Model\Builds\CreateDorisProductResponseBuildFactory;
use LeandroRosa\DorisCatalogIntegrator\Model\Builds\UpdateDorisProductPriceStockRequestBuild;
use LeandroRosa\DorisCatalogIntegrator\Model\CreateDorisProductRequest;
use LeandroRosa\DorisCatalogIntegrator\Model\Repositories\DorisExportPipelineRepository;
use LeandroRosa\DorisCatalogIntegrator\Model\Repositories\DorisExportPipelineItemRepository;
use LeandroRosa\DorisCatalogIntegrator\Model\ResourceModel\DorisExportPipelineItem as DorisExportPipelineItemResourceModel;
use LeandroRosa\Core\Api\ClientInterface;
use LeandroRosa\Core\Helper\DorisCoreConfiguration;
use LeandroRosa\Core\Http\TransferFactory;
use LeandroRosa\DorisCatalogIntegrator\Api\Data\DorisExportPipelineItemInterface as DorisExportPipelineItemModel;

use LeandroRosa\DorisCatalogIntegrator\Model\UpdateDorisProductPriceStockRequest;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Catalog\Model\ResourceModel\Product\Relation as ProductRelation;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json as Serializer;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Psr\Log\LoggerInterface;

class DorisProductService
{
    const PAGE_SIZE = 1;

    /**
     * @var CreateDorisProductRequestBuild
     */
    protected CreateDorisProductRequestBuild $createProductDorisRequestBuild;

    /**
     * @var CreateDorisProductResponseBuildFactory
     */
    protected CreateDorisProductResponseBuildFactory $createProductDorisResponseBuildFactory;

    /**
     * @var UpdateDorisProductPriceStockResponseBuildFactory
     */
    protected UpdateDorisProductPriceStockResponseBuildFactory $updateDorisProductPriceStockResponseBuildFactory;

    /**
     * @var ProductCollectionFactory
     */
    protected ProductCollectionFactory $productCollectionFactory;

    /**
     * @var TransferFactory
     */
    protected TransferFactory $transferFactory;

    /**
     * @var ClientInterface
     */
    protected ClientInterface $httpClient;

    /**
     * @var DorisCoreConfiguration
     */
    protected DorisCoreConfiguration $setupConfig;

    /**
     * @var DorisCatalogIntegratorConfiguration
     */
    protected DorisCatalogIntegratorConfiguration $catalogIntegratorConfig;

    /**
     * @var Serializer
     */
    protected Serializer $serializer;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var DorisExportPipelineRepository
     */
    protected DorisExportPipelineRepository $dorisExportPipelineRepository;

    /**
     * @var DorisExportPipelineItemRepository
     */
    protected DorisExportPipelineItemRepository $dorisExportPipelineItemRepository;

    /**
     * @var UpdateDorisProductPriceStockRequestBuild
     */
    protected UpdateDorisProductPriceStockRequestBuild $updateDorisProductPriceStockRequestBuild;

    /**
     * @var ProductRelation
     */
    protected ProductRelation $productRelation;

    /**
     * @param CreateDorisProductRequestBuild $createProductDorisRequestBuild
     * @param CreateDorisProductResponseBuildFactory $createProductDorisResponseBuildFactory
     * @param ProductCollectionFactory $productCollectionFactory
     * @param TransferFactory $transferFactory
     * @param ClientInterface $httpClient
     * @param DorisCoreConfiguration $setupConfig
     * @param DorisCatalogIntegratorConfiguration $catalogIntegratorConfig
     * @param DorisExportPipelineRepository $dorisExportPipelineRepository
     * @param DorisExportPipelineItemRepository $dorisExportPipelineItemRepository
     * @param Serializer $serializer
     * @param ProductRelation $productRelation
     * @param LoggerInterface $logger
     * @param UpdateDorisProductPriceStockRequestBuild $updateDorisProductPriceStockRequestBuild
     * @param UpdateDorisProductPriceStockResponseBuildFactory $updateDorisProductPriceStockResponseBuildFactory
     */
    public function __construct(
        CreateDorisProductRequestBuild                   $createProductDorisRequestBuild,
        CreateDorisProductResponseBuildFactory           $createProductDorisResponseBuildFactory,
        ProductCollectionFactory                         $productCollectionFactory,
        TransferFactory                                  $transferFactory,
        ClientInterface                                  $httpClient,
        DorisCoreConfiguration                           $setupConfig,
        DorisCatalogIntegratorConfiguration              $catalogIntegratorConfig,
        DorisExportPipelineRepository                    $dorisExportPipelineRepository,
        DorisExportPipelineItemRepository                $dorisExportPipelineItemRepository,
        Serializer                                       $serializer,
        ProductRelation                                  $productRelation,
        LoggerInterface                                  $logger,
        UpdateDorisProductPriceStockRequestBuild         $updateDorisProductPriceStockRequestBuild,
        UpdateDorisProductPriceStockResponseBuildFactory $updateDorisProductPriceStockResponseBuildFactory
    )
    {
        $this->createProductDorisRequestBuild = $createProductDorisRequestBuild;
        $this->updateDorisProductPriceStockResponseBuildFactory = $updateDorisProductPriceStockResponseBuildFactory;
        $this->createProductDorisResponseBuildFactory = $createProductDorisResponseBuildFactory;
        $this->updateDorisProductPriceStockRequestBuild = $updateDorisProductPriceStockRequestBuild;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->transferFactory = $transferFactory;
        $this->httpClient = $httpClient;
        $this->setupConfig = $setupConfig;
        $this->catalogIntegratorConfig = $catalogIntegratorConfig;
        $this->serializer = $serializer;
        $this->logger = $logger;
        $this->dorisExportPipelineRepository = $dorisExportPipelineRepository;
        $this->dorisExportPipelineItemRepository = $dorisExportPipelineItemRepository;
        $this->productRelation = $productRelation;
    }

    /**
     * @param int $websiteId
     * @param int $pipelineId
     * @param int $page
     * @return array
     *
     * @throws LocalizedException
     */
    public function getProductsRequest($websiteId, $pipelineId, $page = 1): array
    {
        $colorAttribute = $this->catalogIntegratorConfig->getColorAttribute('website', $websiteId);
        $sizeAttribute = $this->catalogIntegratorConfig->getSizeAttribute('website', $websiteId);

        if (empty($colorAttribute || empty($sizeAttribute))) {
            $this->logger->error(
                'Attributes color and size are not configured.',
                [
                    'website_id' => $websiteId,
                    'color_attribute' => $colorAttribute,
                    'size_attribute' => $sizeAttribute,
                ]
            );

            return [];
        }

        $collection = $this->getProductWihCategoriesAssociated($websiteId, $page);

        $requests = [];
        foreach ($collection as $configurableProduct) {
            $simpleProductList = $configurableProduct->getTypeInstance()->getUsedProducts($configurableProduct);
            $productSplitByColor = [];

            foreach ($simpleProductList as $simpleProduct) {
                $productSplitByColor[$simpleProduct->getData($colorAttribute['attribute_code'])][$simpleProduct->getData($sizeAttribute['attribute_code'])] = $simpleProduct;
            }

            foreach ($productSplitByColor as $productColorList) {
                try {
                    $request = $this->createProductDorisRequestBuild->buildRequest($productColorList, $configurableProduct, $pipelineId, $websiteId);
                    if (!empty($request)) {
                        $requests[] = $request;
                    }
                } catch (\Exception $exception) {
                    $this->logger->error(
                        'Error to build create product doris request',
                        [
                            'website_id' => $websiteId,
                            'error_message' => $exception->getMessage(),
                            'error_file' => $exception->getFile() . ':' . $exception->getLine(),
                            'sku' => $configurableProduct->getSku(),
                        ]
                    );

                    continue;
                }
            }
        }

        return $requests;
    }

    /**
     * @return \Magento\Framework\Api\SearchResultsInterface
     *
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\InvalidArgumentException
     */

    public function flushPipelines()
    {
        $pipelines = $this->dorisExportPipelineRepository->getList()->getItems();
        foreach ($pipelines as $pipeline) {
            $this->dorisExportPipelineRepository->delete($pipeline);
        }

        return $pipelines;
    }

    public function createDorisProduct($pipelineId, $websiteId, $page = 1): array
    {
        $requests = $this->getProductsRequest($websiteId, $pipelineId, $page);
        $responseList = [];
        foreach ($requests as $requestProduct) {
            foreach ($requestProduct as $productIds => $request) {
                $transfer = $this->transferFactory->create();
                $transfer->setUri("{$this->setupConfig->getUri('website', $websiteId)}/pub/product")
                    ->setOptions([
                        'headers' => [
                            'User-Agent' => 'module-magento2',
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            'doris-api-key' => $this->setupConfig->getDorisApiKey('website', $websiteId),
                            'doris-secret-key' => $this->setupConfig->getDorisSecretKey('website', $websiteId),
                        ],
                        'body' => $this->serializer->serialize($request)
                    ])
                    ->setMethod('POST');

                $responseBuild = $this->createProductDorisResponseBuildFactory->create();
                $itemIds = explode('-', $productIds);
                if (count($itemIds) !== 2) {
                    $this->logger->error(
                        'Error to get product IDS',
                        [
                            'website_id' => $websiteId,
                            'product_ids' => $productIds,
                            'request' => $request,
                            'transfer' => $transfer->getData()
                        ]
                    );
                    continue;
                }
                try {
                    $responseList[] = $this->httpClient->placeRequest($transfer, $responseBuild);
                    $this->dorisExportPipelineItemRepository->save([
                        'pipeline_id' => $pipelineId,
                        'doris_identifier' => $request['identifier'],
                        'product_id' => $itemIds[1],
                        'product_parent_id' => $itemIds[0],
                        'status' => 'PENDING',
                    ]);
                } catch (\Exception $exception) {
                    $this->dorisExportPipelineItemRepository->save([
                        'pipeline_id' => $pipelineId,
                        'doris_identifier' => $request['identifier'],
                        'product_id' => $itemIds[1],
                        'product_parent_id' => $itemIds[0],
                        'status' => 'EXPORT_ERROR',
                    ]);
                    $this->logger->error(
                        'Error to create product doris request',
                        [
                            'website_id' => $websiteId,
                            'error_message' => $exception->getMessage(),
                            'error_file' => $exception->getFile() . ':' . $exception->getLine(),
                            'request' => $request,
                            'transfer' => $transfer->getData()
                        ]
                    );
                    $responseList[] = [
                        'response' => [
                            'identifier' => $request['identifier'],
                            'sku_id' => $request['sku_id'],
                            'error_message' => $exception->getMessage()
                        ]
                    ];
                    continue;
                }
            }
        }

        return $responseList;
    }

    /**
     * @param int $websiteId
     * @param int $page
     * @return ProductCollection
     *
     * @throws LocalizedException
     */
    public function getProductWihCategoriesAssociated($websiteId, $page = 1): ProductCollection
    {
        $categoriesAssociation = $this->catalogIntegratorConfig->getCategoriesAssociation('website', $websiteId);
        $colorAttribute = $this->catalogIntegratorConfig->getColorAttribute('website', $websiteId);
        $sizeAttribute = $this->catalogIntegratorConfig->getSizeAttribute('website', $websiteId);
        $brandAttribute = $this->catalogIntegratorConfig->getBrandAttribute('website', $websiteId);

        $collection = $this->productCollectionFactory->create();
        $collection
            ->addAttributeToSelect([
                'sku',
                'name',
                'regular_price',
                'special_price',
                'price',
                'final_price',
                'url_key',
                'image',
                'category_ids',
                'status',
                $colorAttribute['attribute_code'],
                $sizeAttribute['attribute_code'],
                $brandAttribute['attribute_code'],
            ])
            ->addCategoriesFilter(['in' => array_keys($categoriesAssociation)])
            ->addAttributeToFilter('type_id', 'configurable')
            ->addAttributeToFilter('status', Status::STATUS_ENABLED)
            ->addWebsiteFilter($websiteId)
            ->setOrder('id', 'asc')
            ->setPage($page, static::PAGE_SIZE);

        $collection->getSelect()->joinLeft(
            ['doris_product' => DorisExportPipelineItemResourceModel::SCHEMA_NAME],
            'doris_product.' . DorisExportPipelineItemModel::PRODUCT_PARENT_ID . ' = e.entity_id',
            []
        )->where('doris_product.entity_id IS NULL');

        if (!$collection->getItems()) {
            $connection = $this->productRelation->getConnection();
            $select = $connection->select()
                ->distinct(true)
                ->from(['pr' => $this->productRelation->getMainTable()], ['parent_id'])
                ->joinLeft(
                    ['pd' => $this->productRelation->getTable('doris_export_pipeline_item')],
                    'pd.product_parent_id = pr.parent_id and pd.product_id = pr.child_id',
                    []
                )
                ->where('pd.product_id IS NULL');


            $parentIds = [];
            foreach ($connection->fetchAll($select) as $parentId) {
                $parentIds[] = $parentId['parent_id'];
            }
            $collection = $this->productCollectionFactory->create();
            $collection
                ->addAttributeToSelect('sku')
                ->addCategoriesFilter(['in' => array_keys($categoriesAssociation)])
                ->addAttributeToFilter('type_id', 'configurable')
                ->addAttributeToFilter('status', Status::STATUS_ENABLED)
                ->addAttributeToFilter('entity_id', ['in' => $parentIds])
                ->addWebsiteFilter($websiteId)
                ->setOrder('id', 'asc')
                ->setPage($page, static::PAGE_SIZE);

            return $collection;
        }

        return $collection;
    }

    /**
     * @param $websiteId
     * @param string $runBy
     *
     * @return DorisExportPipelineInterface
     *
     * @throws CouldNotSaveException
     */
    public function createPipeline($websiteId, $runBy): DorisExportPipelineInterface
    {
        $associatedCategories = [];
        foreach ($this->catalogIntegratorConfig->getCategoriesAssociation('website', $websiteId) as $categoryAssociated) {
            $associatedCategories[] = $categoryAssociated->getData();
        }
        return $this->dorisExportPipelineRepository->save([
            'run_website_id' => $websiteId,
            'associated_categories' => json_encode($associatedCategories),
            'run_by' => $runBy,
        ]);
    }

    /**
     * @param Product $product
     *
     * @return array
     */
    public function updatePriceAndInventory(Product $product)
    {
        $responses = [];
        $responseBuild = $this->updateDorisProductPriceStockResponseBuildFactory->create();

        foreach ($product->getWebsiteIds() as $websiteId) {
            try {
                $request = $this->updateDorisProductPriceStockRequestBuild->buildRequest($product);
                if (!$request instanceof UpdateDorisProductPriceStockRequest) {
                    $this->logger->error(
                        "Invalid Request",
                        [
                            'request' => $request,
                            'product' => $product->getData()
                        ]
                    );
                    continue;
                }
                $transfer = $this->transferFactory->create();
                $transfer->setUri("{$this->setupConfig->getUri('website',   $websiteId)}/pub/product-price-stock")
                    ->setOptions([
                        'headers' => [
                            'User-Agent' => 'module-magento2',
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            'doris-api-key' => $this->setupConfig->getDorisApiKey('website', $websiteId),
                            'doris-secret-key' => $this->setupConfig->getDorisSecretKey('website', $websiteId),
                        ],
                        'body' => $this->serializer->serialize($request->getData())
                    ])
                    ->setMethod('PUT');

                $responses[] = $this->httpClient->placeRequest($transfer, $responseBuild);
            } catch (\Exception $exception) {
                $this->logger->error(
                    "Error to update Doris price stock",
                    [
                        'website_id' => $websiteId,
                        'error_message' => $exception->getMessage(),
                        'error_file' => $exception->getFile() . ':' . $exception->getLine(),
                        'transfer' => !(empty($transfer)) ? $transfer->getData() : [],
                    ]
                );
            }
        }
        return $responses;
    }
}
