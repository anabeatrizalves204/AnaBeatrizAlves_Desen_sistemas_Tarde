<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
ob_clean(); //limpa qualquer saida inesperada antes do header

//conexão com o banco de dados

require_once ('conecta.php');

//obtem o id da imagem da URL, garantindo que seja um número inteiro

$id_imagem = isset($_GET['id']) ? intval($_GET['id']) : 0 ;

//cria consulta para buscar a imagem no banco de dados 
$querySelecionaPorCodigo = "SELECT imagem, tipo_imagem FROM tabela_imagem WHERE codigo = ? ";

//Usa prepared statement para maior segurança 
$stmt = $conexao->prepare($querySelecionarPorCodigo);
$stmt->bind_param("i",$id_imagem);
$stmt->execute();
$resultado = $stmt->get_result();

//Verifica se a imagem existe no banco de dados

if ($resultado->num_rows > 0){
    $imagem = $resultado->fetch_object();

    //define o tipo correto da imagem(fallback para JPEG caso esteja vazio)

    $tipoImagem = !empty($imagem->tipo_imagem) ? $imagem->tipo_imagem : 'imagem/jpeg';
    header("Content-type: ".$tipoImagem);

    //exibe a imagem armazenada na banco de dados
    echo $imagem->imagem;
}else{
    echo "Imagem nao encontrada";

}
//Fecha a consulta
$stmt->close();




?>