<?php

class Form {
    public function __construct(){
    }
    /**
     * Donne un input avec un label
     * @param string $name Titre du label
     * @param string $inputName Nom de l'input
     * @param string $type Type de l'input. "text" par défaut
     * @return string Contient le label et l'input généré avec les données entrées
     */
    public function input($name, $inputName, $type = "text"){
        return '<label for="'. $inputName .'">'. $name .'</label><input required="required" type="'. $type .'" name="'. $inputName .'">';
    }
}