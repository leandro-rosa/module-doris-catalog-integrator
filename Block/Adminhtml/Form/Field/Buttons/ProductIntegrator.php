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

namespace LeandroRosa\DorisCatalogIntegrator\Block\Adminhtml\Form\Field\Buttons;


use LeandroRosa\Core\Helper\DorisCoreConfiguration;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Model\Auth\Session as AuthSession;

class ProductIntegrator extends AbstractButton
{
    /**
     * @var string
     */
    protected $_template = 'LeandroRosa_DorisCatalogIntegrator::product-integrator.phtml';

    /**
     * @var DorisCoreConfiguration
     */
    protected DorisCoreConfiguration $dorisCoreConfig;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var AuthSession
     */
    protected AuthSession $authSession;

    /**
     * @param DorisCoreConfiguration $dorisCoreConfig
     * @param StoreManagerInterface $storeManager
     * @param AuthSession $authSession
     * @param Context $context
     * @param array $data
     * @param SecureHtmlRenderer|null $secureRenderer
     */
    public function __construct(
        DorisCoreConfiguration $dorisCoreConfig,
        StoreManagerInterface  $storeManager,
        AuthSession            $authSession,
        Context                $context,
        array                  $data = [],
        ?SecureHtmlRenderer    $secureRenderer = null
    )
    {
        parent::__construct($context, $data, $secureRenderer);
        $this->dorisCoreConfig = $dorisCoreConfig;
        $this->storeManager = $storeManager;
        $this->authSession = $authSession;
    }

    /**
     * @return string
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getJsonConfig(): string
    {
        $websiteId = $this->storeManager->getWebsite()->getId();
        return json_encode([
            'create_pipeline_url' => "rest/V1/doris/product/create-pipeline",
            'flush_pipelines_url' => "rest/V1/doris/product/flush-pipelines",
            'create_doris_product_url' => "rest/V1/doris/product/create-doris-product",
            'doris_api_key' => $this->dorisCoreConfig->getDorisApiKey('website', $websiteId),
            'doris_secret_key' => $this->dorisCoreConfig->getDorisSecretKey('website', $websiteId),
            'website_id' => $websiteId,
            'user' => $this->authSession->getUser()->getData()
        ]);
    }
}
