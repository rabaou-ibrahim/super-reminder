<?php

require_once "./models/User/UserManager.php";
class UsersController {
    private $userManager;
    public function __construct(){
        $this->userManager = new UserManager;
        $this->userManager->loadUsers();
    }
    public function displayRegister(){
        require "views/user/register.view.php";
    }
    public function displayLogin(){
        require "views/user/login.view.php";
    }
    public function displayProjects(){
        require_once "views/user/projects.view.php";
    }
    public function displayWarning(){
        require "views/user/warning.view.php";
    }
    public function registerValidation() {
        $response = $this->verifyRegFields(htmlspecialchars($_POST['login']));

        if ($response['success']) {
            $this->userManager->registerDb(htmlspecialchars($_POST["lastname"]), htmlspecialchars($_POST["firstname"]), htmlspecialchars($_POST['login']), htmlspecialchars($_POST["password"]));
            $responseData = [
                'success' => true,
                'message' => "Inscription réussie !"
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

    public function verifyRegFields($login) {

        $users = $this->userManager->getUsers();

        if (!$users) {
            $RegMsg = "<p style='color:green'> Inscription réussie ! </p>";
        }
        else {
            $logins = [];
            $isLoginTaken = false;
        
            foreach ($users as $user) {
                $logins[] = $user->getLogin();
            }
        
            foreach ($logins as $existingLogin) {
                if ($existingLogin === $login) {
                    $isLoginTaken = true;
                    break;
                }
            }
        
            $RegMsg = '';
        
            if (!$isLoginTaken) {
                $RegMsg = "<p style='color:green'> Inscription réussie ! </p>";
            } elseif ($isLoginTaken) {
                $RegMsg = "Pseudo déjà pris";
            }
        }
    
        $responseData = [
            'success' => !$isLoginTaken,
            'message' => $RegMsg
        ];
    
        return $responseData;
    }
    
    public function logInValidation(){
        $response = $this->verifyLogFields(htmlspecialchars($_POST['login']), htmlspecialchars($_POST['password']));

        if ($response['success']) { // If success is true, the user can log in. Therefore we initialize two sessions
            $responseLogData = [
                'success' => true,
                'message' => "Connexion établie !"
            ];
            $loadedUser = $this->userManager->getUserByLogin($_POST['login']);
            $_SESSION['id_user'] = $loadedUser->getId();
            $_SESSION['login'] = $loadedUser->getLogin();
        } else {
            $responseLogData = [
                'success' => false,
                'message' => $response['message']
            ];
        }
    
        header('Content-Type: application/json');
        echo json_encode($responseLogData);
    }
    

    public function verifyLogFields($login, $password) {
        $users = $this->userManager->getUsers();
        $foundUser = null;
        foreach ($users as $user) {  
            if ($user->getLogin() === $login) {
                $foundUser = $user;
                break;
            }
        }

        if ($foundUser !== null) {
            
            $hashedPassword = $foundUser->getPassword();
        
                if (password_verify($password, $hashedPassword)) {
                    $LogMsg = "<p style='color:green'>Connexion établie !</p>";
                    $UserExists = true;
                } else {
                    $LogMsg = "Mot de passe incorrect";
                    $UserExists = false;
                }
        } else {
            $LogMsg = "Pseudo incorrect";
            $UserExists = false;
        }
        
        $responseLogData = [
            'success' => $UserExists,
            'message' => $LogMsg
        ];
        
        return $responseLogData;    
    }
   
    public function logOut(){
        session_start();
        session_destroy();
        header("location: ".URL."home");
    }
}