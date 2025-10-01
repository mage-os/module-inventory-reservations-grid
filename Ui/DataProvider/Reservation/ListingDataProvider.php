<?php
declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Ui\DataProvider\Reservation;

use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;
use MageOS\InventoryReservationsGrid\Model\ResourceModel\Reservation\Collection as GridCollection;
use MageOS\InventoryReservationsGrid\Model\ResourceModel\Reservation\CollectionFactory;

class ListingDataProvider extends AbstractDataProvider
{
    public function __construct(
        CollectionFactory $collectionFactory,
                          $name,
                          $primaryFieldName,
                          $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Add full text search filter to collection
     *
     * @param Filter $filter
     * @return void
     */
    public function addFilter(Filter $filter): void
    {
        /** @var GridCollection $collection */
        $collection = $this->getCollection();
        if ($filter->getField() === 'fulltext') {
            $value = $filter->getValue() !== null ? trim($filter->getValue()) : '';
            $collection->addFullTextFilter($value);
        } else {
            $collection->addFieldToFilter(
                $filter->getField(),
                [$filter->getConditionType() => $filter->getValue()]
            );
        }
    }
}
