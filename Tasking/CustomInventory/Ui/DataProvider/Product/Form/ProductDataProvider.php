<?php

namespace Tasking\CustomInventory\Ui\DataProvider\Product\Form;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class ProductDataProvider extends AbstractDataProvider
{
    protected $loadedData;
    protected $productRepository;
    protected $stockRegistry;
    protected $request;

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        ProductRepositoryInterface $productRepository,
        StockRegistryInterface $stockRegistry,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
    
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
        $this->request = $request;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $id = $this->request->getParam('id');
        $product = $this->productRepository->getById($id);
        $stockItem = $this->stockRegistry->getStockItemBySku($product->getSku());

        $this->loadedData[$product->getId()]['custominventory_product'] = [
            'stock' => __('%1 | %2', $product->getSku(), $stockItem->getQty()),
            'qty' => 10
        ];

        return $this->loadedData;
    }
}
