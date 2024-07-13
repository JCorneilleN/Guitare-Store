/********************************************************
* This script creates the database named my_guitar_shop 
*********************************************************/

DROP DATABASE IF EXISTS my_guitar_shop;
CREATE DATABASE my_guitar_shop;
USE my_guitar_shop;

-- create the tables for the database
CREATE TABLE customers (
    customer_id           INT                           AUTO_INCREMENT,
    email_address         VARCHAR(255)   NOT NULL       UNIQUE,
    password              VARCHAR(255)   NOT NULL,
    first_name            VARCHAR(60)    NOT NULL,
    last_name             VARCHAR(60)    NOT NULL,
    shipping_address_id   INT            NOT NULL,
    billing_address_id    INT            NOT NULL,
    CONSTRAINT customers_pk
        PRIMARY KEY (customer_id)
) ENGINE INNODB
;

CREATE TABLE state_tax_rates (
    state           CHAR(2),
    tax_rate        DECIMAL(4,2)            NOT NULL,
    CONSTRAINT state_tax_rates_pk
        PRIMARY KEY (state)
) ENGINE INNODB
;

CREATE TABLE shipping_costs (
    state           CHAR(2),
    shipping_cost   DECIMAL(8,2)            NOT NULL,
    CONSTRAINT state_tax_rates_pk
        PRIMARY KEY (state)
) ENGINE INNODB
;

CREATE TABLE addresses (
    address_id         INT                          AUTO_INCREMENT,
    customer_id        INT            NOT NULL,
    line1              VARCHAR(60)    NOT NULL,
    line2              VARCHAR(60)                  DEFAULT NULL,
    city               VARCHAR(40)    NOT NULL,
    state              VARCHAR(2)     NOT NULL,
    zip_code           VARCHAR(10)    NOT NULL,
    phone              VARCHAR(12)    NOT NULL,
    CONSTRAINT addresses_pk
        PRIMARY KEY (address_id),  
    CONSTRAINT addresses_fk_customers
        FOREIGN KEY (customer_id)
        REFERENCES customers (customer_id),
    CONSTRAINT addresses_fk_state_tax_rates
        FOREIGN KEY (state)
        REFERENCES state_tax_rates (state),
    CONSTRAINT addresses_fk_shipping_costs
        FOREIGN KEY (state)
        REFERENCES shipping_costs (state)
) ENGINE INNODB
;

CREATE TABLE orders (
    order_id           INT                          AUTO_INCREMENT,
    customer_id        INT            NOT NULL,
    order_date         DATETIME       NOT NULL,
    ship_date          DATETIME                     DEFAULT NULL,
    card_type          VARCHAR(50)    NOT NULL,
    card_number        CHAR(16)       NOT NULL,
    card_expires       CHAR(7)        NOT NULL,
    CONSTRAINT orders_fk
        PRIMARY KEY (order_id),
    CONSTRAINT orders_fk_customers
        FOREIGN KEY (customer_id)
        REFERENCES customers (customer_id)
) ENGINE INNODB
;

CREATE TABLE categories (
    category_id        INT                          AUTO_INCREMENT,
    category_name      VARCHAR(255)   NOT NULL      UNIQUE,
    CONSTRAINT categories_pk
        PRIMARY KEY (category_id)
) ENGINE INNODB
;

CREATE TABLE warehouses (
    warehouse_id        CHAR(5),
    wh_name             VARCHAR(20)     NOT NULL    UNIQUE,
    wh_addr_line_1      VARCHAR(60)     NOT NULL,
    wh_addr_line_2      VARCHAR(60)                 DEFAULT NULL,
    wh_city             VARCHAR(40)     NOT NULL,
    wh_state            CHAR(2)         NOT NULL,
    wh_zip_code         VARCHAR(9)      NOT NULL,
    wh_sq_footage       INT             NOT NULL,
    CONSTRAINT warehouses_pk
        PRIMARY KEY (warehouse_id)
) ENGINE INNODB
;

CREATE TABLE suppliers (
    supplier_id                 INT                         AUTO_INCREMENT,
    supplier_name               VARCHAR(20)     NOT NULL    UNIQUE,
    supplier_addr_line_1        VARCHAR(60)     NOT NULL,
    supplier_addr_line_2        VARCHAR(60)                 DEFAULT NULL,
    supplier_city               VARCHAR(40)     NOT NULL,
    supplier_state              CHAR(2)         NOT NULL,
    supplier_zip_code           VARCHAR(9)      NOT NULL,
    supplier_phone              CHAR(10)        NOT NULL,
    CONSTRAINT suppliers_pk
        PRIMARY KEY (supplier_id)
) ENGINE INNODB
;

