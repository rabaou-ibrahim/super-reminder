<?php

require_once "./models/Project/ProjectManager.php";
class ProjectsController {
    private $projectManager;
    public function __construct(){
        $this->projectManager = new ProjectManager;
        $this->projectManager->loadProjects();
    }
    public function displayProjects(){
        require "views/user/projects.view.php";
    }
    public function displayLogin(){
        require "views/user/login.view.php";
    }

    public function getUserProjectsJson(){
        $myProjects = $this->projectManager->getProjectsByUserId($_SESSION['id_user']);

        header('Content-Type: application/json');
        echo json_encode($myProjects);
    }
    public function verifyAddProjectFields($title, $description){
        $projects = $this->projectManager->getProjects();

        $projectTitles = [];
        $projectDescriptions = [];

        $isTitleTaken = false;
        $isDescriptionTaken = false;

        if (!empty($projects)) {

            foreach ($projects as $project) {
                $projectTitles[] = $project->getTitle();
                $projectDescriptions[] = $project->getDescription();
            }
        
            foreach ($projectTitles as $existingProjectTitle) {
                if ($existingProjectTitle === $title) {
                    $isTitleTaken = true;
                    break;
                }
            }
        
            foreach ($projectDescriptions as $existingProjectDescription) {
                if ($existingProjectDescription === $description) {
                    $isDescriptionTaken = true;
                    break;
                }
            }
        }
    
        $AddMsg = '';
    
        if (!$isTitleTaken && !$isDescriptionTaken) {
            $AddMsg = "<p style='color:green'> Ajout effectué ! </p>";
        } elseif ($isTitleTaken) {
            $AddMsg = "Titre déjà pris";
        } elseif ($isDescriptionTaken) {
            $AddMsg = "Description déjà prise";
        }
    
        $responseData = [
            'success' => !$isTitleTaken && !$isDescriptionTaken,
            'message' => $AddMsg
        ];
    
        return $responseData;
    }
    public function AddProjectValidation(){
        $response = $this->verifyAddProjectFields(htmlspecialchars($_POST["title"]), htmlspecialchars($_POST["description"]));

        if ($response['success']) {
            $this->projectManager->addProjectDb(htmlspecialchars($_POST["title"]), htmlspecialchars($_POST["description"]), $_SESSION['id_user']);

            $responseData = [
                'success' => true,
                'message' => "Ajout effectué !",
                'project_title' => $_POST["title"],
                'project_description' => $_POST["description"],
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

    public function deleteProject($id){
        $this->projectManager->deleteProjectDb($id);

        header('Location: '.URL.'user/p');
    }

}

?>