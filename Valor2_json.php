<?php

session_start();

$link = mysql_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
if (!$link) {
    die('Não foi possível conectar: ' . mysql_error());
}

$db = mysql_select_db($_SESSION['db']['database'], $link);
if (!$db) {
    die('Não foi possível selecionar banco de dados: ' . mysql_error());
}

#echo 'Conexão bem sucedida';
$result = mysql_query(
        'SELECT
			T.idTab_Produtos,
			T.Nome_Prod,
			T.Cod_Prod,
			T.Comissao,
			T.Valor_Produto,
			T.Prod_Serv,
			TOP2.Opcao,
			TOP1.Opcao,
			CONCAT(IFNULL(T.Nome_Prod,"")," - ",IFNULL(TOP1.Opcao,"")," - ",IFNULL(TOP2.Opcao,"")) AS NomeProduto
        FROM
            Tab_' . $_GET['tabela'] . ' AS T
				LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = T.Opcao_Atributo_2
				LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = T.Opcao_Atributo_1			
        WHERE
			T.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
			T.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
');

if ($_GET['tabela']) {

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_' . $_GET['tabela']],
            'valor' => str_replace(".", ",", $row['Valor_Produto']),
			'comissaoprod' => str_replace(".", ",", $row['Comissao']),
			'nomeprod' => $row['NomeProduto'],
			'id_produto' => $row['idTab_Produtos'],
			'prod_serv' => $row['Prod_Serv'],
        );
    }
}
else {

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'valor' => str_replace(".", ",", $row['Valor_Produto']),
			'comissaoprod' => str_replace(".", ",", $row['Comissao']),
			'nomeprod' => $row['NomeProduto'],
			'id_produto' => $row['idTab_Produtos'],
			'prod_serv' => $row['Prod_Serv'],
        );
    }

}

echo json_encode($event_array);
mysql_close($link);
?>
