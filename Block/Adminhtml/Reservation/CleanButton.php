<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Block\Adminhtml\Reservation;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Block class for clean button on reservation list page.
 */
class CleanButton implements ButtonProviderInterface
{
    /**
     * @param UrlInterface $urlBuilder
     * @param AuthorizationInterface $authorization
     */
    public function __construct(
        private readonly UrlInterface $urlBuilder,
        private readonly AuthorizationInterface $authorization,
    ) {}

    /**
     * Provide data for clean button on reservation list page.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        if (!$this->authorization->isAllowed('MageOS_InventoryReservationsGrid::clean')) {
            return [];
        }

        return [
            'label' => __('Clean Reservations'),
            'class' => 'clean primary',
            'data_attribute' => [
                'url' => $this->getUrl('catalog_inventory/reservation/clean'),
            ],
            'on_click' => '',
            'sort_order' => 80,
        ];
    }

    /**
     * Generate url by route and parameters.
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
