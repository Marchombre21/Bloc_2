<?php
require 'header.php';

if ($datas === []) {
    ?>
    <h1>Cet élément n'a pas été trouvé dans la base de donnée</h1>
    <?php
} else {
    if (isset($_GET["id"])) {
        $_SESSION["edit"]["id"] = $_GET["id"];
        ?>
        <main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
            <figure class="text-center">
                <img class="w-25" src="./img/images/logo.png" alt="logo">
            </figure>
            <h1>Modifiez les champs que vous souhaitez</h1>
            <?php
            if (isset($_SESSION["edit"]["errors"])) {
                ?>
                <p class="text-danger"> <?= $_SESSION["edit"]["errors"] ?></p>
                <?php
            }
            ?>
            <form action="index.php?page=edit&target=user" method="POST" class="container">
                <div class="row row-cols-1">
                    <div class="col form-create">
                        <label for="lastname">Nom : </label>
                        <input type="text" name="lastname" id="lastname"
                            value="<?= $_SESSION["edit"]["lastname"] ?? $datas["lastname"] ?>">
                    </div>
                    <div class="col form-create">
                        <label for="firstname">Prénom : </label>
                        <input type="text" name="firstname" id="firstname"
                            value="<?= $_SESSION["edit"]["firstname"] ?? $datas["firstname"] ?>">
                    </div>
                    <div class="col form-create">
                        <label for="email">Email : </label>
                        <input type="email" name="email" id="email"
                            value="<?= $_SESSION["edit"]["email"] ?? $datas["email"] ?>">
                    </div>
                    <div class="col form-create">
                        <label for="function">Fonction : </label>
                        <select name="function" id="function">
                            <option value="PREP" <?= $datas["function"] === "PREP" ? "selected" : "" ?>>Préparateur de commandes
                            </option>
                            <option value="ADMIN" <?= $datas["function"] === "ADMIN" ? "selected" : "" ?>>Administrateur</option>
                            <option value="ACC" <?= $datas["function"] === "ACC" ? "selected" : "" ?>>Accueil</option>
                        </select>
                    </div>
                    <input class="yellowButton" type="submit" value="Appliquer les modifications">
                </div>


            </form>
        </main>
        <?php
    }

}
?>