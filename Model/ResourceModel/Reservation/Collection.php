<?php
declare(strict_types=1);
namespace MageOS\InventoryReservationsGrid\Model\ResourceModel\Reservation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MageOS\InventoryReservationsGrid\Model\Reservation as ReservationModel;
use MageOS\InventoryReservationsGrid\Model\ResourceModel\Reservation as ReservationResource;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class Collection extends AbstractCollection implements SearchResultInterface
{

    /**
     * @var \Magento\Framework\Api\Search\AggregationInterface|null
     */
    private $_aggregations = null;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    private $searchCriteria;


    /**
     * List of fields to fulltext search
     */
    private const FIELDS_TO_FULLTEXT_SEARCH = [
        'sku',
        'quantity',
        'metadata'
    ];


    protected function _construct()
    {
        $this->_init(ReservationModel::class, ReservationResource::class);
    }

    public function getAggregations()
    {
        return $this->_aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->_aggregations = $aggregations;
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }

    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }

    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    protected function _setItems(array $items)
    {
        $this->_items = $items;
    }

    public function setItems(array $items = null)
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
    public function addFullTextFilter(string $value)
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
