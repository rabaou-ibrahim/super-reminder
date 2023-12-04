<?php

class Task {
    private ?int $id;
    private ?string $title;
    private ?string $description;
    private ?int $id_project; 
    private ?int $id_user;
    private ?string $status; 

    public function __construct($id, $title, $description, $id_project, $id_user, $status){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->id_project = $id_project;
        $this->id_user = $id_user;
        $this->status = $status;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): Task {
        $this->id = $id;
        return $this;
    }
    public function getTitle(): ?string {
        return $this->title;
    }
    public function setTitle(string $title): Task {
        $this->title = $title;
        return $this;
    }
    public function getDescription(): ?string {
        return $this->description;
    }
    public function setDescription(string $description): Task {
        $this->description = $description;
        return $this;
    }
    public function getProjectId(): ?int {
        return $this->id_project;
    }
    public function setProjectId(int $id_project): Task {
        $this->id_project = $id_project;
        return $this;
    }
    public function getUserId(): ?int {
        return $this->id_user;
    }
    public function setUserId(int $id_user): Task {
        $this->id_user = $id_user;
        return $this;
    }
    public function getStatus(): ?string {
        return $this->status;
    }
    public function setStatus(string $status): Task {
        $this->status = $status;
        return $this;
    }
}