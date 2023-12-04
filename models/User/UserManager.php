<?php 

require_once "./models/Model.php";
require_once "User.php";

class UserManager extends Model{
    private ?array $users;

    public function addUser($user){
        $this->users[] = $user;
    }

    // Function that returns the users array that contains every user
    public function getUsers(){
        return $this->users;
    }

    // Function that load every User after a query in out database
    public function loadUsers(){
        $query = $this->getDb()->prepare("SELECT * FROM user");
        $query->execute();
        $myUsers = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();

        foreach($myUsers as $user){
            $u = new User($user['id'],  $user['login'], $user['lastname'], $user['firstname'], $user['password']);
            $this->addUser($u);
        }
    }

    // Function that returns a user by its id
    public function getUserbyId($id){
        for($i = 0; $i < count($this->users); $i++){
            if($this->users[$i]->getId() === $id){
                return $this->users[$i];
            }
        }
    }

    // 
    public function getUserByLogin($login) {
        foreach ($this->users as $user) {
            if ($user->getLogin() === $login) {
                return $user;
            }
        }
        return null; 
    }
    public function registerDb($login, $lastname, $firstname, $password){
        $query = "INSERT INTO user (login, lastname, firstname, password) values (:login, :lastname, :firstname, :password)";
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->getDb()->prepare($query); 
        $stmt->bindValue(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindValue(":firstname", $firstname, PDO::PARAM_STR);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->bindValue(":password", $passwordhash, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result > 0){
            $user = new User($this->getDb()->lastInsertId(), $login, $lastname, $firstname, $passwordhash);
            $this->addUser($user);
        }
        
    }
     
}