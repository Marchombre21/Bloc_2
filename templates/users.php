<?php
require 'header.php';
?>


<main class="position-absolute absoluteCenter bg-light text-center p-5 rounded boxShadow">
    <figure class="text-center">
        <img class="w-25" src="./img/images/logo.png" alt="logo">
    </figure>
    <h1>Que voulez-vous faire?</h1>
    <button class="yellowButton text-nowrap mb-1"><a href="index.php?page=reset">Mot de passe oublié</a></button>
    <div class="container mw-100 overflow-auto text-center">
        <?php
        foreach ($users as $user) {
            ?>
            <div class="row row-cols-1">
                <p class="col fw-bold mt-1"><?= $user["firstname"] . " " . $user["lastname"] ?></p>
                <div class="col d-flex justify-content-center">
                    <button class="yellowButton"><a href="index.php?page=edit&id=<?=$user["id"]?>">Modifier</a></button>
                    <form action="index.php?page=users&function=delete" method="POST" onsubmit="return confirmDelete()">
                        <input name="id" type="hidden" value="<?= $user["id"] ?>">
                        <button type="submit" class="yellowButton mx-2">Supprimer</button>
                    </form>
                    
                </div>
            </div>

            <?php
        }
        ?>
    </div>

</main>
<script>
    const confirmDelete = () => {
        return confirm("Voulez-vous vraiment supprimer définitivement cet utilisateur?")
    }
</script>
</body>

</html>