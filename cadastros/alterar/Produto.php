<?php

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_Produto'], FILTER_SANITIZE_STRING);
$produto = filter_var($Dados['AlterarProdutos'], FILTER_SANITIZE_STRING);
$vendasite = filter_var($Dados['VendaSite_Alterar'], FILTER_SANITIZE_STRING);
$vendabalcao = filter_var($Dados['VendaBalcao_Alterar'], FILTER_SANITIZE_STRING);

$produto_maiuscula = trim(mb_strtoupper($produto, 'ISO-8859-1'));
$vendasite_maiuscula = trim(mb_strtoupper($vendasite, 'ISO-8859-1'));
$vendabalcao_maiuscula = trim(mb_strtoupper($vendabalcao, 'ISO-8859-1'));

$result_produto = "UPDATE Tab_Produto SET Produtos='$produto_maiuscula', VendaSite='$vendasite_maiuscula', VendaBalcao='$vendabalcao_maiuscula' WHERE idTab_Produto = '$id'";
$resultado_produto = mysqli_query($conn, $result_produto);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $produto, $vendasite, $produto_maiuscula, $vendasite_maiuscula);
mysqli_close($conn);