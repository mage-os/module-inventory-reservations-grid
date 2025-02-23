<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

/**
 * Reservation model
 */
class Reservation extends AbstractModel
{
    /**
     * @return void
     * @throws LocalizedException
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel\Reservation::class);
    }
}
