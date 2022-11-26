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
    public function __construct($dbHost, $dbName, $dbUser, $dbPassword = ""){
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
        return $this->pdo = new PDO('mysql:host='. $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword);
    }
}