<?php

require_once "./models/Model.php";
require_once "Task.php";

class TaskManager extends Model{
    private ?array $tasks;
    public function addTask($task){
        $this->tasks[] = $task;
    }
    
    // Function that returns the array that contains every saved task
    public function getTasks(){
        return $this->tasks;
    }

    // Function that loads every task with a query
    public function loadTasks(){
        $query = $this->getDb()->prepare("SELECT * FROM task");
        $query->execute();
        $myTasks = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();

        foreach($myTasks as $task){
            $t = new Task($task['id'], $task['title'], $task['description'], $task['id_project'], $task['id_user'], $task['status']);
            $this->addTask($t);
        }
    }

    // Load User ToDos
    public function getTasksByUserId($id_user){
        $query = "SELECT * FROM task WHERE id_user = :id_user";

        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->execute();
        $Tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $Tasks;
    }

    // Function that returns a todo by its id
    public function getTaskbyId($id){
        for($i = 0; $i < count($this->tasks); $i++){
            if($this->tasks[$i]->getId() === $id){
                return $this->tasks[$i];
            }
        }
    }

    // This function is used in order to fetch all the tasks that are within one project.
    // Once we retrieve the data, we ultimately display the founded tasks in the tasks view.
    public function getTasksByProjectId($id_project){
        $query = "SELECT * FROM task WHERE id_project = :id_project";

        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id_project", $id_project, PDO::PARAM_STR);
        $stmt->execute();
        $myTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $myTasks;
    }

    // Get the tasks that have 'todo' status
    public function getTodoTasksByProjectId($id_project){
        $query = "SELECT * FROM task WHERE id_project = :id_project AND status = 'todo' ORDER BY `task`.`id` DESC";

        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id_project", $id_project, PDO::PARAM_STR);
        $stmt->execute();
        $myTodoTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $myTodoTasks;
    }

    // Get the tasks that have 'inprogress' status
    public function getInProgressTasksByProjectId($id_project){
        $query = "SELECT * FROM task WHERE id_project = :id_project AND status = 'inprogress' ORDER BY `task`.`id` DESC";

        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id_project", $id_project, PDO::PARAM_STR);
        $stmt->execute();
        $myInProgressTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $myInProgressTasks;
    }

    // Get the tasks that have 'done' status
    public function getDoneTasksByProjectId($id_project){
        $query = "SELECT * FROM task WHERE id_project = :id_project AND status = 'done' ORDER BY `task`.`id` DESC";

        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id_project", $id_project, PDO::PARAM_STR);
        $stmt->execute();
        $myDoneTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $myDoneTasks;
    }

    // This function adds a new Task in db. It adds its name, the project id and user id. In the end if the query
    // is finely done, we add the new ToDo in the ToDo array.
    public function addTaskDb($title, $description, $id_project, $id_user, $status){
        $query = "INSERT INTO task (title, description, id_project, id_user, status) values (:title, :description, :id_project, :id_user, :status)";

        $stmt = $this->getDb()->prepare($query); 
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":id_project", $id_project, PDO::PARAM_INT);
        $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->bindValue(":status", $status, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result > 0){
            $task = new Task($this->getDb()->lastInsertId(), $title, $description, $id_project, $id_user, $status);
            $this->addTask($task);
        }
    }

    // Deletes a task based on its id
    public function deleteTaskDb($id){
        $query = "DELETE FROM task WHERE id = :id";
        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0){
            $project = $this->getTaskbyId($id);
            unset($project);
        }
    }

    // Changes a task status to 'inprogress'
    public function addProgressDb($id){
        $query = "UPDATE task SET status = 'inprogress' WHERE id = :id";
        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result) {
            $task = $this->getTaskbyId($id);
            if ($task) {
                $task->setStatus("progress");
            }
        }
    }

    // Changes a task status to done
    public function addDoneDb($id){
        $query = "UPDATE task SET status = 'done' WHERE id = :id";
        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result) {
            $task = $this->getTaskbyId($id);
            if ($task) {
                $task->setStatus("done");
            }
        }
    }
}

?>