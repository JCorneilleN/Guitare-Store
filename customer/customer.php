<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>The Guitar Store</title>
        <link rel="stylesheet" href="./styles/main.css">
        <link rel="stylesheet" href="./styles/customer.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    </head>
    <body> 

        <?php include('./view/header.php'); ?>

        <?php include './view/horizontal_nav_bar.php'; ?>

        <main>
            <?php include './view/aside.php'; ?>
            <section>

                <div class="CustomerInformation">
                    <h2>Customer Information</h2>
                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="update_customer_info" />
                        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer['customer_id'] ?? ''); ?>" required />



                        <div class="form-row">
                            <label for="first_name">First Name:</label>
                            <input type="text" name="first_name" value="<?php echo htmlspecialchars($customer['first_name'] ?? ''); ?>" required class="longer-input" />
                            <input type="text" name="confirmation" value="<?php echo isset($updated['first_name']) ? $updated['first_name'] : ''; ?>" readonly class="longer-input" /><br>
                        </div>
                        <div class="form-row">
                            <label for="last_name">Last Name:</label>
                            <input type="text" name="last_name" value="<?php echo htmlspecialchars($customer['last_name'] ?? ''); ?>" required class="longer-input" />
                            <input type="text" name="confirmation" value="<?php echo isset($updated['last_name']) ? $updated['last_name'] : ''; ?>" readonly class="longer-input" /><br>
                            <input type="text" name="confirmation_address" value="<?php echo isset($updated['address']) ? $updated['address'] : ''; ?>" readonly class="longer" /><br>
                        </div>

                        <div class="form-row">
                            <label for="email_address">Email:</label>
                            <input type="text" name="email_address" value="<?php echo htmlspecialchars($customer['email_address'] ?? ''); ?>" required class="longer-input" />
                            <input type="text" name="confirmation" value="<?php echo isset($updated['email_address']) ? $updated['email_address'] : ''; ?>" readonly class="longer-input" /><br>
                        </div>

                        <div class="form-row">
                            <label for="password">Password:</label>
                            <input type="password" name="password" autocomplete="current-password" class="longer-input" id="password">
                            <i class="far fa-eye toggle-password-icon" id="togglePassword" ></i>
                            <input type="text" name="confirmation" value="<?php echo isset($updated['password']) ? $updated['password'] : ''; ?>" readonly class="longer-input" /><br>
                        </div>

                        <div class="form-row">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" name="confirm_password" autocomplete="new-password" class="longer-input" id="confirm_password">
                            <i class="far fa-eye toggle-password-icon" id="toggleConfirmPassword"></i>
                             
                            <input type="text" name="confirmation" value="<?php echo isset($updated['confirm_password']) ? $updated['confirm_password'] : ''; ?>" readonly class="longer-input" /><br>
                       </div>

                        <button type="submit">Update Customer Information</button>
                      
                    </form>
                     </div> 
                         

                <div class="BillingAddress">
                    <h2>Billing Address</h2>
                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="update_billing_address"/>
                        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer['customer_id'] ?? ''); ?>" required/>
                        <input type="hidden" name="address_id" value="<?php echo htmlspecialchars($customer['billing_address_id'] ?? ''); ?>" required/>

                        <div class="form-row">
                            <label for="line1">Address Line 1:</label>
                            <input type="text" name="line1" value="<?php echo htmlspecialchars($billing_address['line1'] ?? ''); ?>" required class="longer-input"/><br>
                        </div>

                        <div class="form-row">
                            <label for="line2">Address Line 2:</label>
                            <input type="text" name="line2" value="<?php echo htmlspecialchars($billing_address['line2'] ?? ''); ?>"class="longer-input"/><br>
                        </div>

                        <div class="form-row">
                            <label for="city">City:</label>
                            <input type="text" name="city" value="<?php echo htmlspecialchars($billing_address['city'] ?? ''); ?>" required class="longer-input"/><br>
                        </div>

                        <div class="form-row">
                            <label for="state">State:</label>
                            <select name="state" required>
                                <?php
                                foreach ($states as $stateOption) :
                                    $selected = ($billing_address['state'] == $stateOption['state']) ? 'selected' : '';
                                    echo "<option value=\"{$stateOption['state']}\" $selected>{$stateOption['state']}</option>";
                                endforeach;
                                ?>
                            </select><br></div>

                        <div class="form-row">
                            <label for="zip_code">Zip Code:</label>
                            <input type="text" name="zip_code" value="<?php echo htmlspecialchars($billing_address['zip_code'] ?? ''); ?>" required class="longer-input"/>
                            <br></div>

                        <div class="form-row">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($billing_address['phone'] ?? ''); ?>" required class="longer-input"/><br>
                        </div>
                        <button type="submit">Update Billing Address</button>
                    </form>
                </div>

                <div class="ShippingAddress">
                    <h2>Shipping Address</h2>

                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="update_shipping_address" />
                        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer['customer_id'] ?? ''); ?>" required/>
                        <input type="hidden" name="address_id" value="<?php echo htmlspecialchars($customer['shipping_address_id'] ?? ''); ?>" required/>

                        <div class="form-row">
                            <label for="line1">Address Line 1:</label>
                            <input type="text" name="line1" value="<?php echo htmlspecialchars($shipping_address['line1'] ?? ''); ?>" required class="longer-input"/><br>
                        </div>

                        <div class="form-row">
                            <label for="line2">Address Line 2:</label>
                            <input type="text" name="line2" value="<?php echo htmlspecialchars($shipping_address['line2'] ?? ''); ?>"class="longer-input"/><br>
                        </div>

                        <div class="form-row">
                            <label for="city">City:</label>
                            <input type="text" name="city" value="<?php echo htmlspecialchars($shipping_address['city'] ?? ''); ?>" required class="longer-input"/><br>
                        </div>

                        <div class="form-row">
                            <label for="state">State:</label>
                            <select name="state" required>
                                <?php
                                foreach ($states as $stateOption) :
                                    $selected = ($shipping_address['state'] == $stateOption['state']) ? 'selected' : '';
                                    echo "<option value=\"{$stateOption['state']}\" $selected>{$stateOption['state']}</option>";
                                endforeach;
                                ?>
                            </select><br/></div>

                        <div class="form-row">
                            <label for="zip_code">Zip Code:</label>
                            <input type="text" name="zip_code" value="<?php echo htmlspecialchars($shipping_address['zip_code'] ?? ''); ?>" required class="longer-input"/>
                            <br></div>

                        <div class="form-row">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($shipping_address['phone'] ?? ''); ?>"required class="longer-input"/><br>
                        </div>

                        <button type="submit">Update Shipping Address</button>
                    </form> 
                </div>




            </section>
        </main>
        <?php include('./view/footer.php'); ?>

        <script src="./scripts/date.js"></script>
        <script src="./scripts/customers.js"></script>

    </body>
</html>
