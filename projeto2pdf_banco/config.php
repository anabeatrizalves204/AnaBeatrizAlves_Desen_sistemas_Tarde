<?php
//configurações do banco de dados 
define('DB_HOST', 'localhost');

define('DB_NAME', 'senai_login');
define('DB_USER' , 'root');

//senha do seu mysql
define('DB_PASS', '');

//inicia a sessão
session_start();

//função de conexão com o banco de dados
function conectarBanco(){
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8'; //sempre usada quando for necessário conectar ao banco
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erro de conexão' . $e->getMessage());
    }
}
?>