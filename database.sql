-- Ink Inventory Module — Database Schema
-- Engine: InnoDB, Charset: utf8mb4
-- Run this file to create the required tables.

CREATE TABLE IF NOT EXISTS ink_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sku VARCHAR(64) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  brand VARCHAR(128) NULL,
  color VARCHAR(64) NULL,
  printer_models TEXT NULL,
  uom VARCHAR(16) NOT NULL DEFAULT 'pc',
  reorder_point INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  deleted_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS ink_batches (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_id INT NOT NULL,
  batch_no VARCHAR(64) NULL,
  supplier VARCHAR(128) NULL,
  expiry_date DATE NULL,
  unit_cost DECIMAL(12,2) NOT NULL DEFAULT 0,
  qty_received INT NOT NULL DEFAULT 0,
  qty_remaining INT NOT NULL DEFAULT 0,
  received_at DATETIME NOT NULL,
  remarks VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  CONSTRAINT fk_ink_batches_item FOREIGN KEY (item_id) REFERENCES ink_items(id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX idx_batches_item (item_id),
  INDEX idx_batches_received_at (received_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS ink_movements (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  item_id INT NOT NULL,
  batch_id INT NULL,
  txn_date DATETIME NOT NULL,
  type ENUM('IN','OUT','ADJ') NOT NULL,
  ref_no VARCHAR(64) NULL,
  doc_type VARCHAR(64) NULL,
  doc_id INT NULL,
  location VARCHAR(64) NULL,
  qty INT NOT NULL,
  unit_cost DECIMAL(12,2) NOT NULL DEFAULT 0,
  avg_cost DECIMAL(12,2) NOT NULL DEFAULT 0,
  note VARCHAR(255) NULL,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_movements_item FOREIGN KEY (item_id) REFERENCES ink_items(id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_movements_batch FOREIGN KEY (batch_id) REFERENCES ink_batches(id)
    ON UPDATE CASCADE ON DELETE SET NULL,
  INDEX idx_movements_item (item_id),
  INDEX idx_movements_batch (batch_id),
  INDEX idx_movements_txn_date (txn_date),
  INDEX idx_movements_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Helpful view: current stock on hand per item
-- (Optional; comment out if your DB permissions restrict VIEWs)
/*
CREATE OR REPLACE VIEW v_ink_onhand AS
SELECT i.id AS item_id, i.sku, i.name,
       COALESCE(SUM(CASE WHEN m.type='IN' THEN m.qty
                         WHEN m.type='OUT' THEN -m.qty
                         ELSE m.qty END), 0) AS on_hand
FROM ink_items i
LEFT JOIN ink_movements m ON m.item_id=i.id
GROUP BY i.id, i.sku, i.name;
*/