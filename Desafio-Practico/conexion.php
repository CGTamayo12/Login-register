<?php
$server = 'localhost';
$username= 'root';
$password= '';
$database= 'dss_desafio';

try{
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
}catch(PDOException $e){
    die('conextion fallida: '.$e->getMessage());

}
?>