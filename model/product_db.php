<?php

require_once('database.php');

function get_products() {
    global $db;

    $query = 'SELECT * 
                FROM products O
                RDER BY product_id';

    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();

    return $products;
}

function search_products($keyword) {
    global $db;

    $query = 'SELECT * 
                FROM products 
                WHERE product_name 
                LIKE :keyword 
                OR description 
                LIKE :keyword 
                ORDER BY product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':keyword', '%' . $keyword . '%');
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();

    return $products;
}

function delete_product($productID) {
    global $db;

    $query = 'DELETE 
                FROM products
                WHERE product_id = :product_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $productID);
    $success = $statement->execute();
    $statement->closeCursor();

    return $success;
}

function add_product($categoryID, $productName, $description, $listPrice, $supplierID) {
    global $db;

    $query = 'INSERT INTO products (category_id, product_name, description, list_price, supplier_id)
              VALUES (:category_id, :product_name, :description, :list_price, :supplier_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $categoryID);
    $statement->bindValue(':product_name', $productName);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':list_price', $listPrice);
    $statement->bindValue(':supplier_id', $supplierID);
    $success = $statement->execute();
    $statement->closeCursor();

    return $success;
}

function update_product($productID, $categoryID, $productName, $description, $listPrice, $supplierID) {
    global $db;

    $query = 'UPDATE products
              SET category_id = :category_id,
                  product_name = :product_name,
                  description = :description,
                  list_price = :list_price,
                  supplier_id = :supplier_id
              WHERE product_id = :product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $categoryID);
    $statement->bindValue(':product_name', $productName);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':list_price', $listPrice);
    $statement->bindValue(':supplier_id', $supplierID);
    $statement->bindValue(':product_id', $productID);
    $success = $statement->execute();
    $statement->closeCursor();

    return $success;
}

function get_product_by_id($productID) {
    global $db;

    $query = 'SELECT * '
            . 'FROM products '
            . 'WHERE product_id = :product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $productID);
    $statement->execute();
    $product = $statement->fetch();
    $statement->closeCursor();

    return $product;
}

function get_products_by_category_id($categoryID) {
    global $db;

    $query = 'SELECT * 
             FROM products 
             WHERE category_id = :category_id 
             ORDER BY product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $categoryID);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();

    return $products;
}

function get_products_by_supplier($supplierID) {
    global $db;

    $query = 'SELECT * 
              FROM products 
              WHERE supplier_id = :supplier_id 
              ORDER BY product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':supplier_id', $supplierID);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();

    return $products;
}

function get_products_by_list_price_range($minListPrice, $maxListPrice) {
    global $db;

    $query = 'SELECT * 
              FROM products 
              WHERE list_price 
              BETWEEN :min_price AND :max_price 
              ORDER BY product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':min_price', $minListPrice);
    $statement->bindValue(':max_price', $maxListPrice);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();

    return $products;
}

function get_featured_products() {
    global $db;

    $query = 'SELECT * 
              FROM products 
              WHERE is_featured = 1 
              ORDER BY product_id';

    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();

    return $products;
}
?>

