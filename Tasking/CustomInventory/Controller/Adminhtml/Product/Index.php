<?php

namespace Tasking\CustomInventory\Controller\Adminhtml\Product;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Tasking\CustomInventory\Controller\Adminhtml\Product;

class Index extends Product
{
    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend((__('Custom Inventory')));

        return $resultPage;
    }
}
