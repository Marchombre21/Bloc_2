<?php
require 'header.php';
?>
<main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
    <figure class="text-center">
        <img class="w-25" src="./img/images/logo.png" alt="logo">
    </figure>
    <h1>En tant qu'administrateur vous pouvez : </h1>
    <div class="container">
        <div class="row">
            <a class="yellowButton my-2 my-lg-0 col" href="/changes">Modifier des produits</a>
        </div>
        <div class="row">
            <a class="yellowButton col" href="/new">Créer un nouveau compte utilisateur</a>
        </div>
        <div class="row">
            <a class="yellowButton my-2 col" href="/users">Gérer les utilisateurs</a>
        </div>
    </div>

</main>
</body>

</html>