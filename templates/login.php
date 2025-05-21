<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Application Wacdo</title>
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>

  <main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
    <figure class="text-center">
      <img class="w-25" src="./img/images/logo.png" alt="logo">
    </figure>
    <?php
    if (isset($_SESSION["invalid"])) {
      ?>
      <p class="errors"> <?= $_SESSION["invalid"] ?></p>
      <?php
    }
    ?>
    <h1>Veuillez vous connecter</h1>
    <?php
    if (isset($_SESSION["wrong"])) {
      ?>
      <p><?= $_SESSION["wrong"] ?></p>
      <?php
    }
    ?>
    <form action="" method="post">
      <fieldset class="d-flex justify-content-between">
        <label for="lastname">Nom: </label>
        <input name="lastname" value="<?= $_SESSION["loginPage"]["loginLastname"] ?? "" ?>" type="text" id="lastname">
      </fieldset>
      <fieldset class="d-flex justify-content-between">
        <label for="firstname">Prénom: </label>
        <input name="firstname" value="<?= $_SESSION["loginPage"]["loginFirstname"] ?? "" ?>" type="text"
          id="firstname">
      </fieldset>
      <fieldset class="d-flex justify-content-between">
        <label for="password">Mot de passe: </label>
        <div class=" d-flex p-0 position-relative">
          <input name='password' value="<?= $_SESSION["loginPage"]["loginPassword"] ?? "" ?>" type="password"
            id="password">
          <button type="button" class="togglePassword"><img src="img/images/eye-fill.svg" alt=""></button>
        </div>
      </fieldset>
      <input class="yellowButton mt-3" type="submit" value="Se connecter">
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