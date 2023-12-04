<?php       
    if (!($_SESSION['login'])){
        header('location: ../home'); 
    }

    require_once "./models/Task/TaskManager.php";
    $taskManager = new TaskManager;

     // requete pour recuperer l'id du projet qui est dans l'URL

     $current_url = $_SERVER['REQUEST_URI']; // on prend l'URL
     $segments = explode('/', $current_url); // on divise l'URL en segments
     $index = array_search('v', $segments);  // l'id est le segment après v
 
     if ($index !== false && isset($segments[$index + 1])) {
         $id_project = $segments[$index + 1]; // On recuprère l'id du projet
     }

    $myTasks = $taskManager->getTasksByProjectId($id_project); // on récupère les tasks de l'utilisateur à partir de l'id project
    $myTodos = $taskManager->getTodoTasksByProjectId($id_project);
    // var_dump($myTodos);
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
    <script defer src="/super-reminder/Js/Task.js"></script>
    <title>Liste des tâches - <?= $_SESSION['login'] ?></title>
</head>
    <body>
        <?php require_once("./views/require/header.php"); ?>
     
        <main>

            <div class="container-task">
                <h2 class="help-task-msg">Guide</h2>
                <p>
                    Le bouton bleu permet de démarrer une nouvelle tâche, le vert de la finir et le rouge la supprimer.
                    Vous pouvez ajouter une tâche sur le formulaire ci-dessous
                <p>
            </div>
            
                <div class="add-task-form" id="add-task-form" method="post" action="<?= URL ?>task/ta">
                    <h2>Ajouter une tâche</h2>
                    <form id="task-form-add" class="task-form-add">
                        <label for="task-title">Titre</label>
                        <input type="text" id="task-title" name="task-title" autocomplete="off">

                        <label for="task-description">Description</label>
                        <input type="text" id="task-description" name="task-description" autocomplete="off">
                        
                        <input type="hidden" id="id-project" name="identifier_project" value="<?= intval($id_project); ?>">
                        <input type="hidden" name="identifier_user" value="<?= $_SESSION['id_user']; ?>">

                        <button type="submit">Ajouter</button>
                        <div class="subtitle" id="add-task-subtitle"></div>
                    </form>
                </div>

            <h2 class="h2-task">Mes tâches</h2>

            <div class="container-tasks">
                <div id="block-todo" class="block">
                    <h2>A faire</h2>
                        <ul id="ul-todo">   
                        </ul>
                </div>
                <div id="block-inprogress" class="block">
                    <h2>En cours</h2>
                        <ul id="ul-progress">
                            
                        </ul>
                </div>
                <div id="block-done" class="block">
                    <h2>Finies</h2>
                        <ul id="ul-done">
                        </ul>
                </div>
            </div>
        </main>
    </body>
</html>