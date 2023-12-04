<?php

    require_once "./models/Task/TaskManager.php";
    class TasksController {

        private $projectManager;
        private $taskManager;

        // Constructor that loads every project and every task
        public function __construct(){
            $this->projectManager = new ProjectManager;
            $this->projectManager->loadProjects();

            $this->taskManager = new TaskManager;
            $this->taskManager->loadTasks();
        }

        // Function that displays the tasks view
        public function displayProject($id){
            $task = $this->taskManager->getTaskbyId($id);
            require "views/user/tasks.view.php";
        }

        // Function that adds a task to our database or returns an error message if the task already exists
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

        // Function that verifies if the task exists in our database
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

        // Function that retrieves User Todo Tasks
        public function getUserTodoTasksJson($id_project){
            $myTodos = $this->taskManager->getTodoTasksByProjectId($id_project);
        
            header('Content-Type: application/json');
            echo json_encode($myTodos);
        }

        // Function that retrieves User In Progress Taskss
        public function getUserInProgressTasksJson($id_project){
            $myInProgresses = $this->taskManager->getInProgressTasksByProjectId($id_project);
        
            header('Content-Type: application/json');
            echo json_encode($myInProgresses);
        }
        
        // Function that retrieves User Done Tasks
        public function getUserDoneTasksJson($id_project){
            $myDones = $this->taskManager->getDoneTasksByProjectId($id_project);
        
            header('Content-Type: application/json');
            echo json_encode($myDones);
        }
            
        // Function that deletes a task in database
        public function deleteTask($id_task){
            $this->taskManager->deleteTaskDb($id_task);
            $deleteTask = true;
                
            header('Content-Type: application/json');
            echo json_encode($deleteTask);
        }
           
        // Function that labels a task as being inprogress in database
        public function addProgressTask($id_task){
            $this->taskManager->addProgressDb($id_task);
            $progressTask = true;
                
            header('Content-Type: application/json');
            echo json_encode($progressTask);
        }
         
        // Function that labels a task as being done in database
        public function addDoneTask($id_task){
            $this->taskManager->addDoneDb($id_task);
            $doneTask = true;
                
            header('Content-Type: application/json');
            echo json_encode($doneTask);
        }
    }
?>