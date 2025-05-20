<?php
require 'header.php';
if (isset($_GET["category"])) {
    ?>
    <main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
        <figure class="text-center">
            <img class="w-25" src="./img/images/logo.png" alt="logo">
        </figure>
        <h1>Que voulez-vous changer dans cette catégorie?</h1>

        <div class="container text-center overflow-auto">
            <div class="row">
                <a class="yellowButton" href="index.php?page=edit&name=description">Modifier la description</a>
            </div>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5">
                <?php
                foreach ($datas as $data) {
                    ?>
                    <div class="col text-center ">
                        <a href="index.php?page=edit&name=<?= $data["name"] ?>">
                            <figure>
                                <img src="/img<?= $data["image"] ?>" alt="image <?= $data["name"] ?>">
                                <figcaption><?= $data["name"] ?></figcaption>
                            </figure>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </main>
    <?php
} else {
    ?>
    <main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
        <figure class="text-center">
            <img class="w-25" src="./img/images/logo.png" alt="logo">
        </figure>
        <h1>Quelle catégorie voulez-vous changer?</h1>

        <div class="container mw-100 overflow-auto text-center">
            <?php
            foreach ($datas as $data) {
                ?>
                <div class="row row-cols-1 yellowButton">
                    <div class="col">
                        <a href="index.php?page=changes&category=<?= $data["id"] ?>&categoryName=<?= $data["name"] ?>"><?= $data["name"] ?></a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

    </main>

    <?php
}
?>
</body>

</html>