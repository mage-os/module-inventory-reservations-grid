<?php
declare(strict_types=1);
namespace MageOS\InventoryReservationsGrid\Model;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Model\AbstractModel;

class Reservation extends AbstractModel  implements ExtensibleDataInterface
{

    protected function _construct()
    {
        $this->_init(\MageOS\InventoryReservationsGrid\Model\ResourceModel\Reservation::class);
    }

    public function getCustomAttributes()
    {
        return [];
    }

    public function setCustomAttributes(array $attributes)
    {
        return $this;
    }

}
