<?php

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_Funcao'], FILTER_SANITIZE_STRING);
$Funcao = filter_var($Dados['Nome_Funcao'], FILTER_SANITIZE_STRING);

$Funcao_maiuscula = trim(mb_strtoupper($Funcao, 'ISO-8859-1'));

$result_Funcao = "UPDATE Tab_Funcao SET Funcao='$Funcao_maiuscula' WHERE idTab_Funcao = '$id'";
$resultado_Funcao = mysqli_query($conn, $result_Funcao);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $Funcao);
mysqli_close($conn);