<?php
require 'header.php';
?>
<main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
    <figure class="text-center">
        <img class="w-25" src="/img/images/logo.png" alt="logo">
    </figure>
    <form action="" method="POST" class="col">
    <?php

    if (!isset($_GET["token"])) {
        if(isset($_SESSION["send"])){
            ?>
            <p class="text-success"><?=$_SESSION["send"]?></p>
            <?php
        }
        ?>
        <div class="row row-cols-1 g-3">
            <div class="col">
                <h1 class="fw-bold">Réinitialiser le mot de passe</h1>
            </div>
            <div class="col">
                <h4 class="mb-5">Pour réinitialiser votre mot de passe, entrez l'email de votre compte.</h4>
            </div>
            <?php
            if (isset($_SESSION["wrongEmail"])) {
                ?>
                <p class="errors"> <?= $_SESSION["wrongEmail"] ?></p>
                <?php
            }
            ?>
            <input class="col" type="email" name="email" id="inputEmail"
                value="<?= $_SESSION["resetPage"]["resetEmail"] ?? "" ?>" placeholder="Email" aria-label="Email">
            <div class="col p-0">
                <input class="yellowButton" type="submit" value="Envoyer">
            </div>
            <div class="col">
                <p>Nous vous enverrons un lien pour réinitialiser votre mot de passe</p>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="row row-cols-1 g-3">
            <?php
            if (isset($_SESSION["newErrors"]["creation"])) {
                ?>
                <p class="errors"> <?= $_SESSION["newErrors"]["creation"] ?></p>
                <?php
            }
            if (isset($_SESSION["newErrors"]["empty"])) {
                ?>
                <p class="errors"><?= $_SESSION["newErrors"]["empty"] ?></p>
                <?php
            }
            ?>

            <div class="position-relative d-flex p-0">
                <input class="col" type="password" name="password" id="password"
                    value="<?= $_SESSION["newPage"]["newPassword"] ?? "" ?>" placeholder="Mot de passe"
                    aria-label="Mot de passe">
                <button type="button" class="togglePassword"><img src="/img/images/eye-fill.svg" alt=""></button>
            </div>
            <?php
            if (isset($_SESSION["newErrors"]["password"]) && !isset($_SESSION["newErrors"]["empty"])) {
                ?>
                <p class="errors"><?= $_SESSION["newErrors"]["password"] ?></p>
                <?php
            }
            ?>
            <div class="position-relative d-flex p-0">
                <input class="col" type="password" name="confirmPassword" id="confirmPassword"
                    value="<?= $_SESSION["newPage"]["newconfirmPassword"] ?? "" ?>"
                    placeholder="Confirmation du mot de passe" aria-label="Confirmation du mot de passe">
                <button type="button" class="togglePassword"><img src="/img/images/eye-fill.svg" alt=""></button>
            </div>
            <?php
            if (isset($_SESSION["newErrors"]["confirmPassword"]) && !isset($_SESSION["newErrors"]["empty"])) {
                ?>
                <p class="errors"><?= $_SESSION["newErrors"]["confirmPassword"] ?></p>
                <?php
            }
            ?>
            <div class="col p-0">
                <input class="yellowButton" type="submit" value="Confirmer le nouveau mot de passe">
            </div>
        </div>
        <?php
    }
    ?>

    </form>
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