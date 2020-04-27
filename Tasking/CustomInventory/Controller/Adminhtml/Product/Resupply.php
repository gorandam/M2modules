<?php

namespace Tasking\CustomInventory\Controller\Adminhtml\Product;

use Magento\Backend\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Tasking\CustomInventory\Controller\Adminhtml\Product;

class Resupply extends Product
{

    protected $context;
    protected $resupply;
    protected $productRepo;
    protected $stockRegistry;

    /**
     * Resupply constructor.
     * @param $context
     * @param $resupply
     * @param $productRepo
     * @param $stockRegistry
     */
    public function __construct(
        Context $context,
        \Tasking\CustomInventory\Model\Resupply $resupply,
        ProductRepositoryInterface $productRepo,
        StockRegistryInterface $stockRegistry
    ) {
        parent::__construct($context);
        $this->resupply = $resupply;
        $this->productRepo = $productRepo;
        $this->stockRegistry = $stockRegistry;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        if ($this->getRequest()->isPost()) {
            $this->resupply->resupply(
                $this->getRequest()->getParam('id'),
                $_POST['custominventory_product']['qty']
            );
            $this->messageManager->addSuccessMessage(__('Successfully resupplied'));
            $redirectResult = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $redirectResult->setPath('custominventory/product/index');
        } else {
            $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $resultPage->getConfig()->getTitle()->prepend((__('Stock Resupply')));
            return $resultPage;
        }
    }
}
