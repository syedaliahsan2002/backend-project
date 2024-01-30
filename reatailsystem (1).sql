-- Customer Table
CREATE TABLE customer (
    customer_id INT(255) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(100) NOT NULL,
    phone_number INT(13) NOT NULL,
    address VARCHAR(255) NOT NULL,
    country TEXT NOT NULL,
    city TEXT NOT NULL,
    state TEXT NOT NULL,
    postal_code TEXT
);

-- Rider Table
CREATE TABLE rider (
    rider_id INT(200) PRIMARY KEY AUTO_INCREMENT,
    rider_name TEXT NOT NULL,
    rider_phone VARCHAR(12) NOT NULL,
    is_available TINYINT(1) DEFAULT 1
);

-- Order Table
CREATE TABLE `order` (
    order_id INT(200) PRIMARY KEY AUTO_INCREMENT,
    customer_id INT(255),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
    order_date DATE NOT NULL,
    payment_method VARCHAR(16) NOT NULL,
    rider_id INT(200),
    FOREIGN KEY (rider_id) REFERENCES rider(rider_id)
);

-- Product Table
CREATE TABLE product (
    product_id INT(200) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(256) NOT NULL,
    p_category VARCHAR(200) NOT NULL,
    image VARCHAR(256) NOT NULL,
    price INT(200) NOT NULL
);

-- Order Item Table
CREATE TABLE order_item (
    order_item_id INT(200) PRIMARY KEY AUTO_INCREMENT,
    order_id INT(200),
    FOREIGN KEY (order_id) REFERENCES `order`(order_id),
    quantity INT(200) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    product_id INT(200),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);