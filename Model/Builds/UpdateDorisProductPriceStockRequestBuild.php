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

use LeandroRosa\DorisCatalogIntegrator\Model\UpdateDorisProductPriceStockRequest;
use LeandroRosa\DorisCatalogIntegrator\Model\UpdateDorisProductPriceStockRequestFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\InventoryApi\Api\Data\SourceItemInterface;
use Magento\InventoryApi\Api\StockRepositoryInterface;
use Magento\InventoryApi\Api\SourceItemRepositoryInterface;
use Psr\Log\LoggerInterface;

class UpdateDorisProductPriceStockRequestBuild
{
    /**
     * @var UpdateDorisProductPriceStockRequestFactory
     */
    protected UpdateDorisProductPriceStockRequestFactory $requestFactory;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

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
     * @param UpdateDorisProductPriceStockRequestFactory $requestFactory
     * @param LoggerInterface $logger
     * @param StockRepositoryInterface $stockRepository
     * @param SourceItemRepositoryInterface $sourceItemRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        UpdateDorisProductPriceStockRequestFactory $requestFactory,
        LoggerInterface                            $logger,
        StockRepositoryInterface                   $stockRepository,
        SourceItemRepositoryInterface              $sourceItemRepository,
        SearchCriteriaBuilder                      $searchCriteriaBuilder
    )
    {
        $this->requestFactory = $requestFactory;
        $this->logger = $logger;
        $this->stockRepository = $stockRepository;
        $this->sourceItemRepository = $sourceItemRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param Product $product
     * @return UpdateDorisProductPriceStockRequest|bool
     */
    public function buildRequest(Product $product): UpdateDorisProductPriceStockRequest|bool
    {
        if ($product->getTypeId() !== 'simple') {
            return false;
        }

        if (
            $product->dataHasChangedFor('stock_data') ||
            $product->dataHasChangedFor('regular_price') ||
            $product->dataHasChangedFor('special_price')) {

            $stockItem = $this->getProductStock($product);
            $request = $this->requestFactory->create();
            $request
                ->setHasStock($stockItem->getQuantity() > 0)
                ->setRegularPrice($product->getPrice() * 100)
                ->setSpecialPrice($product->getFinalPrice() * 100)
                ->setSkuId($product->getSku());

            return $request;
        }

        return false;
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
