<?php

include_once '../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_Atributo'], FILTER_SANITIZE_STRING);
$atributo = filter_var($Dados['Atributo'], FILTER_SANITIZE_STRING);

$atributo_maiuscula = trim(mb_strtoupper($atributo, 'ISO-8859-1'));

$result_atributo = "UPDATE Tab_Atributo SET Atributo='$atributo_maiuscula' WHERE idTab_Atributo = '$id'";
$resultado_atributo = mysqli_query($conn, $result_atributo);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $atributo);
mysqli_close($conn);