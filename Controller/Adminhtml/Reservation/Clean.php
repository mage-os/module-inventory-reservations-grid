<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Controller\Adminhtml\Reservation;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\InventoryReservationsApi\Model\CleanupReservationsInterface;
use Psr\Log\LoggerInterface;

/**
 * Controller for cleaning up compensated reservations.
 */
class Clean extends Action
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see MassDelete::_isAllowed()
     */
    const ADMIN_RESOURCE = 'MageOS_InventoryReservationsGrid::clean';

    /**
     * @param Context $context
     * @param CleanupReservationsInterface $cleanupReservations
     * @param LoggerInterface $logger
     */
    public function __construct(
        Action\Context $context,
        private readonly CleanupReservationsInterface $cleanupReservations,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($context);
    }

    /**
     * Cleanup reservations.
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        try {
            $this->cleanupReservations->execute();
        } catch (\Exception $exception) {
            $this->logger->error($exception->getLogMessage());
            $this->messageManager->addErrorMessage(
                __('Couldn\'t clean up reservations. Please see server logs for more details')
            );
        }

        return $this->resultRedirectFactory->create()->setPath('catalog_inventory/reservation/index');
    }
}
