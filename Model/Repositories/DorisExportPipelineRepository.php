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

namespace LeandroRosa\DorisCatalogIntegrator\Model\Repositories;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

use LeandroRosa\Core\Model\Repository\AbstractRepository;
use LeandroRosa\DorisCatalogIntegrator\Model\ResourceModel\DorisExportPipeline as ResourceModel;
use LeandroRosa\DorisCatalogIntegrator\Model\ResourceModel\DorisExportPipeline\CollectionFactory;
use LeandroRosa\DorisCatalogIntegrator\Model\DorisExportPipelineFactory as EntityFactory;

class DorisExportPipelineRepository extends AbstractRepository
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;


    /**
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ResourceModel $resource
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionFactory $collectionFactory
     * @param EntityFactory $entityFactory
     */
    public function __construct(
        SearchCriteriaBuilder         $searchCriteriaBuilder,
        ResourceModel                 $resource,
        CollectionProcessorInterface  $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionFactory             $collectionFactory,
        EntityFactory                 $entityFactory
    )
    {
        parent::__construct($searchCriteriaBuilder, $resource, $collectionProcessor, $searchResultsFactory);
        $this->collectionFactory = $collectionFactory;
        $this->entityFactory = $entityFactory;
    }
}
