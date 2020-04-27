<?php

namespace Tasking\CustomInventory\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Resupply extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Resupply constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $storeId = $this->context->getFilterParam('store_id');

            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['resupply'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'custominventory/product/resupply',
                        ['id' => $item['entity_id'], 'store' => $storeId]
                    ),
                    'label' => __('Resupply'),
                    'hidden' => false,
                ];
            }
        }
        return $dataSource;
    }
}
