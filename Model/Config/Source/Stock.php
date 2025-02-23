<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Inventory\Model\ResourceModel\Stock\Collection;

/**
 * Provide source options for stock entity.
 */
class Stock implements OptionSourceInterface
{
    /**
     * @param Collection $collection
     */
    public function __construct(
        private readonly Collection $collection
    ) {}

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        $optionArray = [];
        foreach ($this->collection->getItems() as $stock) {
            $optionArray[] = ['value' => $stock->getStockId(), 'label' => $stock->getName()];
        }
        return $optionArray;
    }
}
