<?php 

$message = "";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Webfiles/CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,300&display=swap" rel="stylesheet">
    <title>Se connecter</title>
</head>
<body>
    <?php require_once("./views/require/header.php"); ?>
    <main>
        <section>
            <form id="login-form" action="<?= URL ?>user/lv" class="form" method="post">
                <div class="title">Connexion</div>
                    <div id="subtitle" class="subtitle"><?= $message ?></div>
                <div class="input-container ic1">
                    <input id="login" name="login" class="input" type="text" placeholder=" " autocomplete="off" />
                    <div class="cut"></div>
                    <label for="login" class="placeholder">Login</label>
                </div>
                <div class="input-container ic2">
                    <input id="password" name="password" class="input" type="password" placeholder=" " autocomplete="off" />
                    <div class="cut"></div>
                    <label for="lastname" class="placeholder">Mot de passe</label>
                </div>
                <button type="submit" name="submit" class="submit">Se Connecter</button>
            </form>
        </section>
    </main>
</body>
<script defer src="../Js/LogForm.js"></script>
</html>