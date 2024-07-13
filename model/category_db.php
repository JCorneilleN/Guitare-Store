<?php

require_once('database.php');

function get_categories() {
    global $db;

    $query = 'SELECT * 
                  FROM categories 
                  ORDER BY category_id';

    $statement = $db->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();
    $statement->closeCursor();

    return $categories;
}

function delete_category($categoryID) {
    global $db;

    $query = 'DELETE 
                  FROM categories 
                  WHERE category_id = :category_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $categoryID);
    $success = $statement->execute();
    $statement->closeCursor();

    return $success;
}

function add_category($categoryName) {
    global $db;

    $query = 'INSERT 
                  INTO categories (category_name) 
                  VALUES (:category_name)';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_name', $categoryName);
    $success = $statement->execute();
    $statement->closeCursor();

    return $success;
}

function update_category($categoryID, $categoryName) {
    global $db;

    $query = 'UPDATE categories 
                  SET category_name = :category_name 
                  WHERE category_id = :category_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_name', $categoryName);
    $statement->bindValue(':category_id', $categoryID);
    $success = $statement->execute();
    $statement->closeCursor();

    return $success;
}

function get_category_by_id($categoryID) {
    global $db;

    $query = 'SELECT * 
                  FROM categories 
                  WHERE category_id = :category_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $categoryID);
    $statement->execute();
    $category = $statement->fetch();
    $statement->closeCursor();

    return $category;
}

function get_category_by_name($categoryName) {
    global $db;

    $query = 'SELECT * 
                  FROM categories
                  WHERE category_name = :category_name';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_name', $categoryName);
    $statement->execute();
    $category = $statement->fetch();
    $statement->closeCursor();

    return $category;
}

function is_category_empty($categoryID) {
    global $db;

    $query = 'SELECT COUNT(*)
                  FROM products
                  WHERE category_id = :category_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $categoryID);
    $statement->execute();
    $productCount = $statement->fetchColumn();
    $statement->closeCursor();

    return $productCount == 0;
}
?>


