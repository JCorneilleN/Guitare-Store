<!DOCTYPE html>

<html>
    <head>
        <title>Guitars</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/main.css">
        <link rel="stylesheet" href="./styles/guitars.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

    </head>
    <body>
        <?php include './view/header.php'; ?>
        <?php include './view/horizontal_nav_bar.php'; ?>


        <main>

            <?php include './view/aside.php'; ?>

            <section>
                <h2>Our Guitars</h2>
                <p>
                    Check out our fine collection of premiun guitars!
                </p>

                <div class="bxslider">
                    <div><img src="./images/guitars/Caballero11.png" title="Caballero11" /></div>
                    <div><img src="./images/guitars/FenderStratocaster.png" title="FenderStratocaster" /></div>
                    <div><img src="./images/guitars/GibsonLesPaul.png" title="GibsonLesPaul" /></div>
                    <div><img src="./images/guitars/GibsonSB.png" title="GibsonSB" /></div>
                    <div><img src="./images/guitars/WashburnD10S.png" title="WashburnD10S" /></div>
                    <div><img src="./images/guitars/YamahaFG700S.png" title="YamahaFG700S" /></div>
                </div>  

            </section>
        </main>
        <?php include './view/footer.php'; ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
        <script src="./scripts/guitars.js"></script>
        <script src="./scripts/date.js"></script>

    </body>
</html>
