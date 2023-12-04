<?php

    require_once "./models/Task/TaskManager.php";
    class TasksController {

        private $projectManager;
        private $taskManager;
        public function __construct(){
            $this->projectManager = new ProjectManager;
            $this->projectManager->loadProjects();

            $this->taskManager = new TaskManager;
            $this->taskManager->loadTasks();
        }
        public function displayProject($id){
            $task = $this->taskManager->getTaskbyId($id);
            require "views/user/tasks.view.php";
        }
        public function AddTaskValidation(){
            $response = $this->verifyAddTaskFields(htmlspecialchars($_POST["task-title"]));

            if ($response['success']) {
                $this->taskManager->addTaskDb(htmlspecialchars($_POST["task-title"]), htmlspecialchars($_POST["task-description"]), htmlspecialchars($_POST["identifier_project"]), htmlspecialchars($_POST["identifier_user"]), "todo");
                $responseData = [
                    'success' => true,
                    'message' => "Ajout effectué !",
                    'task_title' => $_POST["task-title"],
                    'task_description' => $_POST["task-description"],
                    'task_project_id' => $_POST["identifier_project"],
                    'task_user_id' => $_POST["identifier_user"],
                ];
            } else {
                $responseData = [
                    'success' => false,
                    'message' => $response['message']
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($responseData);
        }

        public function verifyAddTaskFields($title){
            $tasks = $this->taskManager->getTasks();
            $taskTitles = [];
            $isTitleTaken = false;

            if (!empty($tasks)) {
                foreach ($tasks as $task) {
                    $taskTitles[] = $task->getTitle();
                }
                foreach ($taskTitles as $existingTaskTitle) {
                    if ($existingTaskTitle === $title) {
                        $isTitleTaken = true;
                        break;
                    }
                }
            }
        
            $AddMsg = '';
        
            if (!$isTitleTaken) {
                $AddMsg = "<p style='color:green'> Ajout effectué ! </p>";
            } else if ($isTitleTaken) {
                $AddMsg = "Titre déjà pris";
            }
        
            $responseData = [
                'success' => !$isTitleTaken,
                'message' => $AddMsg
            ];
        
            return $responseData;
            }
            public function getUserTodoTasksJson($id_project){
                $myTodos = $this->taskManager->getTodoTasksByProjectId($id_project);
        
                header('Content-Type: application/json');
                echo json_encode($myTodos);
            }
            public function getUserInProgressTasksJson($id_project){
                $myInProgresses = $this->taskManager->getInProgressTasksByProjectId($id_project);
        
                header('Content-Type: application/json');
                echo json_encode($myInProgresses);
            }
            public function getUserDoneTasksJson($id_project){
                $myDones = $this->taskManager->getDoneTasksByProjectId($id_project);
        
                header('Content-Type: application/json');
                echo json_encode($myDones);
            }
            public function deleteTask($id_task){
                $this->taskManager->deleteTaskDb($id_task);
                $deleteTask = true;
                
                header('Content-Type: application/json');
                echo json_encode($deleteTask);
            }
            public function addProgressTask($id_task){
                $this->taskManager->addProgressDb($id_task);
                $progressTask = true;
                
                header('Content-Type: application/json');
                echo json_encode($progressTask);
            }
            public function addDoneTask($id_task){
                $this->taskManager->addDoneDb($id_task);
                $doneTask = true;
                
                header('Content-Type: application/json');
                echo json_encode($doneTask);
            }
    }
?>