//EXECUTAR MASCARAS

//DEFINE O OBJETO E CHAMA A FUNÇÃO
function mascara (o, f){
    objeto=o
    funcao=f
    setTimeout ("executaMascara()"), 1
}

function executaMascara(){
    objeto.value=funcao(objeto.value)
}

//MASCARAS
//Mascara do telefone

function telefone(variavel){
    variavel=variavel.replace(/\D/g,""); //remove tudo o que não é digito
    //a linha abaixo é responsável por adicionar parenteses em volta dos dois primeiros digitos 
    variavel=variavel.replace(/^(\d\d)(\d)/g,"($1) $2");
    variavel=variavel.replace(/(\d{4})(\d)/,"$1-$2");

    return variavel;
}

//Mascara do RG e CPF

function RGeCPF(variavel){
    variavel=variavel.replace(/\D/g,""); //remove o que não é número
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2");//coloca um ponto após o terceiro digito e o quarto
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2");//coloca um ponto após o terceiro digito e o quarto
    variavel=variavel.replace(/(\d{3})(\d)/,"$1-$2");

    return variavel;
}

function data(variavel){
    variavel=variavel.replace(/\D/g,""); 
    variavel=variavel.replace(/(\d{3})(\d)/,"$1/$2");
    variavel=variavel.replace(/(\d{3})(\d)/,"$1/$2");

    return variavel;
}

console.log("hello world")