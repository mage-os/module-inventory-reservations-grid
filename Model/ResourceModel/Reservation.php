<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Reservation resource model
 */
class Reservation extends AbstractDb
{
    /**
     * Reservation table name
     */
    public const string TABLE_NAME = 'inventory_reservation';

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, 'reservation_id');
    }
}
