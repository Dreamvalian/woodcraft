-- Woodcraft Database Schema

-- Users table
CREATE TABLE users
(
  id INT
  UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR
  (100) NOT NULL,
  email VARCHAR
  (100) NOT NULL,
  phone VARCHAR
  (20),
  address TEXT,
  password VARCHAR
  (255) NOT NULL,
  role ENUM
  ('admin', 'user') NOT NULL DEFAULT 'user',
  email_verified_at TIMESTAMP NULL,
  last_login_at TIMESTAMP NULL,
  status ENUM
  ('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
  UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_users_email (email),
  INDEX idx_users_status
  (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  -- Categories table
  CREATE TABLE categories
  (
    id INT
    UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR
    (100) NOT NULL,
  slug VARCHAR
    (100) NOT NULL,
  description TEXT,
  image VARCHAR
    (255),
  is_active TINYINT
    (1) DEFAULT 1,
  parent_id INT UNSIGNED,
  display_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
    UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_categories_slug (slug),
  INDEX idx_categories_parent
    (parent_id),
  INDEX idx_categories_active
    (is_active),
  FOREIGN KEY
    (parent_id) REFERENCES categories
    (id) ON
    DELETE
    SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    -- Products table
    CREATE TABLE products
    (
      id INT
      UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR
      (100) NOT NULL,
  slug VARCHAR
      (100) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL
      (10,2) NOT NULL,
  sale_price DECIMAL
      (10,2),
  stock INT NOT NULL DEFAULT 0,
  sku VARCHAR
      (50) UNIQUE,
  image VARCHAR
      (255),
  category_id INT UNSIGNED NOT NULL,
  features JSON,
  is_active TINYINT
      (1) DEFAULT 1,
  weight DECIMAL
      (8,2),
  dimensions VARCHAR
      (50),
  material VARCHAR
      (100),
  min_order_quantity INT DEFAULT 1,
  max_order_quantity INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
      UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_products_slug (slug),
  INDEX idx_products_category
      (category_id),
  INDEX idx_products_active
      (is_active),
  INDEX idx_products_price
      (price),
  FOREIGN KEY
      (category_id) REFERENCES categories
      (id) ON
      DELETE CASCADE
) ENGINE=InnoDB
      DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

      -- Product Images table
      CREATE TABLE product_images
      (
        id INT
        UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  image_path VARCHAR
        (255) NOT NULL,
  is_primary TINYINT
        (1) DEFAULT 0,
  sort_order INT DEFAULT 0,
  alt_text VARCHAR
        (255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
        UPDATE CURRENT_TIMESTAMP,
  INDEX idx_product_images_product (product_id),
  INDEX idx_product_images_primary (is_primary),
  FOREIGN KEY
        (product_id) REFERENCES products
        (id) ON
        DELETE CASCADE
) ENGINE=InnoDB
        DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        -- Orders table
        CREATE TABLE orders
        (
          id INT
          UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  order_number VARCHAR
          (50) NOT NULL,
  total_amount DECIMAL
          (10,2) NOT NULL,
  status ENUM
          ('pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded') NOT NULL DEFAULT 'pending',
  shipping_address TEXT NOT NULL,
  shipping_phone VARCHAR
          (20) NOT NULL,
  shipping_name VARCHAR
          (100) NOT NULL,
  shipping_method VARCHAR
          (50),
  shipping_cost DECIMAL
          (10,2) DEFAULT 0.00,
  payment_method VARCHAR
          (50) NOT NULL,
  payment_status ENUM
          ('pending', 'paid', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
  payment_id VARCHAR
          (100),
  tracking_number VARCHAR
          (100),
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
          UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_orders_number (order_number),
  INDEX idx_orders_user
          (user_id),
  INDEX idx_orders_status
          (status),
  INDEX idx_orders_payment_status
          (payment_status),
  FOREIGN KEY
          (user_id) REFERENCES users
          (id) ON
          DELETE CASCADE
) ENGINE=InnoDB
          DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

          -- Order Items table
          CREATE TABLE order_items
          (
            id INT
            UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL
            (10,2) NOT NULL,
  subtotal DECIMAL
            (10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
            UPDATE CURRENT_TIMESTAMP,
  INDEX idx_order_items_order (order_id),
  INDEX idx_order_items_product (product_id),
  FOREIGN KEY
            (order_id) REFERENCES orders
            (id) ON
            DELETE CASCADE,
  FOREIGN KEY (product_id)
            REFERENCES products
            (id) ON
            DELETE CASCADE
) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            -- Reviews table
            CREATE TABLE reviews
            (
              id INT
              UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  rating TINYINT NOT NULL,
  comment TEXT,
  is_verified_purchase TINYINT
              (1) DEFAULT 0,
  is_approved TINYINT
              (1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
              UPDATE CURRENT_TIMESTAMP,
  INDEX idx_reviews_product (product_id),
  INDEX idx_reviews_user (user_id),
  INDEX idx_reviews_rating (rating),
  FOREIGN KEY
              (product_id) REFERENCES products
              (id) ON
              DELETE CASCADE,
  FOREIGN KEY (user_id)
              REFERENCES users
              (id) ON
              DELETE CASCADE,
  CHECK (rating
              >= 1 AND rating <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

              -- Shopping Cart table
              CREATE TABLE carts
              (
                id INT
                UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED,
  product_id INT UNSIGNED NOT NULL,
  quantity INT NOT NULL,
  session_id VARCHAR
                (100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
                UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_carts_user_product (user_id, product_id
                ),
  INDEX idx_carts_user
                (user_id),
  INDEX idx_carts_product
                (product_id),
  INDEX idx_carts_session
                (session_id),
  FOREIGN KEY
                (user_id) REFERENCES users
                (id) ON
                DELETE CASCADE,
  FOREIGN KEY (product_id)
                REFERENCES products
                (id) ON
                DELETE CASCADE
) ENGINE=InnoDB
                DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

                -- Product Discounts table
                CREATE TABLE product_discounts
                (
                  id INT
                  UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  discount_type ENUM
                  ('percentage', 'fixed') NOT NULL,
  discount_value DECIMAL
                  (10,2) NOT NULL,
  start_date TIMESTAMP NOT NULL,
  end_date TIMESTAMP NOT NULL,
  is_active TINYINT
                  (1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
                  UPDATE CURRENT_TIMESTAMP,
  INDEX idx_product_discounts_product (product_id),
  INDEX idx_product_discounts_dates (start_date, end_date),
  FOREIGN KEY
                  (product_id) REFERENCES products
                  (id) ON
                  DELETE CASCADE
) ENGINE=InnoDB
                  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

                  -- Insert example data

                  -- Users
                  INSERT INTO users
                    (name, email, phone, address, password, role, status)
                  VALUES
                    ('Admin User', 'admin@woodcraft.com', '1234567890', '123 Admin St, Admin City', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active'),
                    ('John Doe', 'john@example.com', '2345678901', '456 Main St, City', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active'),
                    ('Jane Smith', 'jane@example.com', '3456789012', '789 Oak St, Town', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active');

                  -- Categories
                  INSERT INTO categories
                    (name, slug, description, is_active, parent_id)
                  VALUES
                    ('Furniture', 'furniture', 'Wooden furniture items', 1, NULL),
                    ('Decorations', 'decorations', 'Wooden decorative items', 1, NULL),
                    ('Tables', 'tables', 'Wooden tables', 1, 1),
                    ('Chairs', 'chairs', 'Wooden chairs', 1, 1),
                    ('Wall Art', 'wall-art', 'Wooden wall decorations', 1, 2);

                  -- Products
                  INSERT INTO products
                    (name, slug, description, price, stock, sku, category_id, features, is_active, weight, dimensions, material)
                  VALUES
                    ('Oak Dining Table', 'oak-dining-table', 'Beautiful oak dining table', 599.99, 10, 'TBL-001', 3, '{"color": "natural", "style": "modern"}', 1, 45.5, '180x90x75', 'Oak'),
                    ('Mahogany Chair', 'mahogany-chair', 'Elegant mahogany chair', 199.99, 20, 'CHR-001', 4, '{"color": "dark", "style": "classic"}', 1, 15.2, '45x45x90', 'Mahogany'),
                    ('Wooden Wall Clock', 'wooden-wall-clock', 'Handcrafted wooden wall clock', 89.99, 15, 'DEC-001', 5, '{"color": "natural", "style": "rustic"}', 1, 2.5, '30x30x5', 'Pine');

                  -- Product Images
                  INSERT INTO product_images
                    (product_id, image_path, is_primary, alt_text)
                  VALUES
                    (1, '/images/products/oak-table-1.jpg', 1, 'Oak Dining Table Front View'),
                    (1, '/images/products/oak-table-2.jpg', 0, 'Oak Dining Table Side View'),
                    (2, '/images/products/mahogany-chair-1.jpg', 1, 'Mahogany Chair Front View'),
                    (3, '/images/products/wall-clock-1.jpg', 1, 'Wooden Wall Clock');

                  -- Orders
                  INSERT INTO orders
                    (user_id, order_number, total_amount, status, shipping_address, shipping_phone, shipping_name, payment_method, payment_status)
                  VALUES
                    (2, 'ORD-001', 799.98, 'delivered', '456 Main St, City', '2345678901', 'John Doe', 'credit_card', 'paid'),
                    (3, 'ORD-002', 89.99, 'processing', '789 Oak St, Town', '3456789012', 'Jane Smith', 'paypal', 'paid');

                  -- Order Items
                  INSERT INTO order_items
                    (order_id, product_id, quantity, price, subtotal)
                  VALUES
                    (1, 1, 1, 599.99, 599.99),
                    (1, 2, 1, 199.99, 199.99),
                    (2, 3, 1, 89.99, 89.99);

                  -- Reviews
                  INSERT INTO reviews
                    (product_id, user_id, rating, comment, is_verified_purchase, is_approved)
                  VALUES
                    (1, 2, 5, 'Excellent quality and craftsmanship!', 1, 1),
                    (2, 2, 4, 'Very comfortable chair, slightly expensive.', 1, 1),
                    (3, 3, 5, 'Beautiful clock, perfect for my living room.', 1, 1);

                  -- Shopping Cart
                  INSERT INTO carts
                    (user_id, product_id, quantity, session_id)
                  VALUES
                    (2, 3, 1, 'session_123'),
                    (3, 1, 1, 'session_456');

                  -- Product Discounts
                  INSERT INTO product_discounts
                    (product_id, discount_type, discount_value, start_date, end_date, is_active)
                  VALUES
                    (1, 'percentage', 10.00, '2024-01-01 00:00:00', '2024-12-31 23:59:59', 1),
                    (2, 'fixed', 20.00, '2024-01-01 00:00:00', '2024-12-31 23:59:59', 1);

                  -- Add performance optimizations
                  ALTER TABLE products ADD INDEX idx_products_search (name, category_id, is_active);
                  ALTER TABLE orders ADD INDEX idx_orders_date_status (created_at, status);
                  ALTER TABLE reviews ADD INDEX idx_reviews_product_rating (product_id, rating);
                  ALTER TABLE products ADD INDEX idx_products_price_range (price, is_active);
                  ALTER TABLE orders ADD INDEX idx_orders_tracking (tracking_number, status);
                  ALTER TABLE orders ADD INDEX idx_orders_user_date (user_id, created_at);

                  -- Add data integrity improvements
                  ALTER TABLE products ADD CONSTRAINT chk_price_positive CHECK (price > 0);
                  ALTER TABLE products ADD CONSTRAINT chk_sale_price_valid CHECK (sale_price IS NULL OR sale_price < price);
                  ALTER TABLE products ADD CONSTRAINT chk_stock_positive CHECK (stock >= 0);

                  -- Add full-text search capabilities
                  ALTER TABLE products ADD FULLTEXT INDEX idx_products_search (name, description);
                  ALTER TABLE categories ADD FULLTEXT INDEX idx_categories_search (name, description);

                  -- Add soft delete functionality
                  ALTER TABLE products ADD COLUMN deleted_at TIMESTAMP NULL;
                  ALTER TABLE categories ADD COLUMN deleted_at TIMESTAMP NULL;
                  ALTER TABLE orders ADD COLUMN deleted_at TIMESTAMP NULL;

                  -- Add cache key columns
                  ALTER TABLE products ADD COLUMN cache_key VARCHAR
                  (32) AFTER updated_at;
                  ALTER TABLE categories ADD COLUMN cache_key VARCHAR
                  (32) AFTER updated_at;
