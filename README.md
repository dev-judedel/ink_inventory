# Ink Inventory Module (PHP MVC)

Drop-in module for tracking ink cartridges/toners, batches, and stock ledger movements.

## Contents
- `database.sql` — DB schema (3 tables)
- `app/Models` — InkItem, InkBatch, InkMovement
- `app/Services/InkInventoryService.php` — core logic (receive, issue FIFO, adjust, avg cost, reorder)
- `app/Controllers/InkInventoryController.php` — MVC endpoints
- `routes/web.php` — routes mounting under `/ink`
- `views/ink/` — minimal UI (index, show, reorder)

## Install
1. Run `database.sql` on your MySQL/MariaDB.
2. Copy `app/*`, `routes/web.php`, and `views/ink/*` into your app.
3. Ensure your base framework provides:
   - `Core\DB`, `Core\Request`, `Core\Response`, `Core\Auth`
   - Base `Model` and `Controller` classes with standard helpers (where/orderBy/get/save/paginate/findOrFail/view/redirect).
4. Navigate to `/ink` in the browser.

## Notes
- Issues are costed FIFO per batch; we also store `avg_cost` snapshot on every movement for audit.
- Add `location_id` on batches/movements to support multi-site inventories.
- Hook to GL/expenses by listening to receive/issue events in your app.