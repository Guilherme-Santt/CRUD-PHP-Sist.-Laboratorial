<?php

// FUNÇÃO LIMPAR CARACTERES NO CAMPO TELEFONE
function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
}

// FORMATAR TELEFONE PARA VISUALIZAÇÃO COM CARACTERES
function formatar_telefone($telefone){
    $ddd     = substr ($telefone, 0, 2);
    $parte1  = substr ($telefone, 2, 5);
    $parte2  = substr ($telefone, 7);
    return "($ddd) $parte1-$parte2";
}
// FUNÇÃO FORMATAR DATA PARA VISUALIZAÇÃO PADRÃO BR
function formatar_data($data){
    return implode('/', array_reverse(explode('-', $data)));
};

// VERIFICAÇÃO SE O CAMPO ESTÁ VAZIO
function verificar_vazio($i) {
    if(empty($i)){
        return die(strtoupper("Campo obrigatório."));
    }
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