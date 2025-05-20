<?php
session_start();
?>
 <!DOCTYPE html>
 <html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Application Wacdo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>

<main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
  <figure class="text-center">
    <img class="w-25" src="./img/images/logo.png" alt="logo">
  </figure>
  <h1>Veuillez vous connecter</h1>
  <?php
  if(isset($_SESSION["wrong"])){
    ?>
    <p><?= $_SESSION["wrong"]?></p>
    <?php
  }
  ?>
  <form action="" method="post">
    <fieldset class="d-flex justify-content-between">
      <label for="lastname">Nom: </label>
      <input name="lastname" value="<?= $_SESSION["loginPage"]["loginLastname"] ?? ""?>" type="text" id="lastname">
    </fieldset>
    <fieldset class="d-flex justify-content-between">
      <label for="firstname">Prénom: </label>
      <input name="firstname" value="<?= $_SESSION["loginPage"]["loginFirstname"] ?? ""?>" type="text" id="firstname">
    </fieldset>
    <fieldset class="d-flex justify-content-between">
      <label for="password">Mot de passe: </label>
      <input name='password' value="<?= $_SESSION["loginPage"]["loginPassword"] ?? ""?>" type="password" id="password">
    </fieldset>
  <input class="yellowButton mt-3" type="submit" value="Se connecter">
  </form>
</main>
</body>

</html>