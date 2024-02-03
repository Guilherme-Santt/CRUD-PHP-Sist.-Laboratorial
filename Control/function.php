<?php

// FUNÇÃO LIMPAR CARACTERES NO CAMPO TELEFONE
function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
}

// FORMATAR TELEFONE PARA VISUALIZAÇÃO COM CARACTERES
function formatar_telefone($telefone){
    $ddd = substr ($telefone, 0, 2);
    $parte1 = substr ($telefone, 2, 5);
    $parte2 = substr ($telefone, 7);
    return "($ddd) $parte1-$parte2";
}
// FUNÇÃO FORMATAR DATA PARA VISUALIZAÇÃO PADRÃO BR
    function formatar_data($data){
        return implode('/', array_reverse(explode('-', $data)));
    };
    
?>