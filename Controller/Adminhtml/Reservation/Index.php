<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Controller\Adminhtml\Reservation;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Controller for reservation list page.
 */
class Index extends Action
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see MassDelete::_isAllowed()
     */
    const ADMIN_RESOURCE = 'MageOS_InventoryReservationsGrid::view';

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        private readonly PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    /**
     * Reservation list page.
     *
     * @return Page
     */
    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MageOS_InventoryReservationsGrid::reservation');
        $resultPage->getConfig()->getTitle()->prepend(__('Reservations'));
        return $resultPage;
    }
}
