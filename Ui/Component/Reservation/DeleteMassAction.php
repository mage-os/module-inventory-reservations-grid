<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Ui\Component\Reservation;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\MassAction;
use MageOS\InventoryReservationsGrid\Api\ReservationDeletionValidatorInterface;

/**
 * Class for Reservation Deletion Mass Action
 */
class DeleteMassAction extends MassAction
{
    /**
     * @param ContextInterface $context
     * @param ReservationDeletionValidatorInterface $validator
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        ReservationDeletionValidatorInterface $validator,
        array $components = [],
        array $data = []
    ) {
        $this->validator = $validator;
        parent::__construct($context, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepare(): void
    {
        if (!$this->validator->execute()) {
            foreach ($this->getChildComponents() as $actionComponent) {
                $componentConfig = $actionComponent->getConfiguration();
                $componentConfig['actionDisable'] = true;
                $actionComponent->setData('config', $componentConfig);
            }

            $config = $this->getConfiguration();
            $config['componentDisabled'] = true;
            $this->setData('config', $config);
        }

        parent::prepare();
    }
}
