-- Disable foreign key checks temporarily for schema recreation if needed
SET FOREIGN_KEY_CHECKS
= 0;

-- Drop existing tables (use with caution in production)
DROP TABLE IF EXISTS product_discounts;
DROP TABLE IF EXISTS carts;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS product_images;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS addresses;
-- New table
DROP TABLE IF EXISTS users;

-- 1. Users table
-- Storing basic user info and authentication details.
-- Removed phone and address to addresses table.
CREATE TABLE users
(
  id INT
  UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR
  (100) NOT NULL,
    email VARCHAR
  (100) NOT NULL,
    password VARCHAR
  (255) NOT NULL,
    role ENUM
  ('admin', 'user') NOT NULL DEFAULT 'user',
    email_verified_at TIMESTAMP NULL,
    last_login_at TIMESTAMP NULL,
    status ENUM
  ('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
    remember_token VARCHAR
  (100) NULL, -- Added for Laravel's "remember me" functionality
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
  UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP
  NULL, -- Soft delete for users

    UNIQUE KEY uk_users_email
  (email),
    INDEX idx_users_status
  (status),
    INDEX idx_users_email_verified
  (email_verified_at) -- For active/verified users
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  -- 2. Addresses table (NEW)
  -- Stores multiple addresses per user (shipping, billing, etc.)
  CREATE TABLE addresses
  (
    id INT
    UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    type ENUM
    ('shipping', 'billing', 'other') NOT NULL DEFAULT 'shipping',
    address_line1 VARCHAR
    (255) NOT NULL,
    address_line2 VARCHAR
    (255) NULL,
    city VARCHAR
    (100) NOT NULL,
    state VARCHAR
    (100) NULL, -- Can be NULL for some countries
    zip_code VARCHAR
    (20) NOT NULL,
    country VARCHAR
    (100) NOT NULL,
    phone_number VARCHAR
    (20) NULL, -- Specific to this address
    is_default TINYINT
    (1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
    UPDATE CURRENT_TIMESTAMP,

    INDEX idx_addresses_user (user_id),
    INDEX idx_addresses_type (type),
    FOREIGN KEY
    (user_id) REFERENCES users
    (id) ON
    DELETE CASCADE
) ENGINE=InnoDB
    DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


    -- 3. Categories table
    -- Added soft deletes and a cache_key.
    CREATE TABLE categories
    (
      id INT
      UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR
      (100) NOT NULL,
    slug VARCHAR
      (100) NOT NULL,
    description TEXT NULL, -- Changed to NULLABLE if not always required
    image VARCHAR
      (255) NULL, -- Changed to NULLABLE
    is_active TINYINT
      (1) DEFAULT 1,
    parent_id INT UNSIGNED NULL, -- Changed to NULLABLE
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
      UPDATE CURRENT_TIMESTAMP,
    cache_key VARCHAR(32)
      NULL, -- Added for caching strategies
    deleted_at TIMESTAMP NULL, -- Soft delete

    UNIQUE KEY uk_categories_slug
      (slug),
    INDEX idx_categories_parent
      (parent_id),
    INDEX idx_categories_active
      (is_active),
    FULLTEXT INDEX ft_categories_search
      (name, description), -- For full-text search
    FOREIGN KEY
      (parent_id) REFERENCES categories
      (id) ON
      DELETE
      SET NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

      -- 4. Products table
      -- Refined attribute column names, added soft deletes and cache_key.
      CREATE TABLE products
      (
        id INT
        UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    name VARCHAR
        (255) NOT NULL, -- Increased length for longer product names
    slug VARCHAR
        (255) NOT NULL, -- Increased length for longer slugs
    description TEXT NOT NULL,
    price DECIMAL
        (10,2) NOT NULL,
    sale_price DECIMAL
        (10,2) NULL, -- Changed to NULLABLE
    stock INT NOT NULL DEFAULT 0,
    sku VARCHAR
        (50) UNIQUE NULL, -- Changed to NULLABLE if not all products have SKU
    thumbnail_image VARCHAR
        (255) NULL, -- Renamed for clarity (main image)
    attributes JSON NULL, -- Renamed 'features' to 'attributes' for broader use
    is_active TINYINT
        (1) DEFAULT 1,
    weight_kg DECIMAL
        (8,2) NULL, -- Standardized unit (kg)
    dimensions_cm VARCHAR
        (50) NULL, -- Standardized unit (cm)
    material_type VARCHAR
        (100) NULL, -- Renamed 'material' for clarity
    min_order_quantity INT DEFAULT 1,
    max_order_quantity INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
        UPDATE CURRENT_TIMESTAMP,
    cache_key VARCHAR(32)
        NULL, -- Added for caching strategies
    deleted_at TIMESTAMP NULL, -- Soft delete

    UNIQUE KEY uk_products_slug
        (slug),
    INDEX idx_products_category
        (category_id),
    INDEX idx_products_active
        (is_active),
    INDEX idx_products_price
        (price),
    INDEX idx_products_stock
        (stock), -- Useful for low stock alerts
    FULLTEXT INDEX ft_products_search
        (name, description), -- For full-text search

    FOREIGN KEY
        (category_id) REFERENCES categories
        (id) ON
        DELETE CASCADE,
    CONSTRAINT chk_price_positive CHECK
        (price > 0),
    CONSTRAINT chk_sale_price_valid CHECK
        (sale_price IS NULL OR sale_price < price),
    CONSTRAINT chk_stock_non_negative CHECK
        (stock >= 0) -- Changed to non-negative
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        -- 5. Product Images table
        -- No significant changes, already well-designed.
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
          (255) NULL,
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

          -- 6. Orders table
          -- Linked to the new addresses table via address_id.
          -- Captured snapshots of name/phone for historical accuracy.
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
    shipping_address_id INT UNSIGNED NULL, -- Link to addresses table
    -- Snapshot of shipping details for historical record (even if address changes)
    shipping_full_name VARCHAR
            (255) NOT NULL,
    shipping_address_snapshot TEXT NOT NULL, -- Full formatted address at time of order
    shipping_phone_snapshot VARCHAR
            (20) NOT NULL,
    shipping_method VARCHAR
            (50) NULL,
    shipping_cost DECIMAL
            (10,2) DEFAULT 0.00,
    payment_method VARCHAR
            (50) NOT NULL,
    payment_status ENUM
            ('pending', 'paid', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
    payment_transaction_id VARCHAR
            (100) NULL, -- Renamed from payment_id for clarity
    tracking_number VARCHAR
            (100) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
            UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP
            NULL, -- Soft delete

    UNIQUE KEY uk_orders_number
            (order_number),
    INDEX idx_orders_user
            (user_id),
    INDEX idx_orders_status
            (status),
    INDEX idx_orders_payment_status
            (payment_status),
    INDEX idx_orders_tracking
            (tracking_number),
    INDEX idx_orders_user_date
            (user_id, created_at),
    INDEX idx_orders_date_status
            (created_at DESC, status), -- Useful for admin dashboards

    FOREIGN KEY
            (user_id) REFERENCES users
            (id) ON
            DELETE CASCADE,
    FOREIGN KEY (shipping_address_id)
            REFERENCES addresses
            (id) ON
            DELETE
            SET NULL
            -- If address is deleted, keep order history
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            -- 7. Order Items table
            -- No significant changes, already well-designed.
            CREATE TABLE order_items
            (
              id INT
              UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL
              (10,2) NOT NULL, -- Price at the time of purchase
    subtotal DECIMAL
              (10,2) NOT NULL, -- subtotal = quantity * price
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

              -- 8. Reviews table
              -- No significant changes, already well-designed.
              CREATE TABLE reviews
              (
                id INT
                UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    rating TINYINT NOT NULL,
    comment TEXT NULL,
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
    INDEX idx_reviews_product_rating (product_id, rating), -- For sorting/filtering by product and rating
    INDEX idx_reviews_approved (is_approved), -- For moderation panel

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

                -- 9. Cart Header (NEW for better cart management)
                CREATE TABLE carts
                (
                  id INT
                  UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NULL, -- NULL for guest carts
    session_id VARCHAR
                  (100) NULL, -- For guest users, store the session ID
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
                  UPDATE CURRENT_TIMESTAMP,

    -- Ensures a user has only one cart, and a session has only one cart (for guests)
    -- This key requires either user_id or session_id to be NOT NULL
    UNIQUE KEY uk_user_session_cart (user_id, session_id
                  ), -- This works if one is NULL and the other is unique
    INDEX idx_carts_user
                  (user_id),
    INDEX idx_carts_session
                  (session_id),

    FOREIGN KEY
                  (user_id) REFERENCES users
                  (id) ON
                  DELETE CASCADE
) ENGINE=InnoDB
                  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

                  -- 10. Cart Items (NEW - previously named 'carts')
                  -- Renamed and linked to the new 'carts' header table.
                  CREATE TABLE cart_items
                  (
                    id INT
                    UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cart_id INT UNSIGNED NOT NULL, -- Links to the carts header table
    product_id INT UNSIGNED NOT NULL,
    quantity INT NOT NULL,
    price_at_addition DECIMAL
                    (10,2) NOT NULL, -- Snapshot price when added to cart

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON
                    UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uk_cart_item_product (cart_id, product_id
                    ), -- A product can only be once in a given cart
    INDEX idx_cart_items_cart
                    (cart_id),
    INDEX idx_cart_items_product
                    (product_id),

    FOREIGN KEY
                    (cart_id) REFERENCES carts
                    (id) ON
                    DELETE CASCADE,
    FOREIGN KEY (product_id)
                    REFERENCES products
                    (id) ON
                    DELETE CASCADE
) ENGINE=InnoDB
                    DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


                    -- 11. Product Discounts table
                    -- No significant changes, already well-designed.
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
    INDEX idx_product_discounts_active_dates (is_active, start_date, end_date), -- For querying active discounts
    FOREIGN KEY
                      (product_id) REFERENCES products
                      (id) ON
                      DELETE CASCADE
) ENGINE=InnoDB
                      DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


                      -- Enable foreign key checks after schema recreation
                      SET FOREIGN_KEY_CHECKS
                      = 1;