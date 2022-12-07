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
     * @return PDO|void L'instance de l'objet de la base de donnée PDO
     */
    public function getPDOConnection(){
        try {
            if ($this->pdo != null){
                return $this->pdo;
            }
            $this->pdo = new PDO('mysql:host='. $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return exit();
        }
    }
    /**
     * Permet de faire une reqûete SQL
     * @param string $statement La reqûete à compléter
     * @return array Un tableau avec le résultat de la reqûete
     */
    public function query($statement){
        $res = $this->getPDOConnection()->query($statement);
        $datas = $res->fetchAll();
        return $datas;
    }
    /**
     * Permet de récupérer tout les utilisteurs enregistrés dans la base de donnée
     * @return array Un tableau avec tout les utilisateurs avec leur id, leur email, et leur type
     */
    public function getRegisteredUsers(){
        $res = $this->query("SELECT id, email, type FROM users;");
        return $res;
    }
    /**
     * Donne le type d'un utilisateur en fonction de son email et son mot de passe
     * @param string $email L'email de l'utilisateur
     * @param string $pass Le mot de passe de l'uilisateur
     * @return string|bool Le type de l'utilisateur ou false si l'utilisateur n'a pas entré le bon mot de passe
     */
    public function getTypeOfUser($email, $pass){
        $datas = $this->prepare("SELECT pass, type FROM users WHERE email = :email;", ["email" => $email]);
        foreach($datas as $v){
            if (password_verify($pass, $v['pass'])){
                return $v['type'];
            }
        }
        return false;
    }
    /**
     * Get the type of the user that is connected by their id
     * @param string $email L'email de l'utilisateur
     * @param string $pass Le mot de passe de l'uilisateur
     * @return string|bool Le type de l'utilisateur ou false si l'utilisateur n'existe pas
     */
    public function getTypeOfUserById($id){
        $datas = $this->prepare("SELECT type FROM users WHERE id = :id;", ["id" => $id]);
        foreach($datas as $v){
            return $v['type'];
        }
        return false;
    }
    /**
     * Get the type of the user that is connected
     * @return bool|string Le type de l'utilisateur ou false si l'utilisateur n'a pas de type ou qu'il n'est pas connecté (ou qu'aucune session n'est ouverte)
     */
    public function getTypeOfUserByAuth(){
        return $_SESSION['type'] ? isset($_SESSION['type']) : false;
    }
    /**
     * Vérifie si l'utilisateur peut se connecter
     * @param string $email L'email de l'utilisateur
     * @param string $pass Le mot de passe de l'utilisateur
     * @return bool True si l'utilisateur à réussi à se connecter, false si l'utilisateur n'a pas réussi à se connecter et que l'opération à échoué
     */
    public function login($email, $pass){
        $res = $this->query("SELECT id, email, pass, type FROM users;");
        foreach ($res as $v){
            if ($v["email"] === $email && password_verify($pass, $v['pass'])){
                return true;
            }
        }
        return false;
    }
    /**
     * Permet de faire des requêtes préparer et de me donner le résultat dans un tableau
     * @param string $statement La requête préparé à donner
     * @param array $options Les options de la requêtes, c'est souvent ce que nous voulons modifier
     * @return array Les données de la reqûete préparer
     */
    public function prepare($statement, Array $options = []){
        $res = $this->getPDOConnection()->prepare($statement);
        $res->execute($options);
        $datas = $res->fetchAll(PDO::FETCH_ASSOC);
        return $datas;
    }
    /**
     * Récupère l'id , l'email, et le type d'un utilisateur en fonction de son id
     * @param string $id L'id de l'utilisateur que nous voulons récupérer
     * @return array Retourne dans un tableau les données de l'utilisteur
     */
    public function fetch($id = 0){
        $sql = 'SELECT id, email, type FROM users';
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
    /**
     * Met à jour l'email et le type de l'id donné
     * @param string|int $id Va dire ce qui sera modifié
     * @param string $email La nouvelle valeur de l'email
     * @param string $type La nouvelle valeur du type
     * @return bool Retourne true si l'opération à réussi
     */
    public function update($id, $email, $type){
        if (!$this->checkType($type) || !$this->isMail($email)){
            return false;
        }
        $sql = 'UPDATE users SET email = :email, type = :type WHERE id = :id';
        $res = $this->getPDOConnection()->prepare($sql);
        $res->execute(["email" => $email, "type" => $type, "id" => $id]);
        return true;
    }
    /**
     * Supprime un utilisateur de la base de donnée en fonction de son id
     * @param string $id L'id de l'utilisateur à supprimer
     * @return bool True si l'utilisteur s'est bien supprimé de la base de donnée, false si l'utilisteur n'a pas pu être supprimé
     */
    public function delete($id = 0){
        if ($this->getTypeOfUserById($id) === 'admin' || $this->checkId($id)){
            return false;
        }
        $sql = 'DELETE FROM users WHERE id = :id';
        $options = ['id' => $id];
        $res = $this->getPDOConnection()->prepare($sql);
        $res->execute($options);
        $this->query('ALTER TABLE users AUTO_INCREMENT = 1');
        return true;
    }
    /**
     * Vérifie si l'id donné est existant dans la table users
     * @param string|int $id La valeur qui sera vérifié
     * @return bool Retourne true si l'id donné est existant, false si l'id n'est pas existant
     */
    public function checkId($id){
        $st = $this->query("SELECT id FROM users;");
        foreach($st as $v){
            if ($v['id'] === $id){
                return false;
            }
        }
        return true;
    }
    /**
     * Vérifie le type d'un utilisateur
     * @param string $type Le type de l'utilisteur à vérifié
     * @return bool True si le type correspond à la liste des types possibles, false si le type de correspond pas
     */
    public function checkType($type){
        $types = ['admin', 'user', 'prisoner'];
        foreach($types as $v){
            if ($v === stripslashes(substr($type, 1, -1)) || $v === $type){
                return true;
            }
        }
        return false;
    }
    /**
     * Permet de déconnecter l'utilisateur dès que la session à expiré
     * @return void Renvoie l'utilisteur sur la page de login si la session à expiré
     */
    public static function onExpired(){
        $expires = 600; # 10 minutes
        if (!isset($_SESSION['auth']) || time() - $_SESSION['created'] > $expires){
            if (session_destroy()){
                if (!str_contains($_SERVER['PHP_SELF'], "accueil/index")){
                    header("Location: ../auth/login");
                }
            }
        }
    }
    /**
     * Permet de vérifié si un email est dans le bon format
     * @param string $email L'email à vérifier
     * @return bool True si l'email est dans le bon format, false si l'email n'est pas dans le bon format
     */
    public function isMail($email){
        if (!preg_match('/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{1,4})$/', $email)){
            return false;
        }
        return true;
    }
    /**
     * Vérifie l'email d'un utilisateur
     * @param string $email L'email de l'utilisateur
     * @return bool True si l'email est valide, false si l'email n'est pas valide donc soit l'email n'est pas dans le bon format ou soit l'email est existant
     */
    public function checkMail($email){
        if (!$this->isMail($email)){
            return false;
        }
        $st = $this->query("SELECT email FROM users;");
        foreach($st as $v){
            if ($v['email'] === $email){
                return false;
            }
        }
        return true;
    }
    /**
     * Enregistre un nouvel utilisateur dans la base de donnée
     * @param string $email L'email de l'utilisateur
     * @param string $pass Le mot de passe de l'utilisateur
     * @param string $type Le type de l'utilisteur, son niveau d'accès par rapport au site. Par défaut : user
     * @return bool True si l'utilisteur s'est bien enregistré, false si l'opération à échoué
     */
    public function register($email, $pass, $type = "user"){
        if (!$this->checkMail($email)){
            return false;
        }
        $st = $this->getPDOConnection()->prepare("INSERT INTO users(id, email, pass, type) VALUES (NULL, :email, :pass, :type)");
        $st->execute(['email' => $email, 'pass' => $pass, 'type' => $type]);
        return true;
    }
    /**
     * Permet de vérifié si l'utilisateur est authentifié
     * @return bool True si l'utilisateur est authentifié.
     */
    public static function isLoggedIn() {
        return isset($_SESSION['auth']) && isset($_SESSION['type']) === true;
    }
    /**
     * Permet d'encoder un message en json
     * @param string $msg Le message à entrer
     * @param bool $error True si une erreur est survenue sinon false si une erreur est survenue.
     * @param bool $success True si l'opération à réussi, false si l'opération à échouer. Par défaut : false
     * @return bool|string Le message encodé en json avec les différents paramètres en compte.
     */
    public function message($msg, $error, $success = false) {
        return json_encode(['message' => $msg, 'error' => $error, 'success' => $success]);
    }
    /**
     * Permet de nettoyer l'input de l'utilisteur pour éviter les injections
     * @param string $input L'input à vérifier
     * @return string L'input qui a été vérifié
     */
    public function cleanInput($input){
        $input = strip_tags($input);
        $input = htmlspecialchars($input);
        $input = stripslashes($input);
        $input = trim($input);
        return $input;
    }
}