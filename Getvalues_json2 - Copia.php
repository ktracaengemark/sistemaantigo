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

if ($_GET['q']==1) {

    $result = mysql_query(
            'SELECT
                TSV.idTab_Servico,
                CONCAT(TSV.NomeServico, " --- R$ ", TSV.ValorServico) AS NomeServico,
                TSV.ValorServico
            FROM
                Tab_Servico AS TSV
            WHERE
				TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TSV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				TSV.NomeServico ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array2[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['NomeServico']),
            'value' => $row['ValorServico'],
        );
    }

}

elseif ($_GET['q'] == 3) {

    $result = mysql_query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array2[] = array(
            'id' => $row['idSis_Usuario'],
            'name' => utf8_encode($row['Nome']),
        );
    }

}

elseif ($_GET['q'] == 14) {
	
    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TCP.idTab_Cor_Prod,
				TCP.Nome_Cor_Prod,
				TTP.idTab_Tam_Prod,
				TTP.Nome_Tam_Prod,
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TCP.Nome_Cor_Prod,""), " - ", IFNULL(TTP.Nome_Tam_Prod,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Cor_Prod AS TCP ON TCP.idTab_Cor_Prod = TPS.Cor_Prod
					LEFT JOIN Tab_Tam_Prod AS TTP ON TTP.idTab_Tam_Prod = TPS.Tam_Prod_Aux1				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_3'] . '
			ORDER BY
				TPS.Nome_Prod ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'name' => utf8_encode($row['Nome_Prod']),
            'value' => $row['Valor_Produto'],
        );
    } 
    
}

elseif ($_GET['q'] == 92) {
//// daqui, Tipo/Cor, eu pego o Valor R$.....
    $result = mysql_query('
            SELECT
				P.idTab_Prodaux2,
				P.Prodaux2,
				P.Prodaux3,
				P3.Prodaux3,
				CONCAT(IFNULL(P3.Prodaux3,""), " - ", IFNULL(P.Prodaux2,"")) AS Prodaux2
            FROM
                Tab_Prodaux2 AS P
					LEFT JOIN Tab_Prodaux3 AS P3 ON P3.idTab_Prodaux3 = P.Prodaux3
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prodaux3 = ' . $_SESSION['Produto']['Prodaux3'] . ' 
			ORDER BY 
				P3.Prodaux3 ASC,
				P.Prodaux2 ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Prodaux2'],
            'name' => utf8_encode($row['Prodaux2']),
        );
    }

}

elseif ($_GET['q'] == 98) {
//// daqui, eu pegoo Tamanho
    $result = mysql_query('
            SELECT
				P.idTab_Tam_Prod,
				P.Tam_Prod,
				P.idTab_Produto,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Nome_Tam_Prod
            FROM
                Tab_Tam_Prod AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.Tam_Prod
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' 
			ORDER BY 
				P.Nome_Tam_Prod ASC
				
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array2[] = array(
            'id' => $row['idTab_Tam_Prod'],
            'name' => utf8_encode($row['Nome_Tam_Prod']),
        );
    }

}

echo json_encode($event_array2);
mysql_close($link);
?>
