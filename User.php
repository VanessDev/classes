<?php

class User
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    private $password;
    private $mysqli;
    private $connected = false;

    public function __construct()
    {
        
        $this->mysqli = new mysqli("localhost", "root", "", "classes");

        if ($this->mysqli->connect_error) {
            die("Erreur de connexion MySQLi : " . $this->mysqli->connect_error);
        }
    }

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateurs (login, password, email, firstname, lastname)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sssss", $login, $passwordHash, $email, $firstname, $lastname);
        $stmt->execute();

        $this->id        = $stmt->insert_id;
        $this->login     = $login;
        $this->email     = $email;
        $this->firstname = $firstname;
        $this->lastname  = $lastname;
        $this->connected = true;

        return $this->getAllInfos();
    }

    public function connect($login, $password)
    {
        $sql = "SELECT * FROM utilisateurs WHERE login = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $this->id        = $user['id'];
            $this->login     = $user['login'];
            $this->email     = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname  = $user['lastname'];
            $this->connected = true;
            return true;
        }

        return false;
    }

    public function disconnect()
    {
        $this->id        = null;
        $this->login     = null;
        $this->email     = null;
        $this->firstname = null;
        $this->lastname  = null;
        $this->connected = false;
    }

    public function delete()
    {
        if (!$this->isConnected()) {
            return false;
        }

        $sql = "DELETE FROM utilisateurs WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $this->disconnect();
        return true;
    }

    public function update($login, $password, $email, $firstname, $lastname)
    {
        if (!$this->isConnected()) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE utilisateurs
                SET login = ?, password = ?, email = ?, firstname = ?, lastname = ?
                WHERE id = ?";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sssssi", $login, $passwordHash, $email, $firstname, $lastname, $this->id);
        $stmt->execute();

        $this->login     = $login;
        $this->email     = $email;
        $this->firstname = $firstname;
        $this->lastname  = $lastname;

        return $this->getAllInfos();
    }

    public function isConnected()
    {
        return $this->connected;
    }

    public function getAllInfos()
    {
        if (!$this->id) {
            return null;
        }

        return [
            'id'        => $this->id,
            'login'     => $this->login,
            'email'     => $this->email,
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
        ];
    }

    public function getLogin()     { return $this->login; }
    public function getEmail()     { return $this->email; }
    public function getFirstname() { return $this->firstname; }
    public function getLastname()  { return $this->lastname; }
}
