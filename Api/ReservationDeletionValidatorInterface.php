<?php

declare(strict_types=1);

namespace MageOS\InventoryReservationsGrid\Api;

/**
 * Service Interface to check if reservation deletion is allowed.
 */
interface ReservationDeletionValidatorInterface
{
    /**
     * Check if reservation deletion is allowed.
     *
     * @return bool
     */
    public function execute(): bool;
}