CREATE TABLE products (
    product_id          VARCHAR(10),
    category_id         INT             NOT NULL,
    product_name        VARCHAR(255)    NOT NULL,
    description         TEXT            NOT NULL,
    list_price          DECIMAL(10,2)   NOT NULL,
    supplier_id         INT             NOT NULL,
    CONSTRAINT products_pk
        PRIMARY KEY (product_id),
    CONSTRAINT products_fk_categories
        FOREIGN KEY (category_id)
        REFERENCES categories (category_id),
    CONSTRAINT products_fk_suppliers
        FOREIGN KEY (supplier_id)
        REFERENCES suppliers (supplier_id)
) ENGINE INNODB
;

CREATE TABLE product_locations (
    prod_id             VARCHAR(10),
    wh_id               CHAR(5),
    qty_on_hand         INT             NOT NULL,
    eoq                 INT             NOT NULL,
    CONSTRAINT product_locations_pk
        PRIMARY KEY (prod_id,wh_id),
    CONSTRAINT product_locations_fk_products
        FOREIGN KEY (prod_id)
        REFERENCES products(product_id),
    CONSTRAINT product_locations_fk_warehouses
        FOREIGN KEY (wh_id)
        REFERENCES warehouses(warehouse_id)
) ENGINE INNODB
;

CREATE TABLE order_lines (
    order_id           INT,
    order_line_id      INT,
    product_id         VARCHAR(10)      NOT NULL,
    discount_amount    DECIMAL(6,2)     NOT NULL,
    quantity           INT              NOT NULL,
    CONSTRAINT order_items_pk
        PRIMARY KEY (order_id, order_line_id),
    CONSTRAINT items_fk_orders
        FOREIGN KEY (order_id)
        REFERENCES orders (order_id), 
    CONSTRAINT items_fk_products
        FOREIGN KEY (product_id)
        REFERENCES products (product_id)
) ENGINE INNODB
;

-- Add foreign keys for addresses
ALTER TABLE customers
    ADD CONSTRAINT customers_fk_addresses_billing
        FOREIGN KEY (billing_address_id)
        REFERENCES addresses (address_id),
        
    ADD CONSTRAINT customers_fk_addresses_shipping
        FOREIGN KEY (shipping_address_id)
        REFERENCES addresses (address_id)
;

-- Turn off referential integrity checks
SET FOREIGN_KEY_CHECKS=0;

-- Insert data into the tables
INSERT INTO customers VALUES
    (1, 'allan.sherwood@yahoo.com',     MD5('password1'), 'Allan',      'Sherwood',      1,  2),
    (2, 'barryz@gmail.com',             MD5('password2'), 'Barry',      'Zimmer',        3,  3),
    (3, 'christineb@solarone.com',      MD5('password3'), 'Christine',  'Brown',         4,  4),
    (4, 'david.goldstein@hotmail.com',  MD5('password4'), 'David',      'Goldstein',     5,  6),
    (5, 'erinv@gmail.com',              MD5('password5'), 'Erin',       'Valentino',     7,  7),
    (6, 'frankwilson@sbcglobal.net',    MD5('password6'), 'Frank Lee',  'Wilson',        8,  8),
    (7, 'gary_hernandez@yahoo.com',     MD5('password7'), 'Gary',       'Hernandez',     9, 10),
    (8, 'heatheresway@mac.com',         MD5('password8'), 'Heather',    'Esway',        11, 12)
;

INSERT INTO addresses VALUES
    (1, 1, '100 East Ridgewood Ave.',   '',         'Paramus',          'NJ', '07652', '2016534472'),
    (2, 1, '21 Rosewood Rd.',           '',         'Woodcliff Lake',   'NJ', '07677', '2016534472'),
    (3, 2, '16285 Wendell St.',         '',         'Omaha',            'NE', '68135', '4028962576'),
    (4, 3, '19270 NW Cornell Rd.',      '',         'Beaverton',        'OR', '97006', '5036541291'),
    (5, 4, '186 Vermont St.',           'Apt. 2',   'San Francisco',    'CA', '94110', '4152926651'),
    (6, 4, '1374 46th Ave.',            '',         'San Francisco',    'CA', '94129', '4152926651'),
    (7, 5, '6982 Palm Ave.',            '',         'Fresno',           'CA', '93711', '5594312398'),
    (8, 6, '23 Mountain View St.',      '',         'Denver',           'CO', '80208', '3039123852'),
    (9, 7, '7361 N. 41st St.',          'Apt. B',   'New York',         'NY', '10012', '2123352093'),
    (10, 7, '3829 Broadway Ave.',       'Suite 2',  'New York',         'NY', '10012', '2122391208'),
    (11, 8, '2381 Buena Vista St.',     '',         'Los Angeles',      'CA', '90023', '2137725033'),
    (12, 8, '291 W. Hollywood Blvd.',   '',         'Los Angeles',      'CA', '90024', '2133912938')
