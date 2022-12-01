<?php

class DB {
    /**
     * @var string L'hôte de la base
     */
    private $dbHost;
    /**
     * @var string Nom de la base
     */
    private $dbName;
    /**
     * @var string Nom d'utilisateur de la base
     */
    private $dbUser;
    /**
     * @var string Mot de passe de la base
     */
    private $dbPassword;
    /**
     * @var PDO Stocke l'instance de PDO qui représente une connexion à la base de donnée
     */
    private $pdo;
    /**
     * Nouvelle instance de base de donnée
     * @param string $dbHost L'hôte sur lequel la base de donnée est hébergé.
     * @param string $dbName Le nom de la base de donnée
     * @param string $dbUser Le nom d'utilisateur de la base de donnée
     * @param string $dbPassword Le mot de passe de la base de donnée, ne pas inclure si aucun mot de passe
     */
    public function __construct($dbName = "auth_site", $dbHost = "localhost", $dbUser = "root", $dbPassword = "2341"){
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
    }
    /**
     * Récupérer la connection PDO
     * @return PDO L'instance de l'objet de la base de donnée PDO
     */
    public function getPDOConnection(){
        if ($this->pdo != null){
            return $this->pdo;
        }
        $this->pdo = new PDO('mysql:host='. $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->pdo;
    }


    public function query($statement){
        $res = $this->getPDOConnection()->query($statement);
        $datas = $res->fetchAll();
        return $datas;
    }

    public function getRegisteredUsers(){
        $res = $this->query("SELECT email, type FROM users;");
        return $res;
    }


    public function getTypeOfUser($email, $pass){
        $datas = $this->prepare("SELECT id, email, pass, type FROM users WHERE email = :email;", ["email" => $email]);
        foreach($datas as $v){
            if (password_verify($pass, $v['pass'])){
                return $v['type'];
            }
        }
        return false;
    }

    public function getTypeOfUserByAuth($auth){
        $datas = $this->prepare("SELECT id, email, pass, type FROM users WHERE email = :email;");
        return false;
    }

    public function login($email, $pass){
        $res = $this->query("SELECT id, email, pass, type FROM users;");
        foreach ($res as $v){
            if ($v["email"] === $email && password_verify($pass, $v['pass'])){
                return true;
            }
        }
        return false;
    }

    public function prepare($statement, Array $options = []){
        $res = $this->getPDOConnection()->prepare($statement);
        $res->execute($options);
        $datas = $res->fetchAll();
        return $datas;
    }

    public function fetch($id = 0){
        $sql = 'SELECT id, email, pass, type FROM users';
        $options = [];
	    if ($id !== 0) {
	      $sql .= ' WHERE id = :id;';
          $options = ['id' => $id];
	    }
	    $res = $this->getPDOConnection()->prepare($sql);
	    $res->execute($options);
	    $datas = $res->fetchAll(PDO::FETCH_ASSOC);
	    return $datas;
    }

    public function delete($id = 0){
        $sql = 'DELETE FROM users WHERE id = :id';
        $options = ['id' => $id];
	    $res = $this->getPDOConnection()->prepare($sql);
	    $res->execute($options);
	    return true;
    }

    public function storeUser($email){
        $newid = session_create_id('auth-');
        $_SESSION['deleted_time'] = time();
    }

    public function register($email, $pass, $type = "user"){
        $st = $this->query("SELECT email FROM users;");
        foreach($st as $v){
            if ($v['email'] === $email){
                return false;
            }
        }
        $st = $this->getPDOConnection()->prepare("INSERT INTO users(id, email, pass, type) VALUES (NULL, :email, :pass, :type)");
        $st->execute(['email' => $email, 'pass' => $pass, 'type' => $type]);
        return true;
    }
    public function isLoggedIn() {
        if (isset($_SESSION['auth'])){
            header("Location: " . $_SESSION['type']);
        }
	}

    public function message($msg, $status) {
	    return json_encode(['message' => $msg, 'error' => $status]);
	}
}