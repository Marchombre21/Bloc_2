<?php
require 'header.php';
?>
<main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
    <figure class="text-center">
        <img class="w-25" src="./img/images/logo.png" alt="logo">
    </figure>
    <h1>Veuillez rentrer les informations demandées</h1>
    <?php
    if (isset($_SESSION["errors"]["empty"])) {
        ?>
        <p class="errors"><?= $_SESSION["errors"]["empty"] ?></p>
        <?php
    }
    if (isset($_SESSION["creation"])) {
        ?>
        <p class="errors"><?= $_SESSION["creation"] ?></p>
        <?php
    }
    if (isset($_SESSION["exists"])) {
        ?>
        <p class="errors"><?= $_SESSION["exists"] ?></p>
        <?php
    }
    ?>
    <div class="container">
        <form action="" method="post">
            <div class="row">
                <div class="col form-create">
                    <label for="email">Email*</label>
                    <input type="email" name="email" id="email" value="<?= $_SESSION["create"]["email"] ?? "" ?>">
                    <?php
                    if (isset($_SESSION["errors"]["email"]) && !isset($_SESSION["errors"]["empty"])) {
                        ?>
                        <p class="errors"><?= $_SESSION["errors"]["email"] ?></p>
                        <?php
                    }
                    ?>
                </div>
                <div class="col form-create">
                    <label for="confirmEmail">Confirmer email*</label>
                    <input type="email" name="confirmEmail" id="confirmEmail"
                        value="<?= $_SESSION["create"]["confirmEmail"] ?? "" ?>">
                    <?php
                    if (isset($_SESSION["errors"]["confirmEmail"]) && !isset($_SESSION["errors"]["empty"])) {
                        ?>
                        <p class="errors"><?= $_SESSION["errors"]["confirmEmail"] ?></p>
                        <?php
                    }
                    ?> 
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col form-create">
                    <label for="password">Mot de passe*</label>

                    <div class="position-relative d-flex p-0">
                        <input class="w-100" type="password" name="password" id="password"
                            value="<?= $_SESSION["create"]["password"] ?? "" ?>">
                        <button type="button" class="togglePassword"><img src="img/images/eye-fill.svg" alt=""></button>
                    </div>
                    <?php
                    if (isset($_SESSION["errors"]["password"]) && !isset($_SESSION["errors"]["empty"])) {
                        ?>
                        <p class="errors"><?= $_SESSION["errors"]["password"] ?></p>
                        <?php
                    }
                    ?>
                </div>
                <div class="col form-create">
                    <label for="confirmPassword">Confirmer mot de passe*</label>
                    <div class="position-relative d-flex p-0">
                        <input class="w-100" type="password" name="confirmPassword" id="confirmPassword"
                            value="<?= $_SESSION["create"]["confirmPassword"] ?? "" ?>">
                        <button type="button" class="togglePassword"><img src="img/images/eye-fill.svg" alt=""></button>
                    </div>
                    <?php
                    if (isset($_SESSION["errors"]["confirmPassword"]) && !isset($_SESSION["errors"]["empty"])) {
                        ?>
                        <p class="errors"><?= $_SESSION["errors"]["confirmPassword"] ?></p>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col form-create">
                    <label for="firstname">Prénom*</label>
                    <input type="text" name="firstname" id="firstname"
                        value="<?= $_SESSION["create"]["firstname"] ?? "" ?>">
                </div>
                <div class="col form-create">
                    <label for="lastname">Nom*</label>
                    <input type="text" name="lastname" id="lastname"
                        value="<?= $_SESSION["create"]["lastname"] ?? "" ?>">
                </div>
            </div>
            <div class="row">
                    <div class="col form-create">
                        <label for="function">Fonction* : </label>
                        <select name="function" id="function">
                            <option value="PREP">Préparateur de commandes</option>
                            <option value="ADMIN">Administrateur</option>
                            <option value="ACC">Accueil</option>
                        </select>
                    </div>
            </div>
            <div class="row text-center mt-4">
                <p>*Champs obligatoires</p>
            </div>
            <div class="row">
                <div class="col-6 m-auto">
                    <input class="orangeButton yellowButton" type="submit" value="Envoyer">
                </div>

            </div>
        </form>
    </div>
</main>
<script>
    document.querySelectorAll(".togglePassword").forEach(element => {
        element.addEventListener("click", () => {
            const input = document.getElementById("password");
            input.type = input.type === "password" ? "text" : "password";
            const input2 = document.getElementById("confirmPassword");
            input2.type = input2.type === "password" ? "text" : "password";
        })
    });
</script>
</body>

</html>