;

INSERT INTO state_tax_rates VALUES
    ('CA',7.5),
    ('NJ',7.0),
    ('NE',5.5),
    ('OR',0),
    ('CO',4.0),
    ('NY',4.0)
;
    
INSERT INTO shipping_costs VALUES
    ('CA',15091.02),
    ('NJ',12536.99),
    ('NE',6899.69),
    ('OR',11026.12),
    ('CO',8956.54),
    ('NY',14578.82)
;
    
INSERT INTO orders VALUES
    ( 1, 1, '2022-05-28 09:40:28', '2022-05-30 15:32:51', 'Visa',        '4111111111111111', '04/2025'),
    ( 2, 2, '2022-06-28 11:23:20', '2022-06-29 12:52:14', 'Visa',        '4012888888881881', '08/2023'),
    ( 3, 1, '2022-06-29 09:44:58', '2022-06-30 09:11:41', 'Visa',        '4111111111111111', '04/2025'),
    ( 4, 3, '2022-07-30 15:22:31', '2022-08-03 16:32:21', 'Discover',    '3782832246310005', '05/2022'),
    ( 5, 4, '2022-07-31 05:43:11', '2022-08-02 14:21:12', 'Visa',        '4111135369441111', '05/2025'),
    ( 6, 5, '2022-08-31 18:37:22', NULL,                  'Discover',    '6011111111111117', '12/2026'),
    ( 7, 6, '2022-09-01 23:11:12', '2022-09-03 10:21:35', 'MasterCard',  '5555555555554444', '08/2024'),
    ( 8, 7, '2022-09-02 11:26:38', '2022-09-06 15:26:42', 'Visa',        '4012888888881881', '08/2023'),
    ( 9, 4, '2022-09-03 12:22:31', '2022-09-08 10:12:45', 'Visa',        '4111135369441111', '05/2025'),
    (10, 1, '2023-01-03 13:42:51', '2023-01-07 08:31:22', 'Visa',        '4111111111111111', '04/2025'),
    (11, 2, '2023-01-16 09:27:41', NULL,                  'Visa',        '4012888888881881', '08/2023'),
    (12, 1, '2023-01-27 19:45:25', NULL,                  'Visa',        '4111111111111111', '04/2025'),
    (13, 4, '2023-02-03 12:36:58', NULL,                  'Visa',        '4111135369441111', '05/2025'),
    (14, 7, '2023-02-03 02:18:31', NULL,                  'Visa',        '4012888888881881', '08/2023')
;

INSERT INTO categories VALUES
    (1, 'Guitars'),
    (2, 'Basses'),
    (3, 'Drums'), 
    (4, 'Keyboards')
;

INSERT INTO products VALUES
    ('strat',       1, 'Fender Stratocaster', 'The Fender Stratocaster is...',       699.00,     2),
    ('les_paul',    1, 'Gibson Les Paul', 'This Les Paul guitar offers...',         1199.00,     1),
    ('sg',          1, 'Gibson SG', 'This Gibson SG electric guitar takes...',      2517.00,     1),
    ('fg700s',      1, 'Yamaha FG700S', 'The Yamaha FG700S  has...',                 489.99,     3),
    ('washburn',    1, 'Washburn D10S', 'The Washburn D10S guitar is...',            299.00,     4),
    ('rodriguez',   1, 'Caballero 11', 'The Caballero 11 classical guitar is....',   899.00,     10),
    ('precision',   2, 'Fender Precision', 'The Fender Precision delivers...',       799.99,     2),
    ('hofner',      2, 'Hofner Icon', 'The Hofner Icon makes...',                    499.99,     6),
    ('ludwig',      3, 'Ludwig Drum Set', 'This product includes...',                699.99,     7),
    ('tama',        3, 'Tama Drum Set', 'The Tama 5-piece Drum Set is...',           799.99,     10)
;

