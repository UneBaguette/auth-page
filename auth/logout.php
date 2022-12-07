<?php
session_start();
if (session_destroy()){
    header("Location: ../accueil");
} else
    die("Error while logging out!");
?>