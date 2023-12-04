<!DOCTYPE html>
<html lang="fr">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Webfiles/CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,300&display=swap" rel="stylesheet">
    <title>Inscription</title>
</head>
<body>
    <?php require_once("./views/require/header.php"); ?>
    <main>
        <section>
            <form id="reg-form" action="<?= URL ?>user/rv" class="form" method="post">
                <div class="title">Inscription</div>
                    <div id="subtitle" class="subtitle"></div>
                <div class="input-container ic1">
                    <input id="login" name="login" class="input" type="text" placeholder=" " autocomplete="off" />
                    <div class="cut cut-short"></div>
                    <label for="login" class="placeholder">Login</label>
                </div>
                <div class="input-container ic1">
                    <input id="firstname" name="firstname" class="input" type="text" placeholder=" " autocomplete="off" />
                    <div class="cut"></div>
                    <label for="firstname" class="placeholder">Prénom</label>
                </div>
                <div class="input-container ic2">
                    <input id="lastname" name="lastname" class="input" type="text" placeholder=" " autocomplete="off" />
                    <div class="cut cut-short"></div>
                    <label for="lastname" class="placeholder">Nom</label>
                </div>
                <div class="input-container ic2">
                  <input id="password" name="password" class="input" type="password" placeholder=" " autocomplete="off" />
                  <div class="cut cut-adjusted"></div>
                  <label for="password" class="placeholder">Mot de passe</label>
                </div>
                <button type="submit" name="submit" class="submit">S'inscrire</button>
            </form>
        </section>
    </main>
</body>
<script defer src="../Js/RegForm.js"></script>
</html>