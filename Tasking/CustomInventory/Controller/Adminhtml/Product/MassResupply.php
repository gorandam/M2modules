<?php

namespace Tasking\CustomInventory\Controller\Adminhtml\Product;

use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Tasking\CustomInventory\Controller\Adminhtml\Product;
use Tasking\CustomInventory\Model\Resupply;

class MassResupply extends Product
{

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var Resupply
     */
    private $resupply;

    /**
     * @var Filter
     */
    private $filter;


    /**
     * MassResupply constructor.
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param Resupply $resupply
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        Resupply $resupply,
        Filter $filter
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->resupply = $resupply;
        $this->filter = $filter;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $redirectResult = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $qty = $this->getRequest()->getParam('qty');
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        $productResupplied = 0;
        foreach ($collection->getItems() as $product) {
            $this->resupply->resupply($product->getId(), $qty);
            $productResupplied++;
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been resupplied.', $productResupplied));

        return $redirectResult->setPath('custominventory/product/index');
    }
}
