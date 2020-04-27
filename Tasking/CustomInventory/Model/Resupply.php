<?php

namespace Tasking\CustomInventory\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogInventory\Api\StockRegistryInterface;

class Resupply
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var StockRegistryInterface
     */
    protected $stockRegistry;

    /**
     * Resupply constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $collectionFactory
     * @param StockRegistryInterface $stockRegistry
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CollectionFactory $collectionFactory,
        StockRegistryInterface $stockRegistry
    ) {
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        $this->stockRegistry = $stockRegistry;
    }

    /**
     * @param $productId
     * @param $qty
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function resupply($productId, $qty)
    {
        $productModel = $this->productRepository->getById($productId);
        $stockItem = $this->stockRegistry->getStockItemBySku($productModel->getSku());
        $stockItem->setQty($stockItem->getQty() + $qty);
        $stockItem->setIsInStock((bool)$stockItem->getQty());
        $this->stockRegistry->updateStockItemBySku($productModel->getSku(), $stockItem);
    }
}
