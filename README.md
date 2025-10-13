# MageOS Inventory Reservations Grid

## Overview
The **MageOS Inventory Reservations Grid** module extends Magento's inventory management by providing an admin grid for viewing reservations and additional actions for managing them.

## Features
- View all inventory reservations in a structured grid.
- Manually clean compensated reservations (those resolving to zero) similar to Magento’s built-in cron job.
- Mass delete uncompensated reservations, which can be restricted based on ACL rules.
- Configuration to globally disable the mass delete action for all admins.

## Installation
Install via Composer:
```sh
composer require mage-os/module-inventory-reservations-grid
bin/magento module:enable MageOS_InventoryReservationsGrid
bin/magento setup:upgrade
```

## Usage

Find the new Inventory Reservations report at **Stores > Inventory > Reservations**.

## Configuration
Navigate to **Stores > Configuration > Catalog > Inventory > Reservation** to find the following setting:

- **Allow Delete Mass Action** (`cataloginventory/reservation/allow_delete`):
    - If enabled, allows admin users with the appropriate ACL permissions to delete uncompensated reservations.
    - Defaults to `0` (disabled).
    - Can be locked via `env.php` or `config.php`.

### Blocking reservation deletion

Deleting inventory reservations can be a dangerous action that leaves inventory in an inconsistent state, depending on how your system works. This feature is disabled by default.

You can prevent reservation deletion from being enabled at all by running this command. This locks the setting to disabled in your `app/etc/env.php`.

```bash
bin/magento config:set --lock-env cataloginventory/reservation/allow_delete 0
```

## ACL Permissions
The module introduces fine-grained ACL rules to control access:

- **View Reservations** (`MageOS_InventoryReservationsGrid::view`)
- **Clean Balanced Reservations** (`MageOS_InventoryReservationsGrid::clean`)
- **Mass Delete Reservations** (`MageOS_InventoryReservationsGrid::delete`)

## Best Practices
- **Use the View-Only Mode**: This module allows viewing reservations without enabling deletion actions.
- **Be Cautious with Mass Deletion**: Removing uncompensated reservations can cause stock inconsistencies; only grant access to users who understand the implications.
- **Lock Configuration**: disable the mass delete function globally via `env.php` or `config.php`, and enable it only in case if there is specific need for using it.

## Additional Notes
Magento already runs a cron job (`inventory_cleanup_reservations`) to clean up compensated reservations. The manual clean button in this module serves as a fallback for scenarios where the cron does not execute properly. However, merchants needing to fix misalignments caused by external system issues can now remove uncompensated reservations where necessary, under controlled permissions.

## License
[Open Source License](LICENSE)
