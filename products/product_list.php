<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>The Guitar Store Products</title>
        <link rel="stylesheet" href="./styles/main.css">
        <link rel="stylesheet" href="./styles/products.css">
    </head>
    <body>
        <?php include './view/header.php'; ?>
        <?php include './view/horizontal_nav_bar.php'; ?>
        <main>
            <?php include './view/aside.php'; ?>
            <section>
                <h2>Product List</h2>
                <form action="index.php?" method="post">
                    <input type="hidden" name="action" value="list_products">
                    <select name="category_id" id="category_id">
                        <option value="" hidden>Select Category</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value='<?php echo $category['category_id']; ?>' <?php echo ($category_id == $category['category_id']) ? 'selected' : ''; ?>>
                                <?php echo $category['category_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span><==</span>
                    <input type="submit" value="Choose"><!-- updates the product list table and the header name -->
                </form>
                <?php if (!empty($category_name)) : ?>
                    <h3><?php echo $category_name; ?></h3>
                <?php else : ?>
                    <h3>[category]</h3>
                <?php endif; ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)) : ?>
                            <tr>
                                <td colspan="5">Out of stock</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($products as $product) : ?>
                                <tr>
                                    <td><?php echo $product['product_id']; ?></td>
                                    <td><?php echo $product['product_name']; ?></td>
                                    <td><?php echo $product['list_price']; ?></td>
                                    <td>
                                        <form action="index.php" method="get">
                                            <input type="hidden" name="action" value="edit_product">
                                            <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                                            <input type="submit" value="Edit">
                                        </form>
                                    </td>
                                    <td>
                                        <form action="index.php" method="get">
                                            <input type="hidden" name="action" value="delete_product">
                                            <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                                            <input type="submit" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <br><br>
                <p><a href="index.php?action=add_product">Add Product</a></p>
            </section>
        </main>
        <?php include './view/footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="./scripts/support.js"></script>
        <script src="./scripts/date.js"></script>
    </body>
</html>