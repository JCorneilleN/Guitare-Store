<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>The Guitar Store</title>
        <link rel="stylesheet" href="./styles/main.css">
        <link rel="stylesheet" href="./styles/customer_login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        

    </head>
    <body> 

        <?php include('./view/header.php'); ?>

        <?php include './view/horizontal_nav_bar.php'; ?>

        <main>
            <?php include './view/aside.php'; ?>
            <section>


                <h2>Customer Login</h2>
<form action="index.php" method="post">
    <input type="hidden" name="action" value="customer_page" />
    <div class="form-group">
        <label for="email_address">Email Address:</label>
        <input type="email" name="email_address" required value="<?php echo isset($_POST['email_address']) ? htmlspecialchars($_POST['email_address']) : ''; ?>" class="longer-input"/>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" autocomplete="current-password" required class="longer-input" id="id_password">
        <i class="far fa-eye" id="togglePassword"></i>
    </div>
    <div>
        <input type="submit" value="Login" />
        <input type="button" value="Cancel" onclick="window.location.href = 'index.php'" />
    </div>
</form>



            </section>
        </main>
        <?php include('./view/footer.php'); ?>

        <script src="./scripts/date.js"></script>
        <script src="./scripts/customer_login.js"></script>
    </body>
</html>

