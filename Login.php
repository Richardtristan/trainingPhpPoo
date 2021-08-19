<?php

class Log
{
    private $email;
    private $password;
    private $username;
    private $id;

    /**
     * @param $password
     * @param $username
     */
    public function __construct($password, $username)
    {
        global $db;
        $this->db = $db;
        $this->password = $password;
        $this->username = $username;
    }

    public function login()
    {
        $log = $this->db->prepare("SELECT username, password FROM users WHERE username = ?");
        $log->execute([$this->username]);
        $userExist = $log->fetch();

        if ($userExist) {
            if ($userExist['username'] === $this->username && password_verify($this->password, $userExist["password"])) {
                return true;
            }
        }
        return false;
    }

    public function id()
    {
        $id = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $id->execute([$this->username]);
        $idFetch = $id->fetch();
        return $idFetch['id'];
    }

    public function username($sessionUse)
    {
        $username = $this->db->prepare("SELECT username FROM users WHERE id = ?");
        $username->execute([$sessionUse]);
        $userFetch = $username->fetch();
        return $userFetch['username'];
    }
    public function password($sessionUse)
    {
        $password = $this->db->prepare("SELECT password FROM users WHERE id = ?");
        $password->execute([$sessionUse]);
        $passFetch = $password->fetch();
        return $passFetch['password'];
    }
    public function email($sessionUse)
    {
        $email = $this->db->prepare("SELECT email FROM users WHERE id = ?");
        $email->execute([$sessionUse]);
        $mailFetch = $email->fetch();
        return $mailFetch['email'];
    }
}