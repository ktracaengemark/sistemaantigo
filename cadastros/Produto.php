<?php

//session_start();

include_once '../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$produto0 = filter_var($Dados['Novo_Produto'], FILTER_SANITIZE_STRING);
$catproduto = filter_var($Dados['idCat_Produto'], FILTER_SANITIZE_STRING);
//$descricao0 = filter_var($Dados['Desc_Produto'], FILTER_SANITIZE_STRING);

$produto = trim(mb_strtoupper($produto0, 'ISO-8859-1'));
//$descricao = trim(mb_strtoupper($descricao0, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$query_usuario = "INSERT INTO Tab_Produto (Produtos, idTab_Catprod, idSis_Usuario, idSis_Empresa, idTab_Modulo, Data_Cad_Produto) VALUES ('$produto', '$catproduto', '$usuario', '$empresa', '$modulo', '$datacad')";
mysqli_query($conn, $query_usuario);

if(mysqli_insert_id($conn)){
	echo true;
}else{
	echo false;
}
unset($usuario, $empresa, $modulo, $datacad);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);