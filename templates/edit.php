<?php
require 'header.php';

if ($datas === [] && !isset($_GET["add"])) {
    ?>
    <h1>Cet élément n'a pas été trouvé dans la base de donnée</h1>
    <?php
} else {
    if (isset($_GET["id"])) {
        $_SESSION["edit"]["id"] = $_GET["id"];
        ?>
        <main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
            <figure class="text-center">
                <img class="w-25" src="/img/images/logo.png" alt="logo">
            </figure>
            <h1>Modifiez les champs que vous souhaitez</h1>
            <?php
            if (isset($_SESSION["edit"]["errors"])) {
                ?>
                <p class="text-danger"> <?= $_SESSION["edit"]["errors"] ?></p>
                <?php
            }
            ?>
            <form action="edit/target/user" method="POST" class="container">
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
    } else if (isset($_GET["name"]) && $_GET["name"] != "description") {
        ?>
            <main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
                <figure class="text-center">
                    <img class="w-25" src="/img/images/logo.png" alt="logo">
                </figure>
                <h1>Modifiez les champs que vous souhaitez</h1>
                <?php
                if (isset($_SESSION["changes"]["errors"])) {
                    ?>
                    <p class="text-danger"> <?= $_SESSION["changes"]["errors"] ?></p>
                <?php
                }
                
                //enctype="multipart/form-data" nécessaire à tout formulaire qui veut envoyer des fichiers.
                ?>
                <a class="yellowButton text-nowrap my-2 d-block" onclick="return confirm('Êtes-vous sûr ?');" href="index.php?page=edit&target=delete&id=<?= $datas["id"] ?>">Supprimer complètement ce produit</a>
                <form action="/edit/target/product/id/<?= $datas["id"] ?>" enctype="multipart/form-data" method="POST"
                    class="container">
                    <div class="row row-cols-1">
                        <div class="col form-create">
                            <label for="image">Image : </label>
                            <input type="file" name="image" id="image" accept="image/*">
                        </div>
                        <div class="col form-create">
                            <label for="name">Nom du produit : </label>
                            <input type="text" name="name" id="name" value="<?= $_SESSION["changes"]["name"] ?? $datas["name"] ?>">
                        </div>
                        <div class="col form-create">
                            <label for="price">Prix : </label>
                            <input type="number" name="price" id="price" min="0" step="0.01"
                                value="<?= $_SESSION["changes"]["price"] ?? $datas["price"] ?>">
                        </div>
                        <div class="col form-create">
                            <label for="available">Disponible : </label>
                            <select name="available" id="available">
                                <option <?= $datas["available"] === 1 ? "selected" : "" ?> value="1">Oui</option>
                                <option <?= $datas["available"] === 0 ? "selected" : "" ?> value="0">Non</option>
                            </select>
                        </div>
                        <input class="yellowButton" type="submit" value="Appliquer les modifications">
                    </div>


                </form>
            </main>
        <?php
    } else if (isset($_GET["name"]) && $_GET["name"] === "description") {
        ?>
                <main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
                    <figure class="text-center">
                        <img class="w-25" src="/img/images/logo.png" alt="logo">
                    </figure>
                    <h1>Écrivez une courte description (max 150 caractères)</h1>
                <?php
                if (isset($_SESSION["changes"]["errors"])) {
                    ?>
                        <p class="text-danger"> <?= $_SESSION["changes"]["errors"] ?></p>
                <?php
                }

                ?>
                    <form action="edit/target/description" method="POST" class="container">
                        <div class="row my-5">
                            <textarea class="col" name="description" id="description"
                                maxlength="150"><?= $datas["description"] ?></textarea>
                        </div>
                        <div class="row">
                            <input class="col yellowButton" type="submit" value="Valider la description">
                        </div>
                    </form>
                </main>
        <?php
    } else if (isset($_GET["add"]) && $_GET["add"] === "product") {
        ?>
        <main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
                <figure class="text-center">
                    <img class="w-25" src="/img/images/logo.png" alt="logo">
                </figure>
                <h1>Remplissez tous les champs</h1>
                <?php
                if (isset($_SESSION["changes"]["errors"])) {
                    ?>
                    <p class="text-danger"> <?= $_SESSION["changes"]["errors"] ?></p>
                <?php
                }
                
                ?>
                <form action="edit/target/addProduct" enctype="multipart/form-data" method="POST"
                    class="container">
                    <div class="row row-cols-1">
                        <div class="col form-create">
                            <label for="image">Image : </label>
                            <input type="file" name="image" id="image" accept="image/*">
                        </div>
                        <div class="col form-create">
                            <label for="name">Nom du produit : </label>
                            <input type="text" name="name" id="name" value="<?= $_SESSION["changes"]["name"] ?? "" ?>">
                        </div>
                        <div class="col form-create">
                            <label for="price">Prix : </label>
                            <input type="number" name="price" id="price" min="0" step="0.01"
                                value="<?= $_SESSION["changes"]["price"] ?? "" ?>">
                        </div>
                        <div class="col form-create">
                            <label for="available">Disponible : </label>
                            <select name="available" id="available">
                                <option value="1">Oui</option>
                                <option value="0">Non</option>
                            </select>
                        </div>
                        <input class="yellowButton" type="submit" value="Ajouter le produit">
                    </div>


                </form>
            </main>
            <?php
    }

}
?>