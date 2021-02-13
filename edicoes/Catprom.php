<?php

include_once '../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_Categoria'], FILTER_SANITIZE_STRING);
$categoria = filter_var($Dados['Catprom'], FILTER_SANITIZE_STRING);
$sitecat 	= filter_var($Dados['Site_Catprom_Alterar'], FILTER_SANITIZE_STRING);
$balcaocat 	= filter_var($Dados['Balcao_Catprom_Alterar'], FILTER_SANITIZE_STRING);

$categoria_maiuscula = trim(mb_strtoupper($categoria, 'ISO-8859-1'));
$sitecat_maiuscula 		= trim(mb_strtoupper($sitecat, 'ISO-8859-1'));
$balcaocat_maiuscula 	= trim(mb_strtoupper($balcaocat, 'ISO-8859-1'));

$result_categoria = "UPDATE Tab_Catprom SET Catprom='$categoria_maiuscula', Site_Catprom='$sitecat_maiuscula', Balcao_Catprom='$balcaocat_maiuscula'  WHERE idTab_Catprom = '$id'";
$resultado_categoria = mysqli_query($conn, $result_categoria);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $categoria);
mysqli_close($conn);