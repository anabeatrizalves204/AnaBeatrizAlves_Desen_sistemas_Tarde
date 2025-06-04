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


class NOVOPDF extends FPDF
{
    function Header()
    {
        $this->Image('logo.png', 5, 1, 50); //insere a imagem 5=distância da esquerda, 1=distância do topo, 50=largura da imagem
        //pula 30 pontos abaixo da imagem
        $this->Ln(30);
        //define a fonte: arial, negrito(B), tamanho 15
        $this->SetFont('Arial', 'B', 15);
        //move  curor 80 pontos para a direita
        $this->Cell(80);
        $this->Cell(30, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Título'), 1, 0, "C"); //1=br quebra de linha, C=alinhamento
        //pula 20 pontos para baixo (espaço abaixo do título)
        $this->Ln(20);
    }
    function Footer()
    {
        //posição vertical a 15 pontos do final da página
        $this->SetY(-15);
        //define a fonte: Arial, itálico(I), tamanho 8
        $this->SetFont('Arial', 'I', 8);
        //número da página
        $this->Cell(0, 10, 'Página' . $this->PageNo().'/{nb}', 0, 0, 'C');                                                                             
    }
}

//cria o pdf usando a classe personalizada
$pdf = new NOVOPDF();

//ativa o uso do {nb} para o número de páginas
$pdf->AliasNbPages();

//adiciona a primeira página
$pdf->AddPage();

//CORPO DO DOCUMENTO

//define a fonte para o conteúdo
$pdf->SetFont('Times', '', 12);

//gera 80 linhas com conteúdo simulado
for ($i = 1; $i <= 80; $i++) {
    //largura total, altura 10, sem borda, quebra de linha automática
    $pdf->Cell(0, 10, 'Teste de Linha ' . $i, 0, 1);
}
$pdf->Write(5, "Ana Beatriz");
$pdf->Output(); //finaliza o pdf e envia para o navegador