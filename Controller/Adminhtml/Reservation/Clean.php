<?php
declare(strict_types=1);
namespace MageOS\InventoryReservationsGrid\Controller\Adminhtml\Reservation;

use Magento\Backend\App\Action;
use Magento\InventoryReservationsApi\Model\CleanupReservationsInterface;
use Magento\Framework\Exception\LocalizedException;

class Clean extends Action
{
    /**
     * @var CleanupReservationsInterface
     */
    private $cleanupReservations;

    public function __construct(
        Action\Context $context,
        CleanupReservationsInterface $cleanupReservations,
    ) {
        parent::__construct($context);
        $this->cleanupReservations = $cleanupReservations;
    }

    /**
     * Cleanup reservations
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $this->cleanupReservations->execute();
        } catch (LocalizedException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $this->resultRedirectFactory->create()->setPath('catalog_inventory/reservation/index');
    }
}
