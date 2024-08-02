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

use LeandroRosa\DorisCatalogIntegrator\Helper\DorisCatalogIntegratorConfiguration;
use LeandroRosa\DorisCatalogIntegrator\Model\Builds\CreateDorisProductResponseBuild;
use LeandroRosa\Core\Api\ClientInterface;
use LeandroRosa\Core\Helper\DorisCoreConfiguration;
use LeandroRosa\Core\Http\TransferFactory;
use LeandroRosa\DorisCatalogIntegrator\Model\Builds\GetDorisCategoryListResponseBuildFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;

class DorisCategoryService
{
    /**
     * @var DorisCoreConfiguration
     */
    protected DorisCoreConfiguration $setupConfig;

    /**
     * @var TransferFactory
     */
    protected TransferFactory $transferFactory;

    /**
     * @var ClientInterface
     */
    protected ClientInterface $httpClient;

    /**
     * @var GetDorisCategoryListResponseBuildFactory
     */
    protected GetDorisCategoryListResponseBuildFactory $categoryListResponseBuildFactory;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @param DorisCoreConfiguration $setupConfig
     * @param TransferFactory $transferFactory
     * @param ClientInterface $httpClient
     * @param GetDorisCategoryListResponseBuildFactory $categoryListResponseBuildFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        DorisCoreConfiguration                   $setupConfig,
        TransferFactory                          $transferFactory,
        ClientInterface                          $httpClient,
        GetDorisCategoryListResponseBuildFactory $categoryListResponseBuildFactory,
        StoreManagerInterface                    $storeManager,

    )
    {
        $this->setupConfig = $setupConfig;
        $this->transferFactory = $transferFactory;
        $this->httpClient = $httpClient;
        $this->categoryListResponseBuildFactory = $categoryListResponseBuildFactory;
        $this->storeManager = $storeManager;

    }

    /**
     * @param int|null $websiteId
     *
     * @return mixed|void
     *
     * @throws LocalizedException
     */
    public function getDorisCategoryList(?int $websiteId = null)
    {
        if (!$websiteId) {
            $websiteId = $this->storeManager->getWebsite()->getId();
        }
        $responseBuild = $this->categoryListResponseBuildFactory->create();
        $transfer = $this->transferFactory->create();

        $transfer->setUri("{$this->setupConfig->getUri()}/category/doris-category-list")
            ->setOptions([
                'headers' => [
                    'User-Agent' => 'module-magento2',
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'doris-api-key' => $this->setupConfig->getDorisApiKey('website', $websiteId),
                    'doris-secret-key' => $this->setupConfig->getDorisSecretKey('website', $websiteId),
                ],
            ])
            ->setMethod('GET');

        try {
            return $this->httpClient->placeRequest($transfer, $responseBuild);
        } catch (\Exception $exception) {
            // Do nothing.
        }
    }
}