INSERT INTO order_lines VALUES
    ( 1, 1, 'strat',     '359.70', 1),
    ( 2, 1, 'fg700s',    '186.20', 3),
    ( 2, 2, 'sg',        '308.84', 1),
    ( 2, 3, 'rodriguez', '161.85', 1),
    ( 3, 1, 'les_paul',  '359.70', 2),
    ( 3, 2, 'washburn',    '0.00', 1),
    ( 4, 1, 'les_paul',    '0.00', 2),
    ( 5, 1, 'strat',     '209.70', 1),
    ( 5, 2, 'precision', '240.00', 1),
    ( 6, 1, 'rodriguez', '161.85', 1),
    ( 7, 1, 'les_paul',  '359.70', 2),
    ( 7, 2, 'washburn',    '0.00', 1),
    ( 7, 3, 'les_paul',    '0.00', 2),
    ( 8, 1, 'strat',     '209.70', 1),
    ( 9, 1, 'precision', '240.00', 1),
    (10, 1, 'ludwig',    '210.00', 4),
    (11, 1, 'tama',      '120.00', 1),
    (12, 1, 'ludwig',    '210.00', 4),
    (13, 1, 'tama',      '120.00', 1),
    (14, 1, 'tama',      '120.00', 1),
    (14, 2, 'strat',     '209.70', 1)
;

INSERT INTO suppliers VALUES
    ( 1, 'Gibson',       '209 10th Ave South',       'Suite 460',    'Nashville',     'TN', '37203', '8004442766'),
    ( 2, 'Fender',       '17600 N. Perimeter Drive', 'Suite 100',    'Scottsdale',    'AZ', '85255', '8008569801'),
    ( 3, 'Yamaha',       '6600 Orangethorpe Ave.',   '',             'Buena Park',    'CA', '90620', '7145229000'),
    ( 4, 'Washburn',     '1000 Corporate Grove Dr.', '',             'Buffalo Grove', 'IL', '60089', '8008776863'),
    ( 5, 'Rodriguez',    '929 Myers St.',            '',             'Richmond',      'VA', '23230', '8043586324'),
    ( 6, 'Hofner',       'Egerlandstrasse 38',       '',             'Baiersdorf',    'GE', '91083', '0913377580'),
    ( 7, 'Ludwig',       '2806 Mason St.',           '',             'Monroe',        'NC', '28110', '7042896459'),
    ( 8, 'Tama',         '1726 Winchester Rd.',      '',             'Bensalem',      'PA', '19020', '2156388670'),
    ( 9, 'Drum Workshop','3450 Lunar Court',         '',             'Oxnard',        'CA', '93030', '8004537867'),
    (10, 'Breedlove',    '61573 American Loop',      '',             'Bend',          'OR', '97702', '8778004848')
    
;

INSERT INTO warehouses VALUES
    ('BA002', 'West Coast Warehouse', '400 Industrial Way',       '',             'Oakland',       'CA', '94621', 80000),
    ('CT432', 'Missouri Warehouse',   '1800 Industrial Parkway',  '',             'Chesterfield',  'MO', '63017', 110000),
    ('TE852', 'East Coast Warehouse', '18879 153th Ave',          '',             'Westchester',   'NY', '10598', 115000)
;

INSERT INTO product_locations VALUES
    ('strat',       'BA002',  5, 2),
    ('strat',       'CT432',  3, 1),
    ('strat',       'TE852',  4, 2),
    ('les_paul',    'BA002',  6, 3),
    ('les_paul',    'CT432',  1, 5),
    ('les_paul',    'TE852',  5, 4),
    ('sg',          'BA002',  4, 1),
    ('sg',          'CT432',  5, 2),
    ('sg',          'TE852',  3, 3),
    ('fg700s',      'BA002',  4, 2),
    ('fg700s',      'TE852',  0, 4),
    ('washburn',    'BA002',  9, 3),
    ('washburn',    'CT432',  5, 3),
    ('rodriguez',   'BA002',  8, 4),
    ('rodriguez',   'CT432',  7, 3),
    ('rodriguez',   'TE852',  9, 4),    
    ('precision',   'BA002',  3, 1),
    ('precision',   'CT432',  0, 2),
    ('precision',   'TE852',  2, 1),    
    ('hofner',      'CT432',  3, 3),
    ('hofner',      'TE852',  4, 3),    
    ('ludwig',      'BA002',  2, 1),
    ('ludwig',      'TE852',  5, 4),    
    ('tama',        'BA002',  8, 5),
    ('tama',        'TE852',  9, 6)
;

SET FOREIGN_KEY_CHECKS=1;

DROP USER IF EXISTS 'CS351user'@'localhost';

CREATE USER 'CS351user'@'localhost'
IDENTIFIED BY ''
;

GRANT ALL 
ON my_guitar_shop.* 
TO 'CS351user'@'localhost'
;

