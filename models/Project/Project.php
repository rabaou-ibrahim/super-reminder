<?php

class Project {
    private ?int $id;
    private ?string $title;
    private ?string $description;
    private ?string $id_user; 

    public function __construct($id, $title, $description, $id_user){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->id_user = $id_user;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): Project {
        $this->id = $id;
        return $this;
    }
    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): Project {
        $this->title = $description;
        return $this;
    }
    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(string $title): Project {
        $this->title = $title;
        return $this;
    }
    public function getUserId(): ?int {
        return $this->id_user;
    }
    public function setUserId(int $id_user): Project {
        $this->id_user = $id_user;
        return $this;
    }
}