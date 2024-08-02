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

namespace LeandroRosa\DorisCatalogIntegrator\Observer;

use LeandroRosa\DorisCatalogIntegrator\Model\Services\DorisProductService;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class UpdatePriceInventory implements ObserverInterface
{
    /**
     * @var DorisProductService
     */
    protected DorisProductService $dorisProductService;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param DorisProductService $dorisProductService
     * @param LoggerInterface $logger
     */
    public function __construct(
        DorisProductService $dorisProductService,
        LoggerInterface     $logger,
    )
    {
        $this->dorisProductService = $dorisProductService;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $product = $observer->getEvent()->getProduct();
            $this->dorisProductService->updatePriceAndInventory($product);
        } catch (\Exception $exception) {
            $this->logger->error(
                "Error to update Doris price stock",
                [
                    'error_message' => $exception->getMessage(),
                    'error_file' => $exception->getFile() . ':' . $exception->getLine(),
                    'observer' => $observer->getData(),
                ]
            );
        }

    }
}
