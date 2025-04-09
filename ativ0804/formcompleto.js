function mascara (o, f){
    objeto=o
    funcao=f
    setTimeout ("executaMascara()"), 1
}

function executaMascara(){
    objeto.value=funcao(objeto.value)
}

function RGeCPF(variavel){
    variavel=variavel.replace(/\D/g,""); //remove o que não é número
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2");//coloca um ponto após o terceiro digito e o quarto
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2");
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2");//coloca um ponto após o terceiro digito e o quarto
    variavel=variavel.replace(/(\d{3})(\d)/,"$1-$2");

    return variavel;
}

function cep(variavel){
    variavel=variavel.replace(/\D/g,""); //remove o que não é número
    variavel=variavel.replace(/(\d{5})(\d)$/,"$1-$2");
    variavel=variavel.replace(/(\d{2})(\d)/,"$1.$2");

    return variavel;
}

function nomesobrenome(variavel){
    variavel=variavel.replace(/\d/g,""); 
    
    return variavel

} 

function letra(variavel){
    variavel=variavel.replace(/\d/g,""); 
    
    return variavel

} 


function data(variavel){
    variavel=variavel.replace(/\D/g,""); 
    variavel=variavel.replace(/(\d{3})(\d)/,"$1/$2");
    variavel=variavel.replace(/(\d{3})(\d)/,"$1/$2");

    return variavel;
}