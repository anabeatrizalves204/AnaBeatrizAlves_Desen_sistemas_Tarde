<?php 
// Definição das credenciais de conexão ao banco de dados

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "armazena_img";

//Criando a conexão usando mysqli

$conexao = new mysqli($servername,$username,$password,$dbname);

//Verificando se houve erro na conexão

if ($conexao->connect_error){
    die("Falha na conexão: ".$conexao->connect_error);
}
?>