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

elseif ($_GET['q'] == 98) {
//// daqui, eu pegoo Tamanho
    $result = mysql_query('
            SELECT
				P.idTab_Tam_Prod,
				P.Tam_Prod,
				P.idTab_Produto,
				CONCAT(IFNULL(P.Nome_Tam_Prod,""), " -- ", IFNULL(P.idTab_Tam_Prod,"")) AS Nome_Tam_Prod
				
            FROM
                Tab_Tam_Prod AS P
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
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
