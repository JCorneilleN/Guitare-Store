<?php

// address_db.php

require_once('database.php');

function get_address($address_id) {
    global $db;

    $query = 'SELECT * 
                  FROM addresses
                  WHERE address_id = :address_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':address_id', $address_id);
    $statement->execute();
    $address = $statement->fetch();
    $statement->closeCursor();

    return $address;
}

function update_address($address_id, $line1, $line2, $city, $state, $zip_code, $phone) {
    global $db;

    $query = 'UPDATE addresses
                  SET 
                    line1 = :line1, 
                    line2 = :line2, 
                    city = :city, 
                    state = :state, 
                    zip_code = :zip_code, 
                    phone = :phone 
                  WHERE address_id = :address_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':address_id', $address_id);
    $statement->bindValue(':line1', $line1);
    $statement->bindValue(':line2', $line2);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':zip_code', $zip_code);
    $statement->bindValue(':phone', $phone);
    $statement->execute();
    $statement->closeCursor();
}

function get_states() {
    global $db;

    $query = 'SELECT state
                  FROM state_tax_rates
                  ORDER BY state';

    $statement = $db->prepare($query);
    $statement->execute();
    $states = $statement->fetchAll();
    $statement->closeCursor();

    return $states;
}

?>

