<?php
declare(strict_types=1);
namespace MageOS\InventoryReservationsGrid\Controller\Adminhtml\Reservation;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MageOS_InventoryReservationsGrid::reservation');
        $resultPage->getConfig()->getTitle()->prepend(__('Reservations'));
        return $resultPage;
    }
}
