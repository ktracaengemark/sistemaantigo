<?php

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_Opcao'], FILTER_SANITIZE_STRING);
$opcao = filter_var($Dados['Opcao'], FILTER_SANITIZE_STRING);

$opcao_maiuscula = trim(mb_strtoupper($opcao, 'ISO-8859-1'));

$result_opcao = "UPDATE Tab_Opcao SET Opcao='$opcao_maiuscula' WHERE idTab_Opcao = '$id'";
$resultado_opcao = mysqli_query($conn, $result_opcao);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $opcao);
mysqli_close($conn);