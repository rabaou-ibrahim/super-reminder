<?php
session_start(); 
define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http").
"://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/UsersController.php";
require_once "controllers/ProjectsController.php";
require_once "controllers/TasksController.php";

$userController = new UsersController;
$projectController = new ProjectsController;
$taskController = new TasksController;

try{
    if(empty($_GET['page'])){
        require "views/home.view.php";
    }
        else {
            $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
      
            switch($url[0]){
                case "home" : require "views/home.view.php";
                break;

                case "user";
                    if(empty($url[1])){
                        $userController->displayLogin();
                    } else if($url[1] === "l"){
                        $userController->displayLogin();                        
                    } else if($url[1] === "r"){
                        $userController->displayRegister();
                    } else if($url[1] === "rv"){
                        $userController->registerValidation();
                    } else if($url[1] === "lv"){
                        $userController->logInValidation();
                    } else if($url[1] === "p"){
                        $userController->displayProjects();
                    } else if($url[1] === "ev"){
                        $userController->editUserValidation();
                    } else if($url[1] === "lo"){
                        $userController->logOut();
                    }
                    else {
                        echo("La page n'existe pas");
                    }

                case "project";
                if(empty($url[1])){
                    $projectController->displayLogin();                      
                } else if ($url[1] === "gp"){
                  $projectController->getUserProjectsJson();
                } else if($url[1] === "pa"){
                    $projectController->AddProjectValidation();                        
                } else if($url[1] === "v"){
                    $taskController->displayProject($url[2]);
                } else if($url[1] === "d"){
                    $projectController->deleteProject($url[2]);
                }

                case "task";
                if ($url[1] === "ta"){
                    $taskController->AddTaskValidation();
                } else if($url[1] === "gtt" && isset($url[2])){
                    $id_project = $url[2];
                    $taskController->getUserTodoTasksJson($id_project);
                } else if($url[1] === "gpt" && isset($url[2])){
                    $id_project = $url[2];
                    $taskController->getUserInProgressTasksJson($id_project);
                } else if($url[1] === "gdt" && isset($url[2])){
                    $id_project = $url[2];
                    $taskController->getUserDoneTasksJson($id_project);
                } else if($url[1] === "d" && $url[2]){
                    $taskController->deleteTask($url[2]);
                } else if($url[1] === "ap" && $url[2]){
                    $taskController->addProgressTask($url[2]);
                } else if($url[1] === "ad" && $url[2]){
                    $taskController->addDoneTask($url[2]);
                }

                break;
                default: echo("La page n'existe pas");
            }
        }
}  
catch(Exception $e){
    $e->getMessage();
}
    
?>