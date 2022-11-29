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
    public function __construct($dbName, $dbHost = "localhost", $dbUser = "root", $dbPassword = ""){
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
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        }
        return $this->pdo = new PDO('mysql:host='. $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword);
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

    public function login($email, $pass){
        $res = $this->query("SELECT email, pass, type FROM users;");
        foreach ($res as $v){
            if ($v["email"] === $email){
                if (password_verify($pass, $v['pass'])){
                    // if ($v['type'] === "admin"){
                    //     header("../accueil/admin.php");
                    // } elseif ($v['type'] === "user") {
                    //     header("../accueil/user.php");
                    // }
                    return true;
                }
            }
        }
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
}