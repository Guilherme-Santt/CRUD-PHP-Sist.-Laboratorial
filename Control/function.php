<?php

// FUNÇÃO LIMPAR CARACTERES NO CAMPO TELEFONE
function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
}

// FORMATAR TELEFONE PARA VISUALIZAÇÃO COM CARACTERES
function formatar_telefone($telefone){
    $ddd     = substr ($telefone, 0, 2);
    $parte1  = substr ($telefone, 2, 5);
    $parte2  = substr ($telefone, 7, 8);
    return "($ddd) $parte1-$parte2";
}

function formatar_cpf($cpf){
    $parte     = substr ($cpf, 0, 3);
    $parte1  = substr ($cpf, 3, 3);
    $parte2  = substr ($cpf, 7, 9);
    $parte3  = substr ($cpf, 10, 11);

    return "$parte.$parte1.$parte2-$parte3";
}

// FUNÇÃO FORMATAR DATA PARA VISUALIZAÇÃO PADRÃO BR
function formatar_data($data){
    return implode('/', array_reverse(explode('-', $data)));
};


// FUNÇÃO FORMATAR NUMERO
function formatar($valor, $casas=2) {
    return number_format($valor, $casas, '.', '');
}
// VERIFICAÇÃO SE O CAMPO ESTÁ VAZIO
function verificar_vazio($i){
    
    $string = '';

    foreach ($i as $key => $value) {
        if(empty($value)){
            $string = $key . ",";
        }
    };

    return $string;
}

// SE FOR DÍGITADO SEM VALOR, VAI ADICIONAR VALOR "EM BRANCO"
function Formatar_campoEmBranco($i){
    if(empty($i) || Strlen($i) < 3){
      $i = "Não informado";
    }
};    

// FILTRO DE VALIDAÇÃO DE E-MAIL
function filtro_email($i){
    if(!filter_var($i, FILTER_VALIDATE_EMAIL))  
    die(strtoupper("campo e-mail inválido"));
}

//FILTRO DE VALIDÇÃO TELEFONE
function filtro_telefone($telefone){
    if(empty($telefone) || strlen($telefone) != 11)
    die(strtoupper("campo telefone inválido"));
}
?>