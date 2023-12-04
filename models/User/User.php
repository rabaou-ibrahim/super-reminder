<?php

class User {
    private ?int $id;
    private ?string $lastname;
    private ?string $firstname; 
    private ?string $login;
    private ?string $password;

    public function __construct($id, $lastname, $firstname, $login, $password){
        $this->id = $id;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->login = $login;
        $this->password = $password;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): User {
        $this->id = $id;

        return $this;
    }
    public function getLastname(): ?string {
        return $this->lastname;
    }

    public function setLastname(string $lastname): User {
        $this->lastname = $lastname;
        return $this;
    }
    public function getFirstname(): ?string {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): User {
        $this->firstname = $firstname;
        return $this;
    }
    public function getLogin(): ?string {
        return $this->login;
    }
    public function setLogin(string $login): User {
        $this->login = $login;
        return $this;
    }

    public function getPassword(): ?string  {
        return $this->password;
    } 

    public function setPassword(string $password): User  {
        $this->password = $password;
        return $this;
    }
}