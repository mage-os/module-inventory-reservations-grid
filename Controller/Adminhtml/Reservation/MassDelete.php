<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Controller\Adminhtml\Reservation;

use MageOS\InventoryReservationsGrid\Api\ReservationDeletionValidatorInterface;
use MageOS\InventoryReservationsGrid\Model\ResourceModel\Reservation as ReservationResource;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use MageOS\InventoryReservationsGrid\Model\ResourceModel\Reservation\CollectionFactory;
use MageOS\InventoryReservationsGrid\Model\Reservation;
use Psr\Log\LoggerInterface;

/**
 * Controller for deleting selected inventory reservations through mass action.
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see MassDelete::_isAllowed()
     */
    const string ADMIN_RESOURCE = 'MageOS_InventoryReservationsGrid::delete';

    /**
     * @param Context $context
     * @param Filter $filter
     * @param RedirectFactory $redirect
     * @param ReservationResource $reservationResource
     * @param CollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     * @param ReservationDeletionValidatorInterface $reservationDeletionValidator
     */
    public function __construct(
        Context $context,
        private readonly Filter $filter,
        private readonly RedirectFactory $redirect,
        private readonly ReservationResource $reservationResource,
        private readonly CollectionFactory $collectionFactory,
        private readonly LoggerInterface $logger,
        private readonly ReservationDeletionValidatorInterface $reservationDeletionValidator
    ) {
        parent::__construct($context);
    }

    /**
     * Delete specified inventory reservations using grid mass action.
     *
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        if ($this->reservationDeletionValidator->execute()) {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $reservationDeleted = 0;
            $reservationDeletedError = 0;
            /** @var Reservation $product */
            foreach ($collection->getItems() as $product) {
                try {
                    $this->reservationResource->delete($product);
                    $reservationDeleted++;
                } catch (\Exception $exception) {
                    $this->logger->error($exception->getLogMessage());
                    $reservationDeletedError++;
                }
            }

            if ($reservationDeleted) {
                $this->messageManager->addSuccessMessage(
                    __('A total of %1 record(s) have been deleted.', $reservationDeleted)
                );
            }

            if ($reservationDeletedError) {
                $this->messageManager->addErrorMessage(
                    __(
                        'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                        $reservationDeletedError
                    )
                );
            }
        }

        return $this->redirect->create()->setPath('catalog_inventory/reservation/index');
    }
}
