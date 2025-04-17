<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Model\Service;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use MageOS\InventoryReservationsGrid\Api\ReservationDeletionValidatorInterface;

/**
 * Service class to check if reservation deletion is allowed.
 *
 * This class validates if reservation deletion is permitted based on global configuration
 * and user ACL permissions.
 */
class ReservationDeletionValidator implements ReservationDeletionValidatorInterface
{
    /**
     * Path to the configuration setting for allowing reservation deletion.
     */
    private const string PATH_ALLOW_DELETE = 'cataloginventory/reservation/allow_delete';

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param AuthorizationInterface $authorization
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly AuthorizationInterface $authorization
    ) {}

    /**
     * @inheritDoc
     */
    public function execute(): bool
    {
        $isAllowedGlobally = $this->scopeConfig->isSetFlag(
            self::PATH_ALLOW_DELETE
        );

        if (!$isAllowedGlobally) {
            return false;
        }

        return $this->authorization->isAllowed('MageOS_InventoryReservationsGrid::delete');
    }
}
