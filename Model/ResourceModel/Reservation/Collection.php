<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Model\ResourceModel\Reservation;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MageOS\InventoryReservationsGrid\Model\Reservation as ReservationModel;
use MageOS\InventoryReservationsGrid\Model\ResourceModel\Reservation as ReservationResource;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Reservation collection
 */
class Collection extends AbstractCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface|null
     */
    private ?AggregationInterface $_aggregations = null;

    /**
     * @var SearchCriteriaInterface|null
     */
    private ?SearchCriteriaInterface $searchCriteria;

    /**
     * List of fields to fulltext search
     */
    private const array FIELDS_TO_FULLTEXT_SEARCH = [
        'sku',
        'quantity',
        'metadata'
    ];

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ReservationModel::class, ReservationResource::class);
    }

    /**
     * @return AggregationInterface|null
     */
    public function getAggregations(): ?AggregationInterface
    {
        return $this->_aggregations;
    }

    /**
     * @param $aggregations
     * @return $this
     */
    public function setAggregations($aggregations): Collection
    {
        $this->_aggregations = $aggregations;
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return SearchCriteriaInterface|null
     */
    public function getSearchCriteria(): ?SearchCriteriaInterface
    {
        return $this->searchCriteria;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return $this
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria): Collection
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->getSize();
    }

    /**
     * @param $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount): Collection
    {
        return $this;
    }

    /**
     * @param array $items
     * @return void
     */
    protected function _setItems(array $items): void
    {
        $this->_items = $items;
    }

    /**
     * @param array|null $items
     * @return $this
     */
    public function setItems(array $items = null): Collection
    {
        $this->_setItems($items);
        return $this;
    }

    /**
     * Add fulltext filter
     *
     * @param string $value
     * @return $this
     */
    public function addFullTextFilter(string $value): Collection
    {
        $fields = self::FIELDS_TO_FULLTEXT_SEARCH;
        $whereCondition = '';
        foreach ($fields as $key => $field) {
            $field = 'main_table.' . $field;
            $condition = $this->_getConditionSql(
                $this->getConnection()->quoteIdentifier($field),
                ['like' => "%$value%"]
            );
            $whereCondition .= ($key === 0 ? '' : ' OR ') . $condition;
        }
        if ($whereCondition) {
            $this->getSelect()->where($whereCondition);
        }

        return $this;
    }
}
