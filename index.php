<?php

require_once('./model/database.php');
require_once('./model/category_db.php');
require_once('./model/product_db.php');
require_once('./model/address_db.php');
require_once('./model/customer_db.php');
session_start();
$action = filter_input(INPUT_POST, 'action') ?: filter_input(INPUT_GET, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'home';
    }
}
// Example logic in index.php to set variables for header display
$isLoggedIn = isset($_COOKIE['user']);

// Determine what links to show based on user login status
if ($isLoggedIn) {
    $userLinks = '<a href="index.php?action=customer_page">Login</a><br>
                  <a href="index.php?action=customer_logout">Logout</a>';
} else {
    $userLinks = '<a href="index.php?action=customer_login">Login</a>';
}




switch ($action) {
    case 'home':
        $categories = get_categories();
        include('./home.php');
        break;

    case 'customer_login':
        $categories = get_categories();
        // Check if user cookie is set
        if (!isset($_COOKIE['user'])) {
            // Display the customer login page if user cookie is not set
            $categories = get_categories();
            include('./customer/customer_login.php');
        } else {
            // Display the customer page if user cookie is set
            include('./customer/customer.php');
        }
        break;

    case 'customer_logout':
        $categories = get_categories();
        // Delete the user cookie
        setcookie('user', '', time() - 3600, '/');
        // Display the home page

        include('./home.php');
        break;

    case 'customer_page':
        $email_address = filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL);
        $categories = get_categories();
        $states = get_states();
        if (isset($_COOKIE['user'])) {
            // If user cookie exists, get the email address from the cookie
            $email_address = $_COOKIE['user'];
        } else {
            // Retrieve the email address and password from either the $_GET or $_POST array
            $email_address = filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL) ?: filter_input(INPUT_GET, 'email_address', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password') ?: filter_input(INPUT_GET, 'password');
            $customer = get_customer_info_by_email_address($email_address);

            if (!$customer || !password_verify($password, $customer['password'])) {
                // If user cookie is not set and the password does not verify, include the customer login page
                echo '<script>';
                echo 'alert("Email or password entered is incorrect");';
                echo '</script>';
                include('./customer/customer_login.php');
            } else {
                // If the password was verified, set the cookie and display the customer page
                setcookie('user', $email_address, time() + 86400, '/');
            }
        }
        // Display the customer page with customer's information
        $billing_address = get_address($customer['billing_address_id']);
        $shipping_address = get_address($customer['shipping_address_id']);
        include('./customer/customer.php');
        break;

    case 'customer_logout':
        // Delete the user cookie
        setcookie('user', '', time() - 3600, '/'); // Assuming your cookie path is '/'
        // Display the home page
        $categories = get_categories();
        include('./home.php');
        break;

    case 'update_customer_info':

        $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
        $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
        $last_name = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
        $email_address = filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL);
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
        $confirm_password = trim(filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');

        $current_customer_info = get_customer_info($customer_id);
        $updated = [];

        if ($first_name && $first_name !== $current_customer_info['first_name']) {
            update_first_name($customer_id, $first_name);
            $updated['first_name'] = "First name updated successfully!";
        }

        if ($last_name && $last_name !== $current_customer_info['last_name']) {
            update_last_name($customer_id, $last_name);
            $updated['last_name'] = 'Last name updated successfully!';
        }

        if ($email_address && $email_address !== $current_customer_info['email_address']) {
            update_email_address($customer_id, $email_address);
            $updated['email_address'] = 'Email updated successfully!';
        }

        if ($password && $password !== $confirm_password) {
            $updated['confirm_password'] = "Password do not match";
        } else if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            if (!password_verify($password, $current_customer_info['password'])) {
                update_password($customer_id, $hashed_password);
                $updated['password'] = "Password updated successfully!";
            }
        }

        if (empty($updated)) {
            echo '<script>';
            echo 'alert("No form changes detected.");';
            echo '</script>';
        }

        // Retrieve information needed to display the customer page
        $categories = get_categories();
        $customer = get_customer_info($customer_id);
        $states = get_states();
        $billing_address = get_address($customer['billing_address_id']);
        $shipping_address = get_address($customer['shipping_address_id']);

        // Display the customer page
        include('./customer/customer.php');

        break;

    case 'update_billing_address':
        // Form data
        $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
        $address_id = filter_input(INPUT_POST, 'address_id', FILTER_VALIDATE_INT);
        $line1 = trim(filter_input(INPUT_POST, 'line1', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $line2 = trim(filter_input(INPUT_POST, 'line2', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $state = trim(filter_input(INPUT_POST, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $zip_code = trim(filter_input(INPUT_POST, 'zip_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $updated = [];
        $current_customer_info = get_customer_info($customer_id);
        $current_customer_address = get_address($address_id);

        if (($line1 && $line1 !== $current_customer_address['line1']) || ($line2 && $line2 !== $current_customer_address['line2']) || ($city && $city !== $current_customer_address['city']) || ($state && $state !== $current_customer_address['state']) || ($zip_code && $zip_code !== $current_customer_address['zip_code']) || ($phone && $phone !== $current_customer_address['phone'])
        ) {
            update_address($address_id, $line1, $line2, $city, $state, $zip_code, $phone);
            $updated['address'] = "Address update successful.";
        }

        // Retrieve information needed to display the customer page
        $categories = get_categories();
        $customer = get_customer_info($customer_id);
        $states = get_states();
        $billing_address = get_address($customer['billing_address_id']);
        $shipping_address = get_address($customer['shipping_address_id']);

        // Display the customer page
        include('./customer/customer.php');

        break;
    case 'update_shipping_address':
        // Form data
        $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
        $address_id = filter_input(INPUT_POST, 'address_id', FILTER_VALIDATE_INT);
        $line1 = trim(filter_input(INPUT_POST, 'line1', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $line2 = trim(filter_input(INPUT_POST, 'line2', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $state = trim(filter_input(INPUT_POST, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $zip_code = trim(filter_input(INPUT_POST, 'zip_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $current_customer_info = get_customer_info($customer_id);
        $current_customer_address = get_address($address_id);

        if (($line1 && $line1 !== $current_customer_address['line1']) || ($line2 && $line2 !== $current_customer_address['line2']) || ($city && $city !== $current_customer_address['city']) || ($state && $state !== $current_customer_address['state']) || ($zip_code && $zip_code !== $current_customer_address['zip_code']) || ($phone && $phone !== $current_customer_address['phone'])
        ) {
            update_address($address_id, $line1, $line2, $city, $state, $zip_code, $phone);
            $updated['address'] = "Address update successful.";
        }

        // Retrieve information needed to display the customer page
        $categories = get_categories();
        $customer = get_customer_info($customer_id);
        $states = get_states();
        $billing_address = get_address($customer['billing_address_id']);
        $shipping_address = get_address($customer['shipping_address_id']);

        // Display the customer page
        include('./customer/customer.php');

        break;

    case 'support':
        $categories = get_categories();
        include('./support.php');
        break;

    case 'shipping':
        $categories = get_categories();
        include('./shipping.php');
        break;

    case 'list_products':
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $category_id = ($category_id !== null && $category_id !== false) ? $category_id : 1;
        $categories = get_categories();
        $category_name = get_category_by_id($category_id)['category_name'];
        $products = get_products_by_category_id($category_id);
        include('./products/product_list.php');
        break;

    case 'guitars':
        $categories = get_categories();
        include('./products/guitars.php');
        break;

    default:
        $categories = get_categories();
        include('./home.php');
        break;
}
?>



