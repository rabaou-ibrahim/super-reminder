<?php 

require_once "./models/Model.php";
require_once "Project.php";

class ProjectManager extends Model{
    private ?array $projects;

    public function addProject($project){
        $this->projects[] = $project;
    }
    
    // Function that returns the array that contains every saved project
    public function getProjects(){
        return $this->projects;
    }

    // Function that loads every project with a query
    public function loadProjects(){
        $query = $this->getDb()->prepare("SELECT * FROM project ORDER BY `project`.`id` ASC");
        $query->execute();
        $myProjects = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();

        foreach($myProjects as $project){
            $p = new Project($project['id'], $project['title'], $project['description'], $project['id_user']);
            $this->addProject($p);
        }
    }

    // Load User Projects
    public function getProjectsByUserId($id_user){
        $query = "SELECT * FROM project WHERE id_user = :id_user ORDER BY `project`.`id` ASC";

        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->execute();
        $myProjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $myProjects;
    }

    // Function that returns a project by its id
    public function getProjectbyId($id){
        for($i = 0; $i < count($this->projects); $i++){
            if($this->projects[$i]->getId() === $id){
                return $this->projects[$i];
            }
        }
    }

    // Function that returns the number of current projects for a user based on his id
    public function loadNbPendingProjectsByUserId($id_user){
        $query = "SELECT COUNT(*) AS count FROM inprogress WHERE :id_user = $id_user";
        $stmt = $this->getDb()->prepare($query);
        $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->execute();
 
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];
        return $count;
    }
    
    // Function that adds a new project to db table project.
    public function addProjectDb($title, $description, $id_user){
        $query = "INSERT INTO project (title, description, id_user) values (:title, :description, :id_user)";

        $stmt = $this->getDb()->prepare($query); 
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
        $result = $stmt->execute();

        if ($result > 0){
            $project = new Project($this->getDb()->lastInsertId(), $title, $description, $id_user);
            $this->addProject($project);
        }
    }
    // Function that deletes a project in database and all the tasks within that project.

    public function deleteProjectDb($id){
        $query1 = "DELETE FROM project WHERE id = :id";
        $stmt = $this->getDb()->prepare($query1);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        $query2 = "DELETE FROM task WHERE id_project = :id_project";
        $stmt = $this->getDb()->prepare($query2);
        $stmt->bindValue(":id_project", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0){
            $project = $this->getProjectbyId($id);
            unset($project);
        }
    }

}