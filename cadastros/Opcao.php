<?php

//session_start();

include_once '../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$opcao0 = filter_var($Dados['Novo_Opcao'], FILTER_SANITIZE_STRING);
$atributo_opcao = filter_var($Dados['idAtributo_Opcao'], FILTER_SANITIZE_STRING);
$cat_opcao = filter_var($Dados['idCat_Opcao'], FILTER_SANITIZE_STRING);

$opcao = trim(mb_strtoupper($opcao0, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$query_usuario = "INSERT INTO Tab_Opcao (Opcao, idSis_Usuario, idSis_Empresa, idTab_Modulo, idTab_Atributo, idTab_Catprod) VALUES ('$opcao', '$usuario', '$empresa', '$modulo', '$atributo_opcao', '$cat_opcao')";
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
