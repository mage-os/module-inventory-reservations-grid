<?php
declare(strict_types=1);
namespace MageOS\InventoryReservationsGrid\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Reservation extends AbstractDb
{

    public const TABLE_NAME = 'inventory_reservation';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'reservation_id');
    }
}
