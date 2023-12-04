<?php       
    if (!($_SESSION['login'])){
        header('location: ../home'); 
    }

    require_once "./models/Project/ProjectManager.php";
    $projectManager = new ProjectManager;
    $projectManager->loadProjects();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/super-reminder/Webfiles/CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,300&display=swap" rel="stylesheet">
    <script defer src="/super-reminder/Js/Project.js"></script>
    <title>Compte de <?= $_SESSION['login'] ?></title>
</head>
<body>
    <?php require_once("./views/require/header.php"); ?>
<main>
    <section>
        <table class="table">
            <thead>
                <th>N°</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Voir</th>
                <th>Supprimer</th>
            </thead>
            <tbody id="display-project">
                    
            </tbody>
        </table>
            <div id="delete-message" class="delete-project-message"></div> 
        <div class="flex">
            <form id="add-project-form" action="<?= URL ?>user/pa" class="form" method="post">
                <div class="title">Ajouter projet</div>
                    <div id="subtitle" class="subtitle"></div>
                <div class="input-container ic1">
                    <input id="title" name="title" class="input" type="text" placeholder=" " autocomplete="off" />
                    <div class="cut"></div>
                    <label for="title" class="placeholder">Titre</label>
                </div>
                <div class="input-container ic2">
                    <input id="description" name="description" class="input" type="text" placeholder=" " autocomplete="off" />
                    <div class="cut"></div>
                    <label for="description" class="placeholder">Description</label>
                </div>
                <input type="hidden" name="identifier" value="<?= $_SESSION['id_user']; ?>">
                <button type="submit" name="submit" class="submit">Ajouter</button>
            </form>
        </div>
    </section>
</main>
    
</body>
</html>