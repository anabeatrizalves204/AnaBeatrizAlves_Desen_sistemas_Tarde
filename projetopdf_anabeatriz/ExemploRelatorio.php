<?php
//Inicia o buffer de saída para capturar qualquer conteúdo
use Fpdf\Fpdf;


ob_start();

//inclui o autoload do composer
require_once 'vendor/autoload.php';

//cria uma nova instância da classe FPDF
$pdf = new Fpdf('p', 'pt', 'A4');


//adiciona uma nova página ao documento pdf
$pdf->AddPage();

//função auxiliar para converter texto para ISO-8859-1 (evita problemas com acentos)
function textoPDF($txt)
{
    return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $txt);
}


$pdf->Write(5, "Ana Beatriz");
//CABEÇALHO DO RELATORIO
//define a fonte: arial, negrito(B), tamanho 18
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 5, textoPDF("Relatório de dados"), 0, 1, "C"); //1=br quebra de linha, C=alinhamento
$pdf->Cell(0, 5, "", "B", 1, "C");
$pdf->Ln(20);


//dados de exemplo (array simulado)
$dados = [
    ['item A', 'Descrição 1', 'Categoria X', 10.50],
    ['item B', 'Descrição 2', 'Categoria Y', 25.75],
    ['item C', 'Descrição 3', 'Categoria X', 5.99], //CADA LINHA É UM PRODUTO COM 4 ELEMENTOS
    ['item D', 'Descrição 4', 'Categoria Z', 100.00],
    ['item E', 'Descrição 5', 'Categoria Y', 12.30],
    ['item F', 'Descrição 6', 'Categoria X', 8.20],
    ['item G', 'Descrição 7', 'Categoria Z', 55.00],
];

//criando a tabela
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(100, 20, textoPDF('Produto'), 1, 0, "L");
$pdf->Cell(180, 20, textoPDF('Detalhes'), 1, 0, "L");
$pdf->Cell(100, 20, textoPDF('Categoria'), 1, 0, "L");
$pdf->Cell(100, 20, textoPDF('Valor'), 1, 0, "R"); //valores em dinheiro usamos "r" para alinhar para a direita

//preenchendo a tabela com os dados
$pdf->SetFont("Arial", "", 10);
foreach ($dados as $linha) {
    $pdf->Cell(100, 20, textoPDF($linha[0]), 1, 0, "L");
    $pdf->Cell(180, 20, textoPDF($linha[1]), 1, 0, "L");
    $pdf->Cell(100, 20, textoPDF($linha[2]), 1, 0, "L");
    $pdf->Cell(100, 20, number_format($linha[3], 2, ',', '.'), 1, 1, "R");
}

echo "Ana Beatriz Alves<br>";

//finalizando o pdf
$pdf->Output("relatorio_produtos.pdf", "I");


?>
