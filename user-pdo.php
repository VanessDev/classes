<?php

class Userpdo
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    private $password;
    private $pdo;
    private $connected = false;

    public function __construct()
    {
        
        $this->pdo = new PDO(
            "mysql:host=localhost;dbname=classes;charset=utf8mb4",
            "root",
            ""
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateurs (login, password, email, firstname, lastname)
                VALUES (:login, :password, :email, :firstname, :lastname)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':login'     => $login,
            ':password'  => $passwordHash,
            ':email'     => $email,
            ':firstname' => $firstname,
            ':lastname'  => $lastname
        ]);

        $this->id        = $this->pdo->lastInsertId();
        $this->login     = $login;
        $this->email     = $email;
        $this->firstname = $firstname;
        $this->lastname  = $lastname;
        $this->connected = true;

        return $this->getAllInfos();
    }

    public function connect($login, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE login = :login");
        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

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

        $stmt = $this->pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
        $stmt->execute([':id' => $this->id]);

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
                SET login = :login, password = :password, email = :email,
                    firstname = :firstname, lastname = :lastname
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':login'     => $login,
            ':password'  => $passwordHash,
            ':email'     => $email,
            ':firstname' => $firstname,
            ':lastname'  => $lastname,
            ':id'        => $this->id
        ]);

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
