<?php

//session_start();

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$catprom0 = filter_var($Dados['Novo_Catprom'], FILTER_SANITIZE_STRING);
$tipocategoria = 'P';
$site_cat0 = filter_var($Dados['Site_Catprom_Cadastrar'], FILTER_SANITIZE_STRING);
$balcao_cat0 = filter_var($Dados['Balcao_Catprom_Cadastrar'], FILTER_SANITIZE_STRING);

$catprom = trim(mb_strtoupper($catprom0, 'ISO-8859-1'));
$site_cat = trim(mb_strtoupper($site_cat0, 'ISO-8859-1'));
$balcao_cat = trim(mb_strtoupper($balcao_cat0, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$query_usuario = "INSERT INTO Tab_Catprom (Catprom, TipoCatprom, Site_Catprom, Balcao_Catprom, idSis_Usuario, idSis_Empresa, idTab_Modulo) VALUES ('$catprom', '$tipocategoria', '$site_cat', '$balcao_cat', '$usuario', '$empresa', '$modulo')";
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
