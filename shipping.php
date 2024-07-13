<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>The Guitar Store</title>
        <link rel="stylesheet" href="./styles/main.css">
        <link rel="stylesheet" href="./styles/shipping.css">
    </head>
    <body> 

        <?php include('./view/header.php'); ?>

        <?php include './view/horizontal_nav_bar.php'; ?>

        <main>
            <?php include('./view/aside.php'); ?>
            <section>
                <h2>Shipping Costs</h2>
                <div>
                    <label for="productCost">Product Cost:</label>
                    <input type="text" id="productCost">
                    <button id="calculateBtn">Calculate</button>
                </div>

                <div>
                    <label for="totalCost">Total Cost:</label>
                    <input type="text" id="totalCost" disabled>
                </div>


            </section>
        </main>
        <?php include('./view/footer.php'); ?>
        <script src="./scripts/shipping.js"></script>
        <script src="./scripts/date.js"></script>
    </body>
</html>
