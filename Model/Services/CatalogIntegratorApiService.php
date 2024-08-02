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

use LeandroRosa\DorisCatalogIntegrator\Api\CatalogIntegratorApiInterface;
use LeandroRosa\DorisCatalogIntegrator\Api\CreateExportPipelineParamsInterface;
use LeandroRosa\DorisCatalogIntegrator\Api\Data\DorisExportPipelineInterface;
use LeandroRosa\Core\Model\Validators\RequestDorisCredentialsValidator;
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;

class CatalogIntegratorApiService implements CatalogIntegratorApiInterface
{
    /**
     * @var RequestHttp
     */
    protected RequestHttp $request;

    /**
     * @var RequestDorisCredentialsValidator
     */
    protected RequestDorisCredentialsValidator $dorisCredentialsValidator;

    /**
     * @var DorisProductService
     */
    protected DorisProductService $dorisProductService;

    /**
     * @param RequestHttp $request
     * @param RequestDorisCredentialsValidator $dorisCredentialsValidator
     * @param DorisProductService $dorisProductService
     */
    public function __construct(
        RequestHttp                      $request,
        RequestDorisCredentialsValidator $dorisCredentialsValidator,
        DorisProductService              $dorisProductService,
    )
    {
        $this->request = $request;
        $this->dorisCredentialsValidator = $dorisCredentialsValidator;
        $this->dorisProductService = $dorisProductService;
    }


    /**
     * @inheritDoc
     *
     * @throws AuthenticationException
     * @throws LocalizedException
     */
    public function createDorisProduct($pipelineId)
    {
        $validator = $this->dorisCredentialsValidator->validate($this->request);
        return $this->dorisProductService->createDorisProduct($pipelineId, (int)[$validator['website_id']]);
    }

    /**
     * @inheritDoc
     *
     * @throws AuthenticationException
     * @throws LocalizedException
     */
    public function flushPipelines(): string
    {
        $this->dorisCredentialsValidator->validate($this->request);
        $this->dorisProductService->flushPipelines();

        return 'Pipelines flushed';
    }

    /**
     * @inheritDoc
     *
     * @throws CouldNotSaveException
     * @throws AuthenticationException
     * @throws LocalizedException
     */
    public function createPipeline(CreateExportPipelineParamsInterface $pipeline): DorisExportPipelineInterface
    {
        $validator = $this->dorisCredentialsValidator->validate($this->request);
        return $this->dorisProductService->createPipeline($validator['website_id'], $pipeline->getRunBy());
    }
}
