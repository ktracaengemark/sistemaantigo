<?php

include_once '../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_Produto'], FILTER_SANITIZE_STRING);
$produto = filter_var($Dados['Produtos'], FILTER_SANITIZE_STRING);

$produto_maiuscula = trim(mb_strtoupper($produto, 'ISO-8859-1'));

$result_produto = "UPDATE Tab_Produto SET Produtos='$produto_maiuscula' WHERE idTab_Produto = '$id'";
$resultado_produto = mysqli_query($conn, $result_produto);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $produto);
mysqli_close($conn);