<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function list_financeiro1($data, $completo) {

        /*
        $consulta = ($data['DataFim']) ? $data['Pesquisa'] . ' <= "' . $data['DataFim'] . '" AND ' : FALSE;
        ' . $data['Pesquisa'] . ' >= "' . $data['DataInicio'] . '" AND
        ' . $consulta . '
        ' . $data['Pesquisa'] . ' ASC,
        #C.NomeCliente ASC
        */


        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '") OR
                (PR.DataPago >= "' . $data['DataInicio'] . '" AND PR.DataPago <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '") OR
                (PR.DataPago >= "' . $data['DataInicio'] . '")';
        }

		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
                PR.Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
				
                PR.DataPago,
                PR.ValorPago,
				
                PR.Quitado

            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
                ' . $filtro3 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '

            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somarecebido += $row->ValorPago;
                $somareceber += $row->ValorParcela;


                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');

            }
            $somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }

	public function list_receitas($data, $completo) {


        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }

		$data['NomeCliente'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TD.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				CONCAT(IFNULL(TD.TipoFinanceiro,""), " / ", IFNULL(C.NomeCliente,""), " / ", IFNULL(OT.Descricao,"")) AS Descricao,
				TD.TipoFinanceiro,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
				
                PR.DataPago,
                PR.ValorPago,
				
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . '
				' . $filtro5 . '
				OT.idTab_TipoRD = "2"
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
				' . $data['TipoFinanceiro'] . ' 
				' . $data['NomeCliente'] . '
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
            ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somarecebido += $row->ValorPago;
                $somareceber += $row->ValorParcela;


                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');

            }
            $somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }

	public function list_despesas($data, $completo) {


        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }

		#$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TD.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				CONCAT(IFNULL(TD.TipoFinanceiro,""), " / ", IFNULL(OT.Descricao,"")) AS TipoFinanceiro,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
				
                PR.DataPago,
                PR.ValorPago,
				
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . '
				' . $filtro5 . ' 
				OT.idTab_TipoRD = "1"
                ' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
				' . $data['TipoFinanceiro'] . ' 
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
            ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somarecebido += $row->ValorPago;
                $somareceber += $row->ValorParcela;


                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');

            }
            $somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }
		
	public function list_receitasparc($data, $completo) {


        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }

		#$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado'] != '#') ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade'] != '#') ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				OT.Descricao,
				CONCAT(IFNULL(TR.TipoFinanceiro,""), " / ", IFNULL(C.NomeCliente,""), " / ", IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
				
                PR.DataPago,
                PR.ValorPago,
				
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				' . $filtro4 . '
				OT.idTab_TipoRD = "2"
                ' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
            ORDER BY
				PR.DataVencimento
            ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somarecebido += $row->ValorPago;
                $somareceber += $row->ValorParcela;


                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');

            }
            $somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }

	public function list_despesasparc($data, $completo) {


        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }

		#$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TD.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado'] != '#') ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade'] != '#') ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				OT.Descricao,
				CONCAT(IFNULL(TD.TipoFinanceiro,""), " / ", IFNULL(OT.Descricao,"")) AS TipoFinanceiro,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
				
                PR.DataPago,
                PR.ValorPago,
				
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				' . $filtro4 . '
				OT.idTab_TipoRD = "1"
                ' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 

            ORDER BY
				PR.DataVencimento
            ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somarecebido += $row->ValorPago;
                $somareceber += $row->ValorParcela;


                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');

            }
            $somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }

    public function list1_receitas($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
        $data['NomeCliente'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeCliente'])) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(OT.DataVencimentoOrca) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(OT.DataVencimentoOrca) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(OT.DataVencimentoOrca) = ' . $data['Ano'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro7 = ($data['FormaPag']) ? 'OT.FormaPagamento = "' . $data['FormaPag'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
            FROM
                App_OrcaTrata AS OT
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
				LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				OT.idTab_TipoRD = "2"
                ' . $data['TipoFinanceiroR'] . '
				' . $data['Orcarec'] . '
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 				
				' . $data['NomeCliente'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '

        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
				$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

                $somaorcamento += $row->ValorOrca;
                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

				$somadesconto += $row->ValorEntradaOrca;
                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');

				$somarestante += $row->ValorRestanteOrca;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');



            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');

            return $query;
        }

    }

    public function list2_despesas($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }        
		$data['NomeFornecedor'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeFornecedor'])) ? ' AND F.idApp_Fornecedor = ' . $data['NomeFornecedor'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(OT.DataVencimentoOrca) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(OT.DataVencimentoOrca) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(OT.DataVencimentoOrca) = ' . $data['Ano'] : FALSE;
		$data['Orcades'] = ($data['Orcades']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcades'] : FALSE;		
		$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro7 = ($data['FormaPag']) ? 'OT.FormaPagamento = "' . $data['FormaPag'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
				OT.Descricao,
				F.NomeFornecedor,
				OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				MD.Modalidade,
				VP.Abrev2,				
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
            FROM
                App_OrcaTrata AS OT
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
				LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
				LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				OT.idTab_TipoRD = "1"
                ' . $data['TipoFinanceiroD'] . '
				' . $data['Orcades'] . '
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeFornecedor'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '

        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
				$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

                $somaorcamento += $row->ValorOrca;
                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

				$somadesconto += $row->ValorEntradaOrca;
                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');

				$somarestante += $row->ValorRestanteOrca;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');



            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');

            return $query;
        }

    }

    public function list1_comissao($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio'] . '" AND OT.DataVencimentoOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $data['NomeCliente'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeCliente'])) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(OT.DataVencimentoOrca) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(OT.DataVencimentoOrca) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(OT.DataVencimentoOrca) = ' . $data['Ano'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro7 = ($data['FormaPag']) ? 'OT.FormaPagamento = "' . $data['FormaPag'] . '" AND ' : FALSE;
		$filtro8 = ($data['ConcluidoProduto']) ? 'AP.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro10 = ($data['DevolvidoProduto']) ? 'AP.DevolvidoProduto = "' . $data['DevolvidoProduto'] . '" AND ' : FALSE;
		$filtro9 = ($data['ConcluidoServico']) ? 'TS.ConcluidoServico = "' . $data['ConcluidoServico'] . '" AND ' : FALSE;		
		$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
		$data['Prodaux1'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		$data['Prodaux2'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idSis_Empresa,
				OT.idSis_Usuario,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				EMP.NomeEmpresa,
				US.Nome AS NomeColaborador,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				AP.idApp_Produto,
				AP.QtdProduto,
				AP.DataValidadeProduto,
				AP.ConcluidoProduto,
				AP.DevolvidoProduto,
				AP.ValorProduto,
				AP.Comissao,
				AP.StatusComissao,
				(AP.QtdProduto * AP.ValorProduto) AS SubTotal,
				((AP.QtdProduto * AP.ValorProduto * AP.Comissao)/100)  AS SubComissao,
				TS.idApp_Servico,
				TS.QtdServico,
				TS.DataValidadeServico,
				TS.ConcluidoServico,
				TS.ValorServico,				
				TP.Produtos,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1,
				TR.TipoFinanceiro
            FROM
                App_OrcaTrata AS OT
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
				LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
				LEFT JOIN App_Produto AS AP ON AP.idApp_Orcatrata = OT.idApp_OrcaTrata
				LEFT JOIN App_Servico AS TS ON TS.idApp_Orcatrata = OT.idApp_OrcaTrata
				LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = AP.idTab_Produto
				LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Produto
				LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
				LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
				LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
				LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.AprovadoOrca = "S" AND
				OT.idTab_TipoRD = "2" AND
				OT.Tipo_Orca = "O" AND
				OT.idSis_Usuario != "0" AND
				OT.idSis_Usuario != "1" AND
				AP.idTab_TipoRD = "2" AND
				' . $consulta . '
            ORDER BY

				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '

        ');

        /*
			echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somasubtotal=0;
			$subtotal=0;
			$quantidade=0;
			$somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
			$somasubcomissao=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
				$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');
				$row->DataValidadeProduto = $this->basico->mascara_data($row->DataValidadeProduto, 'barras');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				$row->DevolvidoProduto = $this->basico->mascara_palavra_completa($row->DevolvidoProduto, 'NS');
				$row->ConcluidoServico = $this->basico->mascara_palavra_completa($row->ConcluidoServico, 'NS');
				$row->StatusComissao = $this->basico->mascara_palavra_completa($row->StatusComissao, 'NS');

                $somaorcamento += $row->ValorOrca;
                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

				$somadesconto += $row->ValorEntradaOrca;
                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');

				$somarestante += $row->ValorRestanteOrca;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');

				$quantidade += $row->QtdProduto;
                $row->QtdProduto = number_format($row->QtdProduto);
				
				$subtotal = $row->ValorProduto * $row->QtdProduto;
				$somasubtotal += $row->SubTotal;
				
				$subcomissao = $row->ValorProduto * $row->QtdProduto * $row->Comissao;
				$somasubcomissao += $row->SubComissao;
				
				$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');				
				$row->Comissao = number_format($row->Comissao, 2, ',', '.');				
				$row->SubTotal = number_format($row->SubTotal, 2, ',', '.');
				$row->SubComissao = number_format($row->SubComissao, 2, ',', '.');
				
            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');
			$query->soma->quantidade = number_format($quantidade);
			$query->soma->somasubtotal = number_format($somasubtotal, 2, ',', '.');
			$query->soma->somasubcomissao = number_format($somasubcomissao, 2, ',', '.');
			
            return $query;
        }

    }
	
    public function list1_produtosvendaonline($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio'] . '" AND OT.DataVencimentoOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $data['NomeCliente'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeCliente'])) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(OT.DataVencimentoOrca) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(OT.DataVencimentoOrca) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(OT.DataVencimentoOrca) = ' . $data['Ano'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro7 = ($data['FormaPag']) ? 'OT.FormaPagamento = "' . $data['FormaPag'] . '" AND ' : FALSE;
		$filtro8 = ($data['ConcluidoProduto']) ? 'AP.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro10 = ($data['DevolvidoProduto']) ? 'AP.DevolvidoProduto = "' . $data['DevolvidoProduto'] . '" AND ' : FALSE;
		$filtro9 = ($data['ConcluidoServico']) ? 'TS.ConcluidoServico = "' . $data['ConcluidoServico'] . '" AND ' : FALSE;		
		$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
		$data['Prodaux1'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		$data['Prodaux2'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idSis_Empresa,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				EMP.NomeEmpresa,
				MD.Modalidade,
				VP.Abrev3,
				VP.AVAP,
				TFP.FormaPag,
				AP.idApp_Produto,
				AP.QtdProduto,
				AP.DataValidadeProduto,
				AP.ConcluidoProduto,
				AP.DevolvidoProduto,
				AP.ValorProduto,
				AP.Comissao,
				AP.StatusComissao,
				(AP.QtdProduto * AP.ValorProduto) AS SubTotal,
				((AP.QtdProduto * AP.ValorProduto * AP.Comissao)/100)  AS SubComissao,
				TS.idApp_Servico,
				TS.QtdServico,
				TS.DataValidadeServico,
				TS.ConcluidoServico,
				TS.ValorServico,				
				TP.Produtos,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1,
				TR.TipoFinanceiro
            FROM
                App_OrcaTrata AS OT
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
				LEFT JOIN Tab_Modalidade AS VP ON VP.Abrev2 = OT.AVAP
				LEFT JOIN App_Produto AS AP ON AP.idApp_Orcatrata = OT.idApp_OrcaTrata
				LEFT JOIN App_Servico AS TS ON TS.idApp_Orcatrata = OT.idApp_OrcaTrata
				LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = AP.idTab_Produto
				LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Produto
				LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
				LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
				LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
				LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = OT.idSis_Empresa
            WHERE
                OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OT.AprovadoOrca = "S" AND
				OT.idTab_TipoRD = "2" AND
				AP.idTab_TipoRD = "2" AND
				' . $consulta . '
            ORDER BY

				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '

        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somasubtotal=0;
			$subtotal=0;
			$quantidade=0;
			$somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
			$somasubcomissao=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
				$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');
				$row->DataValidadeProduto = $this->basico->mascara_data($row->DataValidadeProduto, 'barras');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				$row->DevolvidoProduto = $this->basico->mascara_palavra_completa($row->DevolvidoProduto, 'NS');
				$row->ConcluidoServico = $this->basico->mascara_palavra_completa($row->ConcluidoServico, 'NS');
				$row->StatusComissao = $this->basico->mascara_palavra_completa($row->StatusComissao, 'NS');

                $somaorcamento += $row->ValorOrca;
                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

				$somadesconto += $row->ValorEntradaOrca;
                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');

				$somarestante += $row->ValorRestanteOrca;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');

				$quantidade += $row->QtdProduto;
                $row->QtdProduto = number_format($row->QtdProduto);
				
				$subtotal = $row->ValorProduto * $row->QtdProduto;
				$somasubtotal += $row->SubTotal;
				
				$subcomissao = $row->ValorProduto * $row->QtdProduto * $row->Comissao;
				$somasubcomissao += $row->SubComissao;
				
				$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');				
				$row->Comissao = number_format($row->Comissao, 2, ',', '.');				
				$row->SubTotal = number_format($row->SubTotal, 2, ',', '.');
				$row->SubComissao = number_format($row->SubComissao, 2, ',', '.');
				
            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');
			$query->soma->quantidade = number_format($quantidade);
			$query->soma->somasubtotal = number_format($somasubtotal, 2, ',', '.');
			$query->soma->somasubcomissao = number_format($somasubcomissao, 2, ',', '.');
			
            return $query;
        }

    }
	
    public function list1_produtosvend($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(AP.DataValidadeProduto >= "' . $data['DataInicio'] . '" AND AP.DataValidadeProduto <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(AP.DataValidadeProduto >= "' . $data['DataInicio'] . '")';
        }
		
        $data['NomeCliente'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeCliente'])) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(AP.DataValidadeProduto) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(AP.DataValidadeProduto) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(AP.DataValidadeProduto) = ' . $data['Ano'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro7 = ($data['FormaPag']) ? 'OT.FormaPagamento = "' . $data['FormaPag'] . '" AND ' : FALSE;
		$filtro8 = ($data['ConcluidoProduto']) ? 'AP.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro10 = ($data['DevolvidoProduto']) ? 'AP.DevolvidoProduto = "' . $data['DevolvidoProduto'] . '" AND ' : FALSE;
		$filtro9 = ($data['ConcluidoServico']) ? 'TS.ConcluidoServico = "' . $data['ConcluidoServico'] . '" AND ' : FALSE;		
		$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
		$data['Prodaux1'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		$data['Prodaux2'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				AP.idApp_Produto,
				AP.QtdProduto,
				AP.DataValidadeProduto,
				AP.ConcluidoProduto,
				AP.DevolvidoProduto,
				AP.ValorProduto,				
				TS.idApp_Servico,
				TS.QtdServico,
				TS.DataValidadeServico,
				TS.ConcluidoServico,
				TS.ValorServico,				
				TP.Produtos,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1,
				TR.TipoFinanceiro
            FROM
                App_OrcaTrata AS OT
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
				LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
				LEFT JOIN App_Produto AS AP ON AP.idApp_Orcatrata = OT.idApp_OrcaTrata
				LEFT JOIN App_Servico AS TS ON TS.idApp_Orcatrata = OT.idApp_OrcaTrata
				LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = AP.idTab_Produto
				LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Produto
				LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
				LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
				LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3				
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro10 . '
				OT.AprovadoOrca = "S" AND
				OT.idTab_TipoRD = "2" AND
				AP.idTab_TipoRD = "2"
                ' . $data['TipoFinanceiroR'] . '
				' . $data['Orcarec'] . '
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 				
				' . $data['NomeCliente'] . '
				' . $data['Produtos'] . '
				' . $data['Prodaux1'] . '
				' . $data['Prodaux2'] . '
				' . $data['Prodaux3'] . '
				
            ORDER BY
                AP.DataValidadeProduto DESC,
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '

        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somasubtotal=0;
			$subtotal=0;
			$quantidade=0;
			$somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
				$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');
				$row->DataValidadeProduto = $this->basico->mascara_data($row->DataValidadeProduto, 'barras');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				$row->DevolvidoProduto = $this->basico->mascara_palavra_completa($row->DevolvidoProduto, 'NS');
				$row->ConcluidoServico = $this->basico->mascara_palavra_completa($row->ConcluidoServico, 'NS');
				$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');
				
                $somaorcamento += $row->ValorOrca;
                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

				$somadesconto += $row->ValorEntradaOrca;
                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');

				$somarestante += $row->ValorRestanteOrca;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');

				$quantidade += $row->QtdProduto;
                $row->QtdProduto = number_format($row->QtdProduto);
				
				$subtotal = number_format(($row->ValorProduto * $row->QtdProduto), 2, ',', '.');
				$somasubtotal += $subtotal;
				
            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');
			$query->soma->quantidade = number_format($quantidade);
			$query->soma->somasubtotal = number_format($somasubtotal, 2, ',', '.');
			
            return $query;
        }

    }

    public function list2_produtoscomp($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(AP.DataValidadeProduto >= "' . $data['DataInicio'] . '" AND AP.DataValidadeProduto <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(AP.DataValidadeProduto >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeFornecedor'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeFornecedor'])) ? ' AND F.idApp_Fornecedor = ' . $data['NomeFornecedor'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(AP.DataValidadeProduto) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(AP.DataValidadeProduto) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(AP.DataValidadeProduto) = ' . $data['Ano'] : FALSE;
		$data['Orcades'] = ($data['Orcades']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcades'] : FALSE;		
		$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro7 = ($data['FormaPag']) ? 'OT.FormaPagamento = "' . $data['FormaPag'] . '" AND ' : FALSE;
		$filtro8 = ($data['ConcluidoProduto']) ? 'AP.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro10 = ($data['DevolvidoProduto']) ? 'AP.DevolvidoProduto = "' . $data['DevolvidoProduto'] . '" AND ' : FALSE;
		$filtro9 = ($data['ConcluidoServico']) ? 'TS.ConcluidoServico = "' . $data['ConcluidoServico'] . '" AND ' : FALSE;		
		$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
		$data['Prodaux1'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		$data['Prodaux2'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
				OT.Descricao,
				F.NomeFornecedor,
				OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				MD.Modalidade,
				VP.Abrev2,				
				VP.AVAP,
				TFP.FormaPag,
				AP.idApp_Produto,
				AP.QtdProduto,
				AP.DataValidadeProduto,
				AP.ConcluidoProduto,
				AP.DevolvidoProduto,
				AP.ValorProduto,
				TS.idApp_Servico,
				TS.QtdServico,
				TS.DataValidadeServico,
				TS.ConcluidoServico,
				TS.ValorServico,
				TP.Produtos,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1,
				TR.TipoFinanceiro
            FROM
                App_OrcaTrata AS OT
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
				LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
				LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
				LEFT JOIN App_Produto AS AP ON AP.idApp_Orcatrata = OT.idApp_OrcaTrata
				LEFT JOIN App_Servico AS TS ON TS.idApp_Orcatrata = OT.idApp_OrcaTrata
				LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = AP.idTab_Produto
				LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Produto
				LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
				LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
				LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND			
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro10 . '
				OT.AprovadoOrca = "S" AND
				OT.idTab_TipoRD = "1" AND
				AP.idTab_TipoRD = "1"
                ' . $data['TipoFinanceiroD'] . '
				' . $data['Orcades'] . '
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeFornecedor'] . '
				' . $data['Produtos'] . '
				' . $data['Prodaux1'] . '
				' . $data['Prodaux2'] . '
				' . $data['Prodaux3'] . '

            ORDER BY
                AP.DataValidadeProduto DESC,			
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '

        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

			$somasubtotal=0;
			$subtotal=0;
			$quantidade=0;
			$somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
				$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');
				$row->DataValidadeProduto = $this->basico->mascara_data($row->DataValidadeProduto, 'barras');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				$row->DevolvidoProduto = $this->basico->mascara_palavra_completa($row->DevolvidoProduto, 'NS');
				$row->ConcluidoServico = $this->basico->mascara_palavra_completa($row->ConcluidoServico, 'NS');
				$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');
				
                $somaorcamento += $row->ValorOrca;
                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

				$somadesconto += $row->ValorEntradaOrca;
                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');

				$somarestante += $row->ValorRestanteOrca;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');

				$quantidade += $row->QtdProduto;
                $row->QtdProduto = number_format($row->QtdProduto);
				
				$subtotal = number_format(($row->ValorProduto * $row->QtdProduto), 2, ',', '.');
				$somasubtotal += $subtotal;

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');
			$query->soma->quantidade = number_format($quantidade);
			$query->soma->somasubtotal = number_format($somasubtotal, 2, ',', '.');

            return $query;
        }

    }
		
	public function list1_receitasparc($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }
		
		#$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['NomeCliente'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeCliente'])) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        $query = $this->db->query(
            'SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.Tipo_Orca,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				OT.FormaPagamento,
				TR.TipoFinanceiro,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.ValorPago,
                PR.Quitado,
				TR.TipoFinanceiro
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . '
				' . $filtro6 . '
				' . $filtro7 . '
				OT.idTab_TipoRD = "2" AND
				PR.idTab_TipoRD = "2" 
                ' . $data['TipoFinanceiroR'] . '
				' . $data['Orcarec'] . '
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeCliente'] . '
			ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
		');

        ####################################################################
        #SOMAT�RIO DAS Parcelas Recebidas
		
        $parcelasrecebidas = $this->db->query(
            'SELECT
                PR.ValorParcela
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND				
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . '
				' . $filtro6 . '
				' . $filtro7 . '
				OT.idTab_TipoRD = "2" AND
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "2" AND
				PR.Quitado = "S"
                ' . $data['TipoFinanceiroR'] . '
				' . $data['Orcarec'] . '                
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeCliente'] . '				
 				
        ');			
		$parcelasrecebidas = $parcelasrecebidas->result();		
			/*
			  echo $this->db->last_query();
			  echo "<pre>";
			  print_r($query);
			  echo "</pre>";
			  exit();
			  */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

				#esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                
				if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somareceber += $row->ValorParcela;
				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');				
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.'); 			
				/*
				  echo $this->db->last_query();
				  echo "<pre>";
				  print_r($somaentrada);          
				  echo "</pre>";
				  exit();
				*/	
		  
            }

            foreach ($parcelasrecebidas as $row) {

                $somarecebido += $row->ValorParcela;
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }			

            $balanco =  $somareceber - $somarecebido;
			
			/*
			echo $this->db->last_query();
			echo "<pre>";
			print_r($balanco);
			echo "</pre>";
			exit();			
			*/
			
            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			
            return $query;
        }

    }
	
	public function list2_despesasparc($data, $completo) {


        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }

		$data['NomeFornecedor'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeFornecedor'])) ? ' AND F.idApp_Fornecedor = ' . $data['NomeFornecedor'] : FALSE;
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TD.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcades'] = ($data['Orcades']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcades'] : FALSE;		
		$data['Campo'] = (!$data['Campo']) ? 'F.NomeFornecedor' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                F.NomeFornecedor,
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				OT.FormaPagamento,
				TD.TipoFinanceiro,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.ValorPago,
                PR.Quitado,
				TD.TipoFinanceiro
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro6 . '
				OT.AprovadoOrca = "S" AND
				OT.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" 
                ' . $data['TipoFinanceiroD'] . '
				' . $data['Orcades'] . '                
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
				' . $data['NomeFornecedor'] . '
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
            ');
		

          
        ####################################################################
        #SOMAT�RIO DAS Parcelas Pagas
		
        $parcelaspagas = $this->db->query(
            'SELECT
                PR.ValorParcela
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND				
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro6 . '
				OT.idTab_TipoRD = "1" AND
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "1" AND
				PR.Quitado = "S"
                ' . $data['TipoFinanceiroD'] . '
				' . $data['Orcades'] . '                
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeFornecedor'] . '
 				
        ');			
		$parcelaspagas = $parcelaspagas->result();		
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         
		  echo $this->db->last_query();
          echo "<pre>";
          print_r($data['DataFim']);
          echo "</pre>";
          exit();		 
		 
		 */ 

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaentrada=$somareceber=$somarecebido=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                
				#esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }
				
                $somareceber += $row->ValorParcela;				
				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');				
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }

            foreach ($parcelaspagas as $row) {

                $somarecebido += $row->ValorParcela;
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }			

            $balanco =  $somareceber - $somarecebido;
			
			/*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($somareceberB);
          echo "</pre>";
          exit();
			*/

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');

            return $query;
        }

    }

	public function list1_receitasparcfiado($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }
		
		#$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['NomeCliente'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeCliente'])) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        $query = $this->db->query(
            'SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				TR.TipoFinanceiro,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.ValorPago,
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "2" AND
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "2" AND

				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
				' . $data['Orcarec'] . '
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeCliente'] . '				
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
		');

        ####################################################################
        #SOMAT�RIO DAS Parcelas Recebidas
		
        $parcelasrecebidas = $this->db->query(
            'SELECT
                PR.ValorParcela
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND				
				' . $permissao . '
				OT.idTab_TipoRD = "2" AND
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "2" AND

				PR.Quitado = "S" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
				' . $data['Orcarec'] . '                
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeCliente'] . '				
 				
        ');			
		$parcelasrecebidas = $parcelasrecebidas->result();		
			/*
			  echo $this->db->last_query();
			  echo "<pre>";
			  print_r($query);
			  echo "</pre>";
			  exit();
			  */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

				#esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                
				if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somareceber += $row->ValorParcela;
				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');				
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.'); 			
				/*
				  echo $this->db->last_query();
				  echo "<pre>";
				  print_r($somaentrada);          
				  echo "</pre>";
				  exit();
				*/	
		  
            }

            foreach ($parcelasrecebidas as $row) {

                $somarecebido += $row->ValorParcela;
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }			

            $balanco =  $somareceber - $somarecebido;
			
			/*
			echo $this->db->last_query();
			echo "<pre>";
			print_r($balanco);
			echo "</pre>";
			exit();			
			*/
			
            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			
            return $query;
        }

    }

	public function list1_fiadorec($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }
		
		#$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['NomeCliente'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeCliente'])) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        $query = $this->db->query(
            'SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				TR.TipoFinanceiro,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.ValorPago,
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "2" AND
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "2" AND

				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
				' . $data['Orcarec'] . '
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeCliente'] . '				
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
		');

        ####################################################################
        #SOMAT�RIO DAS Parcelas Recebidas
		
        $parcelasrecebidas = $this->db->query(
            'SELECT
                PR.ValorParcela
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND				
				' . $permissao . '
				OT.idTab_TipoRD = "2" AND
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "2" AND

				PR.Quitado = "S" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
				' . $data['Orcarec'] . '                
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeCliente'] . '				
 				
        ');			
		$parcelasrecebidas = $parcelasrecebidas->result();		
			/*
			  echo $this->db->last_query();
			  echo "<pre>";
			  print_r($query);
			  echo "</pre>";
			  exit();
			  */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

				#esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                
				if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somareceber += $row->ValorParcela;
				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');				
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.'); 			
				/*
				  echo $this->db->last_query();
				  echo "<pre>";
				  print_r($somaentrada);          
				  echo "</pre>";
				  exit();
				*/	
		  
            }

            foreach ($parcelasrecebidas as $row) {

                $somarecebido += $row->ValorParcela;
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }			

            $balanco =  $somareceber - $somarecebido;
			
			/*
			echo $this->db->last_query();
			echo "<pre>";
			print_r($balanco);
			echo "</pre>";
			exit();			
			*/
			
            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			
            return $query;
        }

    }
	
	public function list2_despesasparcfiado($data, $completo) {


        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }

		$data['NomeFornecedor'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeFornecedor'])) ? ' AND F.idApp_Fornecedor = ' . $data['NomeFornecedor'] : FALSE;
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TD.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcades'] = ($data['Orcades']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcades'] : FALSE;		
		$data['Campo'] = (!$data['Campo']) ? 'F.NomeFornecedor' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                F.NomeFornecedor,
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				TD.TipoFinanceiro,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.ValorPago,
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "1" AND				
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "1" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
                ' . $data['TipoFinanceiroD'] . '
				' . $data['Orcades'] . '                
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
				' . $data['NomeFornecedor'] . '
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
            ');

        ####################################################################
        #SOMAT�RIO DAS Parcelas Pagas
		
        $parcelaspagas = $this->db->query(
            'SELECT
                PR.ValorParcela
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND				
				' . $permissao . '
				OT.idTab_TipoRD = "1" AND
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "1" AND
				PR.Quitado = "S" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
                ' . $data['TipoFinanceiroD'] . '
				' . $data['Orcades'] . '                
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeFornecedor'] . '
 				
        ');			
		$parcelaspagas = $parcelaspagas->result();		
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */ 

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaentrada=$somareceber=$somarecebido=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                
				#esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }
				
                $somareceber += $row->ValorParcela;				
				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');				
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }

            foreach ($parcelaspagas as $row) {

                $somarecebido += $row->ValorParcela;
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }			

            $balanco =  $somareceber - $somarecebido;
			
			/*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($somareceberB);
          echo "</pre>";
          exit();
			*/

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');

            return $query;
        }

    }

	public function list2_fiadodesp($data, $completo) {


        if ($data['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '" AND PR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '" AND PR.DataPago <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(PR.DataPago >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '" AND OT.DataOrca <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataOrca >= "' . $data['DataInicio3'] . '")';
        }

		$data['NomeFornecedor'] = (($_SESSION['log']['idSis_Empresa'] != 5) && ($data['NomeFornecedor'])) ? ' AND F.idApp_Fornecedor = ' . $data['NomeFornecedor'] : FALSE;
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroD'] = ($data['TipoFinanceiroD']) ? ' AND TD.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroD'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcades'] = ($data['Orcades']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcades'] : FALSE;		
		$data['Campo'] = (!$data['Campo']) ? 'F.NomeFornecedor' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                F.NomeFornecedor,
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				TD.TipoFinanceiro,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.ValorPago,
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "1" AND				
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "1" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
                ' . $data['TipoFinanceiroD'] . '
				' . $data['Orcades'] . '                
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
				' . $data['NomeFornecedor'] . '
            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
            ');

        ####################################################################
        #SOMAT�RIO DAS Parcelas Pagas
		
        $parcelaspagas = $this->db->query(
            'SELECT
                PR.ValorParcela
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $consulta . ' AND				
				' . $permissao . '
				OT.idTab_TipoRD = "1" AND
				OT.AprovadoOrca = "S" AND
				PR.idTab_TipoRD = "1" AND
				PR.Quitado = "S" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
                ' . $data['TipoFinanceiroD'] . '
				' . $data['Orcades'] . '                
				' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . '
				' . $data['NomeFornecedor'] . '
 				
        ');			
		$parcelaspagas = $parcelaspagas->result();		
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */ 

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaentrada=$somareceber=$somarecebido=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                
				#esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }
				
                $somareceber += $row->ValorParcela;				
				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');				
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }

            foreach ($parcelaspagas as $row) {

                $somarecebido += $row->ValorParcela;
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }			

            $balanco =  $somareceber - $somarecebido;
			
			/*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($somareceberB);
          echo "</pre>";
          exit();
			*/

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');

            return $query;
        }

    }
	
	public function list1_receitadiaria($data, $completo) {

		$data['Diavenc'] = ($data['Diavenc']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Diavenc'] : FALSE;
		$data['Diapag'] = ($data['Diapag']) ? ' AND DAY(PR.DataPago) = ' . $data['Diapag'] : FALSE;	
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado'] != '#') ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade'] != '#') ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				OT.Descricao,
				CONCAT(IFNULL(TR.TipoFinanceiro,""), " / ", IFNULL(C.NomeCliente,""), " / ", IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
				
                PR.DataPago,
                PR.ValorPago,
				
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				PR.Quitado = "S" AND
				' . $permissao . '

				OT.idTab_TipoRD = "2"
                ' . $data['Diavenc'] . ' 
				' . $data['Mesvenc'] . '
				' . $data['Ano'] . ' 
            ORDER BY
				PR.DataVencimento
            ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somarecebido += $row->ValorParcela;
                $somareceber += $row->ValorParcela;


                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');

            }
            $somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }
	
	public function list2_despesadiaria($data, $completo) {

		$data['Diavenc'] = ($data['Diavenc']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Diavenc'] : FALSE;
		$data['Diapag'] = ($data['Diapag']) ? ' AND DAY(PR.DataPago) = ' . $data['Diapag'] : FALSE;		
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TD.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado'] != '#') ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade'] != '#') ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query(
            'SELECT
                
                OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
				OT.ObsOrca,
				OT.Descricao,
				CONCAT(IFNULL(TD.TipoFinanceiro,""), " / ", IFNULL(OT.Descricao,"")) AS TipoFinanceiro,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.Modalidade,
				MD.Modalidade,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
				
                PR.DataPago,
                PR.ValorPago,
				
                PR.Quitado
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				PR.Quitado = "S" AND
				' . $permissao . '
				OT.idTab_TipoRD = "1"
                ' . $data['Diavenc'] . ' 
				' . $data['Mesvenc'] . '				
				' . $data['Ano'] . ' 

            ORDER BY
				PR.DataVencimento
            ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');

                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }

                $somarecebido += $row->ValorParcela;
                $somareceber += $row->ValorParcela;


                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');

            }
            $somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;

            $query->soma = new stdClass();
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');

            return $query;
        }

    }
	
    public function list_balancoanual($data) {
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
        $permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		####################################################################
        #SOMAT�RIO DAS RECEITAS Pago DO ANO
        $somareceitas='';
        for ($i=1;$i<=12;$i++){
            $somareceitas .= 'SUM(IF(PR.DataVencimento BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somareceitas = substr($somareceitas, 0 ,-2);

		$query['RecPago'] = $this->db->query(
        #$receitas = $this->db->query(
            'SELECT
				' . $somareceitas . '
            FROM

                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "2" AND
				PR.idTab_TipoRD = "2" AND
				' . $filtro4 . '
            	YEAR(PR.DataVencimento) = ' . $data['Ano']
        );

        #$query['RecPago'] = $query['RecPago']->result_array();
        $query['RecPago'] = $query['RecPago']->result();
        $query['RecPago'][0]->Balancopago = 'Receitas';

        ####################################################################
        #SOMAT�RIO DAS RECEITAS � Pagar DO ANO
        $somareceitaspagar='';
        for ($i=1;$i<=12;$i++){
            $somareceitaspagar .= 'SUM(IF(PR.DataVencimento BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somareceitaspagar = substr($somareceitaspagar, 0 ,-2);
       
		$query['RecPagar'] = $this->db->query(
        #$receitas = $this->db->query(
            'SELECT
				' . $somareceitaspagar . '
            FROM

                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "2" AND
				PR.idTab_TipoRD = "2" AND
				' . $filtro4 . '
            	YEAR(PR.DataVencimento) = ' . $data['Ano']
        );

        #$query['RecPagar'] = $query['RecPagar']->result_array();
        $query['RecPagar'] = $query['RecPagar']->result();
        $query['RecPagar'][0]->Balancopagar = 'Receber';
		
        ####################################################################
        #SOMAT�RIO DAS RECEITAS Venc. DO ANO
        $somareceitasvenc='';
        for ($i=1;$i<=12;$i++){
            $somareceitasvenc .= 'SUM(IF(PR.DataVencimento BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somareceitasvenc = substr($somareceitasvenc, 0 ,-2);
		
        $query['RecVenc'] = $this->db->query(
        #$receitas = $this->db->query(
            'SELECT
                ' . $somareceitasvenc . '
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "2" AND
				PR.idTab_TipoRD = "2" AND
				' . $filtro4 . '
            	YEAR(PR.DataVencimento) = ' . $data['Ano']
        );

        #$query['RecVenc'] = $query['RecVenc']->result_array();
        $query['RecVenc'] = $query['RecVenc']->result();
        $query['RecVenc'][0]->Balancovenc = 'Rec.Esp';


        ####################################################################
        #SOMAT�RIO DAS DESPESAS PAGAS DO ANO
        $somadespesas='';
        for ($i=1;$i<=12;$i++){
            $somadespesas .= 'SUM(IF(PR.DataVencimento BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somadespesas = substr($somadespesas, 0 ,-2);
		
        $query['DesPago'] = $this->db->query(
        #$despesas = $this->db->query(
            'SELECT
                ' . $somadespesas . '
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" AND
				' . $filtro4 . '				
            	YEAR(PR.DataVencimento) = ' . $data['Ano']
        );

        #$query['DesPago'] = $query['DesPago']->result_array();
        $query['DesPago'] = $query['DesPago']->result();
        $query['DesPago'][0]->Balancopago = 'Despesas';

        ####################################################################
        #SOMAT�RIO DAS DESPESAS � PAGAR DO ANO
        $somadespesaspagar='';
        for ($i=1;$i<=12;$i++){
            $somadespesaspagar .= 'SUM(IF(PR.DataVencimento BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somadespesaspagar = substr($somadespesaspagar, 0 ,-2);
		
        $query['DesPagar'] = $this->db->query(
        #$despesas = $this->db->query(
            'SELECT
                ' . $somadespesaspagar . '
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" AND
				' . $filtro4 . '				
            	YEAR(PR.DataVencimento) = ' . $data['Ano']
        );

        #$query['DesPagar'] = $query['DesPagar']->result_array();
        $query['DesPagar'] = $query['DesPagar']->result();
        $query['DesPagar'][0]->Balancopagar = 'Pagar';
		
        ####################################################################
        #SOMAT�RIO DAS DESPESAS Venc DO ANO
        $somadespesasvenc='';
        for ($i=1;$i<=12;$i++){
            $somadespesasvenc .= 'SUM(IF(PR.DataVencimento BETWEEN "' . $data['Ano'] . '-' . $i . '-1" AND
                LAST_DAY("' . $data['Ano'] . '-' . $i . '-1"), PR.ValorParcela, 0)) AS M' . $i . ', ';
        }
        $somadespesasvenc = substr($somadespesasvenc, 0 ,-2);

        $query['DesVenc'] = $this->db->query(
        #$despesas = $this->db->query(
            'SELECT
                ' . $somadespesasvenc . '
            FROM
                App_OrcaTrata AS OT
                    LEFT JOIN Sis_Usuario AS C ON C.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				' . $permissao . '
				OT.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" AND
				' . $filtro4 . '
            	YEAR(PR.DataVencimento) = ' . $data['Ano']
        );

        #$query['DesVenc'] = $query['DesVenc']->result_array();
        $query['DesVenc'] = $query['DesVenc']->result();
        $query['DesVenc'][0]->Balancovenc = 'Desp.Esp';
		
        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit();
        */
		#$query['RecVenc'] = $query['RecVenc']->result();
		$query['RecVenc'][0]->BalancoResRec = 'RecVenc';
		#$query['RecPago'] = $query['RecPago']->result();
		$query['RecPago'][0]->BalancoResRec = 'RecPago';
		#$query['RecPagar'] = $query['RecPagar']->result();
		$query['RecPagar'][0]->BalancoResRec = 'RecPagar';		
		#$query['DesVenc'] = $query['DesVenc']->result();
		$query['DesVenc'][0]->BalancoResDes = 'DesVenc';
		#$query['DesPago'] = $query['DesPago']->result();
		$query['DesPago'][0]->BalancoResDes = 'DesPago';
		#$query['DesPagar'] = $query['DesPagar']->result();
		$query['DesPagar'][0]->BalancoResDes = 'DesPagar';		
		
        $query['TotalPago'] = new stdClass();
        $query['TotalGeralpago'] = new stdClass();
        $query['TotalPagar'] = new stdClass();
        $query['TotalGeralpagar'] = new stdClass();		
        $query['TotalVenc'] = new stdClass();
        $query['TotalGeralvenc'] = new stdClass();
		$query['TotalResRec'] = new stdClass();
        $query['TotalGeralResRec'] = new stdClass();
		$query['TotalResDes'] = new stdClass();
        $query['TotalGeralResDes'] = new stdClass();
		
        $query['TotalPago']->Balancopago = 'Balan�o';
        $query['TotalGeralpago']->RecPago = $query['TotalGeralpago']->DesPago = $query['TotalGeralpago']->BalancoGeralpago = 0;
        $query['TotalPagar']->Balancopagar = 'Bal.Pagar';
        $query['TotalGeralpagar']->RecPagar = $query['TotalGeralpagar']->DesPagar = $query['TotalGeralpagar']->BalancoGeralpagar = 0;		
        $query['TotalVenc']->Balancovenc = 'Bal.Esp';
        $query['TotalGeralvenc']->RecVenc = $query['TotalGeralvenc']->DesVenc = $query['TotalGeralvenc']->BalancoGeralvenc = 0;
		$query['TotalResRec']->BalancoResRec = 'TotalResRec';
        $query['TotalGeralResRec']->RecVenc = $query['TotalGeralResRec']->RecPago = $query['TotalGeralResRec']->BalancoGeralResRec = 0;
		$query['TotalResDes']->BalancoResDes = 'TotalResDes';
        $query['TotalGeralResDes']->DesVenc = $query['TotalGeralResDes']->DesPago = $query['TotalGeralResDes']->BatancoGeralResDes = 0;
		
        for ($i=1;$i<=12;$i++) {
            $query['TotalVenc']->{'M'.$i} = $query['RecVenc'][0]->{'M'.$i} - $query['DesVenc'][0]->{'M'.$i};

            $query['TotalGeralvenc']->RecVenc += $query['RecVenc'][0]->{'M'.$i};
            $query['TotalGeralvenc']->DesVenc += $query['DesVenc'][0]->{'M'.$i};

            $query['RecVenc'][0]->{'M'.$i} = number_format($query['RecVenc'][0]->{'M'.$i}, 2, ',', '.');
			$query['DesVenc'][0]->{'M'.$i} = number_format($query['DesVenc'][0]->{'M'.$i}, 2, ',', '.');
            $query['TotalVenc']->{'M'.$i} = number_format($query['TotalVenc']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralvenc']->BalancoGeralvenc = $query['TotalGeralvenc']->RecVenc - $query['TotalGeralvenc']->DesVenc;

        $query['TotalGeralvenc']->RecVenc = number_format($query['TotalGeralvenc']->RecVenc, 2, ',', '.');
		$query['TotalGeralvenc']->DesVenc = number_format($query['TotalGeralvenc']->DesVenc, 2, ',', '.');
        $query['TotalGeralvenc']->BalancoGeralvenc = number_format($query['TotalGeralvenc']->BalancoGeralvenc, 2, ',', '.');

        for ($i=1;$i<=12;$i++) {
            $query['TotalPago']->{'M'.$i} = $query['RecPago'][0]->{'M'.$i} - $query['DesPago'][0]->{'M'.$i};

            $query['TotalGeralpago']->RecPago += $query['RecPago'][0]->{'M'.$i};
            $query['TotalGeralpago']->DesPago += $query['DesPago'][0]->{'M'.$i};

            #$query['RecPago'][0]->{'M'.$i} = number_format($query['RecPago'][0]->{'M'.$i}, 2, ',', '.');
			#$query['DesPago'][0]->{'M'.$i} = number_format($query['DesPago'][0]->{'M'.$i}, 2, ',', '.');
            #$query['TotalPago']->{'M'.$i} = number_format($query['TotalPago']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralpago']->BalancoGeralpago = $query['TotalGeralpago']->RecPago - $query['TotalGeralpago']->DesPago;

        $query['TotalGeralpago']->RecPago = number_format($query['TotalGeralpago']->RecPago, 2, ',', '.');
		$query['TotalGeralpago']->DesPago = number_format($query['TotalGeralpago']->DesPago, 2, ',', '.');
        $query['TotalGeralpago']->BalancoGeralpago = number_format($query['TotalGeralpago']->BalancoGeralpago, 2, ',', '.');
		
        for ($i=1;$i<=12;$i++) {
            $query['TotalPagar']->{'M'.$i} = $query['RecPagar'][0]->{'M'.$i} - $query['DesPagar'][0]->{'M'.$i};

            $query['TotalGeralpagar']->RecPagar += $query['RecPagar'][0]->{'M'.$i};
            $query['TotalGeralpagar']->DesPagar += $query['DesPagar'][0]->{'M'.$i};

            #$query['RecPagar'][0]->{'M'.$i} = number_format($query['RecPagar'][0]->{'M'.$i}, 2, ',', '.');
			#$query['DesPagar'][0]->{'M'.$i} = number_format($query['DesPagar'][0]->{'M'.$i}, 2, ',', '.');
            $query['TotalPagar']->{'M'.$i} = number_format($query['TotalPagar']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralpagar']->BalancoGeralpagar = $query['TotalGeralpagar']->RecPagar - $query['TotalGeralpagar']->DesPagar;

        $query['TotalGeralpagar']->RecPagar = number_format($query['TotalGeralpagar']->RecPagar, 2, ',', '.');
		$query['TotalGeralpagar']->DesPagar = number_format($query['TotalGeralpagar']->DesPagar, 2, ',', '.');
        $query['TotalGeralpagar']->BalancoGeralpagar = number_format($query['TotalGeralpagar']->BalancoGeralpagar, 2, ',', '.');		

        for ($i=1;$i<=12;$i++) {
            $query['TotalResRec']->{'M'.$i} = $query['RecVenc'][0]->{'M'.$i} - $query['RecPago'][0]->{'M'.$i};

            $query['TotalGeralResRec']->RecVenc += $query['RecVenc'][0]->{'M'.$i};
            $query['TotalGeralResRec']->RecPago += $query['RecPago'][0]->{'M'.$i};

            #$query['RecVenc'][0]->{'M'.$i} = number_format($query['RecVenc'][0]->{'M'.$i}, 2, ',', '.');
			#$query['RecPago'][0]->{'M'.$i} = number_format($query['RecPago'][0]->{'M'.$i}, 2, ',', '.');
            #$query['TotalResRec']->{'M'.$i} = number_format($query['TotalResRec']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralResRec']->BalancoGeralResRec = $query['TotalGeralResRec']->RecVenc - $query['TotalGeralResRec']->RecPago;

        #$query['TotalGeralResRec']->RecVenc = number_format($query['TotalGeralResRec']->RecVenc, 2, ',', '.');
		#$query['TotalGeralResRec']->RecPago = number_format($query['TotalGeralResRec']->RecPago, 2, ',', '.');
        $query['TotalGeralResRec']->BalancoGeralResRec = number_format($query['TotalGeralResRec']->BalancoGeralResRec, 2, ',', '.');
		
        for ($i=1;$i<=12;$i++) {
            $query['TotalResDes']->{'M'.$i} = $query['DesVenc'][0]->{'M'.$i} - $query['DesPago'][0]->{'M'.$i};

            $query['TotalGeralResDes']->DesVenc += $query['DesVenc'][0]->{'M'.$i};
            $query['TotalGeralResDes']->DesPago += $query['DesPago'][0]->{'M'.$i};

            #$query['DesVenc'][0]->{'M'.$i} = number_format($query['DesVenc'][0]->{'M'.$i}, 2, ',', '.');
			#$query['DesPago'][0]->{'M'.$i} = number_format($query['DesPago'][0]->{'M'.$i}, 2, ',', '.');
            #$query['TotalResDes']->{'M'.$i} = number_format($query['TotalResDes']->{'M'.$i}, 2, ',', '.');
        }		
        $query['TotalGeralResDes']->BalancoGeralResDes = $query['TotalGeralResDes']->DesVenc - $query['TotalGeralResDes']->DesPago;

        #$query['TotalGeralResDes']->DesVenc = number_format($query['TotalGeralResDes']->DesVenc, 2, ',', '.');
		#$query['TotalGeralResDes']->DesPago = number_format($query['TotalGeralResDes']->DesPago, 2, ',', '.');
        $query['TotalGeralResDes']->BalancoGeralResDes = number_format($query['TotalGeralResDes']->BalancoGeralResDes, 2, ',', '.');
		
        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit();
        */
        return $query;

    }

	public function list_rankingformapag($data) {

        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
		
		$data['FormaPag'] = ($data['FormaPag']) ? ' AND FP.idTab_FormaPag = ' . $data['FormaPag'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'FP.FormaPag' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        ####################################################################
        #LISTA DE Forma de Pagamento
        $query['FormaPag'] = $this->db->query('
            SELECT
                FP.idTab_FormaPag,
                CONCAT(IFNULL(FP.FormaPag,"")) AS FormaPag
            FROM
                Tab_FormaPag AS FP
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.FormaPagamento = FP.idTab_FormaPag
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
				TPR.Quitado = "S" AND
				' . $consulta . '
                ' . $data['FormaPag'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        $query['FormaPag'] = $query['FormaPag']->result();		
		
        ####################################################################
        #Parcelas 

        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idApp_Cliente,
				FP.idTab_FormaPag
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = TOT.FormaPagamento
					LEFT JOIN App_Cliente AS TC ON TC.idApp_Cliente = TOT.idApp_Cliente
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['FormaPag'] . ' AND
                TOT.AprovadoOrca = "S" AND
				TPR.Quitado = "S" AND
				TPR.idTab_TipoRD = "2" AND
                TC.idApp_Cliente != "0"
            GROUP BY
                FP.idTab_FormaPag
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Parcelas'] = $query['Parcelas']->result();
		
		$rankingvendas = new stdClass();
		#$estoque = array();
        foreach ($query['FormaPag'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $rankingvendas->{$row->idTab_FormaPag} = new stdClass();
            $rankingvendas->{$row->idTab_FormaPag}->FormaPag = $row->FormaPag;
        }


				/*
		echo "<pre>";
		print_r($query['Comprados']);
		echo "</pre>";
		exit();*/
		
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idTab_FormaPag}))
                $rankingvendas->{$row->idTab_FormaPag}->QtdParc = $row->QtdParc;
        }
		
		$rankingvendas->soma = new stdClass();
		$somaqtdorcam = $somaqtddescon = $somaqtdvendida = $somaqtdparc = $somaqtddevol = 0;

		foreach ($rankingvendas as $row) {
	
			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;
			#$row->QtdDevol = (!isset($row->QtdDevol)) ? 0 : $row->QtdDevol;
		
			$somaqtdparc += $row->QtdParc;
			#$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');																
        }
		
		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');
        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }

	public function list_rankingformaentrega($data) {

        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
		
		$data['TipoFrete'] = ($data['TipoFrete']) ? ' AND FP.idTab_TipoFrete = ' . $data['TipoFrete'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'FP.TipoFrete' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        ####################################################################
        #LISTA DE Forma de Pagamento
        $query['TipoFrete'] = $this->db->query('
            SELECT
                FP.idTab_TipoFrete,
                CONCAT(IFNULL(FP.TipoFrete,"")) AS TipoFrete
            FROM
                Tab_TipoFrete AS FP
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.TipoFrete = FP.idTab_TipoFrete
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
				TPR.Quitado = "S" AND
				' . $consulta . '
                ' . $data['TipoFrete'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        $query['TipoFrete'] = $query['TipoFrete']->result();		
		
        ####################################################################
        #Parcelas 

        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idApp_Cliente,
				FP.idTab_TipoFrete
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN Tab_TipoFrete AS FP ON FP.idTab_TipoFrete = TOT.TipoFrete
					LEFT JOIN App_Cliente AS TC ON TC.idApp_Cliente = TOT.idApp_Cliente
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['TipoFrete'] . ' AND
                TOT.AprovadoOrca = "S" AND
				TPR.Quitado = "S" AND
				TPR.idTab_TipoRD = "2" AND
                TC.idApp_Cliente != "0"
            GROUP BY
                FP.idTab_TipoFrete
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Parcelas'] = $query['Parcelas']->result();
		
        ####################################################################
        #Entregador 

        $query['Entregador'] = $this->db->query('
            SELECT
                TOT.ValorFrete AS QtdEntrega,
				FP.idTab_TipoFrete,
				SUE.Nome
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN Sis_Usuario AS SUE ON SUE.idSis_Usuario = TOT.Entregador
					LEFT JOIN Tab_TipoFrete AS FP ON FP.idTab_TipoFrete = TOT.TipoFrete
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TOT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TOT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['TipoFrete'] . ' AND
                TOT.AprovadoOrca = "S" AND
				TOT.QuitadoOrca = "S" AND
				TOT.idTab_TipoRD = "2" 
            GROUP BY
                FP.idTab_TipoFrete
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        $query['Entregador'] = $query['Entregador']->result();		
		
		$rankingvendas = new stdClass();
		#$estoque = array();
        foreach ($query['TipoFrete'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $rankingvendas->{$row->idTab_TipoFrete} = new stdClass();
            $rankingvendas->{$row->idTab_TipoFrete}->TipoFrete = $row->TipoFrete;
        }

		/*
		echo "<pre>";
		print_r($query['Comprados']);
		echo "</pre>";
		exit();
		*/
		
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idTab_TipoFrete}))
                $rankingvendas->{$row->idTab_TipoFrete}->QtdParc = $row->QtdParc;
        }
		
		foreach ($query['Entregador'] as $row) {
            if (isset($rankingvendas->{$row->idTab_TipoFrete}))
                $rankingvendas->{$row->idTab_TipoFrete}->QtdEntrega = $row->QtdEntrega;
        }
		
		$rankingvendas->soma = new stdClass();
		$somaqtdparc = $somaqtdentrega = 0;

		foreach ($rankingvendas as $row) {
	
			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;
			$row->QtdEntrega = (!isset($row->QtdEntrega)) ? 0 : $row->QtdEntrega;
		
			$somaqtdparc += $row->QtdParc;
			#$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');
			$somaqtdentrega += $row->QtdEntrega;
			#$row->QtdEntrega = number_format($row->QtdEntrega, 2, ',', '.');
        }
		
		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');
		$rankingvendas->soma->somaqtdentrega = number_format($somaqtdentrega, 2, ',', '.');
        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }
	
    public function list_estoque($data) {
        
		if ($data['DataFim']) {
            $consulta =
                '(APV.DataValidadeProduto >= "' . $data['DataInicio'] . '" AND APV.DataValidadeProduto <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(APV.DataValidadeProduto >= "' . $data['DataInicio'] . '")';
        }
        $data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produtos = ' . $data['Produtos'] : FALSE;

        $data['Campo'] = (!$data['Campo']) ? 'TP.Nome_Prod' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        
		
		####################################################################
        #LISTA DE PRODUTOS
        $query['Produtos'] = $this->db->query('
            SELECT
                TP.idTab_Produtos,
				TP.TipoProduto,
				TOP2.Opcao,
				TOP1.Opcao,
                CONCAT(IFNULL(TP.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,"")) AS Produtos
            FROM
				Tab_Produtos AS TP
					LEFT JOIN App_Produto AS APV ON APV.idTab_Produtos_Produto = TP.idTab_Produtos
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TP.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TP.Opcao_Atributo_2
 
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TP.Prod_Serv = "P" 

				' . $data['Produtos'] . '
				
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        $query['Produtos'] = $query['Produtos']->result();

        ####################################################################
        #LISTA DE PRODAUX1


        ####################################################################
        #LISTA DE PRODAUX2


        ####################################################################
        #LISTA DE PRODAUX3

		
        ####################################################################
        #COMPRADOS
		
        $query['Comprados'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto * APV.QtdIncrementoProduto) AS QtdCompra,
                TP.idTab_Produtos
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
                    LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APV.idTab_Produtos_Produto					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                
				APV.idTab_TipoRD = "1" AND
				TP.Prod_Serv = "P" AND
				APV.ConcluidoProduto = "S"
				' . $data['Produtos'] . '
			GROUP BY
                TP.idTab_Produtos
            ORDER BY
                TP.Nome_Prod ASC				

        ');
        $query['Comprados'] = $query['Comprados']->result();

        ####################################################################
        #VENDIDOS
		
        $query['Vendidos'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto * APV.QtdIncrementoProduto) AS QtdVenda,
                TP.idTab_Produtos
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
                    LEFT JOIN Tab_Produtos AS TP ON TP.idTab_Produtos = APV.idTab_Produtos_Produto					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND

                TP.Prod_Serv = "P" AND
				APV.idTab_TipoRD = "2"
				' . $data['Produtos'] . '
			GROUP BY
                TP.idTab_Produtos
            ORDER BY
                TP.Nome_Prod ASC				

        ');
        $query['Vendidos'] = $query['Vendidos']->result();


        ####################################################################
        #DEVOLVIDO DOS COMPRADOS
		

		
/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/		
        ####################################################################
        #DEVOLVIDO DOS VENDIDOS
		

		
        ####################################################################
        #CONSUMIDOS
		
/*		
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/
		$estoque = new stdClass();
		#$estoque = array();
        foreach ($query['Produtos'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $estoque->{$row->idTab_Produtos} = new stdClass();
            $estoque->{$row->idTab_Produtos}->Produtos = $row->Produtos;
        }


        foreach ($query['Comprados'] as $row) {
            if (isset($estoque->{$row->idTab_Produtos}))
                $estoque->{$row->idTab_Produtos}->QtdCompra = $row->QtdCompra;
		}

        foreach ($query['Vendidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produtos}))
                $estoque->{$row->idTab_Produtos}->QtdVenda = $row->QtdVenda;
        }
		

		$estoque->soma = new stdClass();
		$somaqtdcompra = $somaqtdvenda = $somaqtdestoque = 0;

		foreach ($estoque as $row) {

			$row->QtdCompra = (!isset($row->QtdCompra)) ? 0 : $row->QtdCompra;
            $row->QtdVenda = (!isset($row->QtdVenda)) ? 0 : $row->QtdVenda;

            
			$row->QtdEstoque = $row->QtdCompra - $row->QtdVenda;

			$somaqtdcompra += $row->QtdCompra;
			$row->QtdCompra = ($row->QtdCompra);

			$somaqtdvenda += $row->QtdVenda;
			$row->QtdVenda = ($row->QtdVenda);

			$somaqtdestoque += $row->QtdEstoque;
			$row->QtdEstoque = ($row->QtdEstoque);

        }


		$estoque->soma->somaqtdcompra = ($somaqtdcompra);
		$estoque->soma->somaqtdvenda = ($somaqtdvenda);
		$estoque->soma->somaqtdestoque = ($somaqtdestoque);

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $estoque;

    }

    public function list_estoque_Copia($data) {
        
		if ($data['DataFim']) {
            $consulta =
                '(APV.DataValidadeProduto >= "' . $data['DataInicio'] . '" AND APV.DataValidadeProduto <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(APV.DataValidadeProduto >= "' . $data['DataInicio'] . '")';
        }
        $data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
        $data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
        $data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        ####################################################################
        #LISTA DE PRODUTOS
        $query['Produtos'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
				TP.TipoProduto,
                CONCAT(IFNULL(TP.TipoProduto,""), " - ", IFNULL(TP.Produtos,""), " - ", IFNULL(TV.Convdesc,"")) AS Produtos,
                TV.Convdesc,
				TP1.Prodaux1,
                TP2.Prodaux2,
                TP3.Prodaux3
            FROM
				Tab_Produto AS TP
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produto = TP.idTab_Produto
					LEFT JOIN App_Produto AS APV ON APV.idTab_Produto = TV.idTab_Valor
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3 
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
				' . $data['Produtos'] . '
                ' . $data['Prodaux1'] . '
                ' . $data['Prodaux2'] . '
                ' . $data['Prodaux3'] . ' AND
				TV.idTab_Produto = TP.idTab_Produto
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Produtos'] = $query['Produtos']->result();

        ####################################################################
        #LISTA DE PRODAUX1
        $query['Prodaux1'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP1.Prodaux1,"")) AS Prodaux1,
                TP1.Prodaux1
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux1'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux1'] = $query['Prodaux1']->result();

        ####################################################################
        #LISTA DE PRODAUX2
        $query['Prodaux2'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP2.Prodaux2,"")) AS Prodaux2,
                TP2.Prodaux2
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux2'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux2'] = $query['Prodaux2']->result();

        ####################################################################
        #LISTA DE PRODAUX3
        $query['Prodaux3'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP3.Prodaux3,"")) AS Prodaux3,
                TP3.Prodaux3
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux3'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux3'] = $query['Prodaux3']->result();
		
        ####################################################################
        #COMPRADOS
		
        $query['Comprados'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto) AS QtdCompra,
                TP.idTab_Produto
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')  
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "1" AND
				APV.ConcluidoProduto = "S"
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['Comprados'] = $query['Comprados']->result();

        ####################################################################
        #VENDIDOS
		
        $query['Vendidos'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto) AS QtdVenda,
                TP.idTab_Produto
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "2"
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['Vendidos'] = $query['Vendidos']->result();


        ####################################################################
        #DEVOLVIDO DOS COMPRADOS
		
        $query['DevCompra'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto) AS QtdDevCompra,
                TP.idTab_Produto
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')  
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "1" AND
				APV.DevolvidoProduto = "S"
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['DevCompra'] = $query['DevCompra']->result();
		
/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/		
        ####################################################################
        #DEVOLVIDO DOS VENDIDOS
		
        $query['DevVenda'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto) AS QtdDevVenda,
                TP.idTab_Produto
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')  
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "2" AND
				APV.DevolvidoProduto = "S"
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['DevVenda'] = $query['DevVenda']->result();
		
        ####################################################################
        #CONSUMIDOS

        $query['Consumidos'] = $this->db->query(
            'SELECT
                (APV.QtdProduto) AS QtdConsumo,
                TP.idTab_Produto
            FROM
				App_Produto AS APV 
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata                   
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ') 			
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "5" AND
				APV.ConcluidoProduto = "S"
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Consumidos'] = $query['Consumidos']->result();		

		$estoque = new stdClass();
		#$estoque = array();
        foreach ($query['Produtos'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $estoque->{$row->idTab_Produto} = new stdClass();
            $estoque->{$row->idTab_Produto}->Produtos = $row->Produtos;
        }

        foreach ($query['Prodaux1'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux1 = $row->Prodaux1;
        }

        foreach ($query['Prodaux2'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux2 = $row->Prodaux2;
        }

        foreach ($query['Prodaux3'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux3 = $row->Prodaux3;
        }

/*		
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/
        foreach ($query['Comprados'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdCompra = $row->QtdCompra;
		}

        foreach ($query['Vendidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdVenda = $row->QtdVenda;
        }
		
        foreach ($query['DevVenda'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdDevVenda = $row->QtdDevVenda;
        }
				
        foreach ($query['DevCompra'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdDevCompra = $row->QtdDevCompra;
        }		

        foreach ($query['Consumidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdConsumo = $row->QtdConsumo;
        }

		$estoque->soma = new stdClass();
		$somaqtdcompra = $somaqtdvenda = $somaqtddevvenda = $somaqtddevcompra = $somaqtdconsumo = $somaqtdestoque = 0;

		foreach ($estoque as $row) {

			$row->QtdCompra = (!isset($row->QtdCompra)) ? 0 : $row->QtdCompra;
            $row->QtdVenda = (!isset($row->QtdVenda)) ? 0 : $row->QtdVenda;
            $row->QtdDevVenda = (!isset($row->QtdDevVenda)) ? 0 : $row->QtdDevVenda;			
            $row->QtdDevCompra = (!isset($row->QtdDevCompra)) ? 0 : $row->QtdDevCompra;			
            $row->QtdConsumo = (!isset($row->QtdConsumo)) ? 0 : $row->QtdConsumo;
            
			$row->QtdEstoque = $row->QtdCompra - $row->QtdVenda  - $row->QtdDevCompra + $row->QtdDevVenda;

			$somaqtdcompra += $row->QtdCompra;
			$row->QtdCompra = ($row->QtdCompra);

			$somaqtdvenda += $row->QtdVenda;
			$row->QtdVenda = ($row->QtdVenda);

			$somaqtddevcompra += $row->QtdDevCompra;
			$row->QtdDevCompra = ($row->QtdDevCompra);
			
			$somaqtddevvenda += $row->QtdDevVenda;
			$row->QtdDevVenda = ($row->QtdDevVenda);

			$somaqtdconsumo += $row->QtdConsumo;
			$row->QtdConsumo = ($row->QtdConsumo);

			$somaqtdestoque += $row->QtdEstoque;
			$row->QtdEstoque = ($row->QtdEstoque);


        }


		$estoque->soma->somaqtdcompra = ($somaqtdcompra);
		$estoque->soma->somaqtdvenda = ($somaqtdvenda);
		$estoque->soma->somaqtddevcompra = ($somaqtddevcompra);		
		$estoque->soma->somaqtddevvenda = ($somaqtddevvenda);
		$estoque->soma->somaqtdconsumo = ($somaqtdconsumo);
		$estoque->soma->somaqtdestoque = ($somaqtdestoque);

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $estoque;

    }
	
    public function list_estoqueBKP3($data) {

        $data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
        $data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
        $data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        ####################################################################
        #LISTA DE PRODUTOS
        $query['Produtos'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP.Produtos,""), " -- ", IFNULL(TV.Convdesc,"")) AS Produtos,
                TV.Convdesc,
				TP1.Prodaux1,
                TP2.Prodaux2,
                TP3.Prodaux3
            FROM
                Tab_Produto AS TP
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produto = TP.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Produtos'] . '
                ' . $data['Prodaux1'] . '
                ' . $data['Prodaux2'] . '
                ' . $data['Prodaux3'] . ' AND
				TV.idTab_Produto = TP.idTab_Produto
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Produtos'] = $query['Produtos']->result();

        ####################################################################
        #LISTA DE PRODAUX1
        $query['Prodaux1'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP1.Prodaux1,"")) AS Prodaux1,
                TP1.Prodaux1
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux1'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux1'] = $query['Prodaux1']->result();

        ####################################################################
        #LISTA DE PRODAUX2
        $query['Prodaux2'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP2.Prodaux2,"")) AS Prodaux2,
                TP2.Prodaux2
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux2'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux2'] = $query['Prodaux2']->result();

        ####################################################################
        #LISTA DE PRODAUX3
        $query['Prodaux3'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP3.Prodaux3,"")) AS Prodaux3,
                TP3.Prodaux3
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux3'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux3'] = $query['Prodaux3']->result();
		
        ####################################################################
        #COMPRADOS

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['Comprados'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto) AS QtdCompra,
                TP.idTab_Produto
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')  
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "1" 
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['Comprados'] = $query['Comprados']->result();

        ####################################################################
        #VENDIDOS

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['Vendidos'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto) AS QtdVenda,
                TP.idTab_Produto
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')  
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "2" 
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['Vendidos'] = $query['Vendidos']->result();

        ####################################################################
        #DEVOLVIDOS DA COMPRA

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['DevCompra'] = $this->db->query('
            SELECT
                SUM(APV.QtdServico) AS QtdDevCompra,
                TP.idTab_Produto
            FROM
				App_Servico AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Servico
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')  
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "3" 
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['DevCompra'] = $query['DevCompra']->result();

/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/		

        ####################################################################
        #DEVOLVIDOS DA VENDA

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['DevVenda'] = $this->db->query('
            SELECT
                SUM(APV.QtdServico) AS QtdDevVenda,
                TP.idTab_Produto
            FROM
				App_Servico AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Servico
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')  
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "4" 
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['DevVenda'] = $query['DevVenda']->result();

        ####################################################################
        #CONSUMIDOS
 
		if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Consumidos'] = $this->db->query(
            'SELECT
                (APV.QtdProduto) AS QtdConsumo,
                TP.idTab_Produto
            FROM
				App_Produto AS APV 
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata                   
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                OT.AprovadoOrca ="S" AND
				APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ') 			
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "5"
								
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Consumidos'] = $query['Consumidos']->result();		

		$estoque = new stdClass();
		#$estoque = array();
        foreach ($query['Produtos'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $estoque->{$row->idTab_Produto} = new stdClass();
            $estoque->{$row->idTab_Produto}->Produtos = $row->Produtos;
        }

        foreach ($query['Prodaux1'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux1 = $row->Prodaux1;
        }

        foreach ($query['Prodaux2'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux2 = $row->Prodaux2;
        }

        foreach ($query['Prodaux3'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux3 = $row->Prodaux3;
        }

/*		
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/
        foreach ($query['Comprados'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdCompra = $row->QtdCompra;
		}

        foreach ($query['Vendidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdVenda = $row->QtdVenda;
        }
		
        foreach ($query['DevVenda'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdDevVenda = $row->QtdDevVenda;
        }
				
        foreach ($query['DevCompra'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdDevCompra = $row->QtdDevCompra;
        }		

        foreach ($query['Consumidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdConsumo = $row->QtdConsumo;
        }

		$estoque->soma = new stdClass();
		$somaqtdcompra = $somaqtdvenda = $somaqtddevvenda = $somaqtddevcompra = $somaqtdconsumo = $somaqtdestoque = 0;

		foreach ($estoque as $row) {

			$row->QtdCompra = (!isset($row->QtdCompra)) ? 0 : $row->QtdCompra;
            $row->QtdVenda = (!isset($row->QtdVenda)) ? 0 : $row->QtdVenda;
            $row->QtdDevVenda = (!isset($row->QtdDevVenda)) ? 0 : $row->QtdDevVenda;			
            $row->QtdDevCompra = (!isset($row->QtdDevCompra)) ? 0 : $row->QtdDevCompra;			
            $row->QtdConsumo = (!isset($row->QtdConsumo)) ? 0 : $row->QtdConsumo;
            
			$row->QtdEstoque = $row->QtdCompra - $row->QtdVenda + $row->QtdDevVenda - $row->QtdDevCompra;

			$somaqtdcompra += $row->QtdCompra;
			$row->QtdCompra = ($row->QtdCompra);

			$somaqtdvenda += $row->QtdVenda;
			$row->QtdVenda = ($row->QtdVenda);

			$somaqtddevcompra += $row->QtdDevCompra;
			$row->QtdDevCompra = ($row->QtdDevCompra);
			
			$somaqtddevvenda += $row->QtdDevVenda;
			$row->QtdDevVenda = ($row->QtdDevVenda);

			$somaqtdconsumo += $row->QtdConsumo;
			$row->QtdConsumo = ($row->QtdConsumo);

			$somaqtdestoque += $row->QtdEstoque;
			$row->QtdEstoque = ($row->QtdEstoque);


        }


		$estoque->soma->somaqtdcompra = ($somaqtdcompra);
		$estoque->soma->somaqtdvenda = ($somaqtdvenda);
		$estoque->soma->somaqtddevcompra = ($somaqtddevcompra);		
		$estoque->soma->somaqtddevvenda = ($somaqtddevvenda);
		$estoque->soma->somaqtdconsumo = ($somaqtdconsumo);
		$estoque->soma->somaqtdestoque = ($somaqtdestoque);

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $estoque;

    }

    public function list_estoqueBKP1($data) {

        $data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
        $data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
        $data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        ####################################################################
        #LISTA DE PRODUTOS
        $query['Produtos'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP.Produtos,"")) AS Produtos,
                TP1.Prodaux1,
                TP2.Prodaux2,
                TP3.Prodaux3
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Produtos'] . '
                ' . $data['Prodaux1'] . '
                ' . $data['Prodaux2'] . '
                ' . $data['Prodaux3'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Produtos'] = $query['Produtos']->result();

        ####################################################################
        #LISTA DE PRODAUX1
        $query['Prodaux1'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP1.Prodaux1,"")) AS Prodaux1,
                TP1.Prodaux1
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux1'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux1'] = $query['Prodaux1']->result();

        ####################################################################
        #LISTA DE PRODAUX2
        $query['Prodaux2'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP2.Prodaux2,"")) AS Prodaux2,
                TP2.Prodaux2
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux2'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux2'] = $query['Prodaux2']->result();

        ####################################################################
        #LISTA DE PRODAUX3
        $query['Prodaux3'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP3.Prodaux3,"")) AS Prodaux3,
                TP3.Prodaux3
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux3'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux3'] = $query['Prodaux3']->result();
		
        ####################################################################
        #COMPRADOS

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['Comprados'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto) AS QtdCompra,
                TP.idTab_Produto
            FROM
				App_Produto AS APV
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')  
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "1"
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['Comprados'] = $query['Comprados']->result();

/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/		
        ####################################################################
        #VENDIDOS

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['Vendidos'] = $this->db->query(
            'SELECT
                (APV.QtdProduto) AS Qtd,
                TP.idTab_Produto
            FROM
                App_Produto AS APV 
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata				
                    LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ') 
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "2"
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Vendidos'] = $query['Vendidos']->result();

        ####################################################################
        #DEVOLVIDOS NA VENDA

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['Devolvidos'] = $this->db->query(
            'SELECT
                (APV.QtdServico) AS QtdDevolve,
                TP.idTab_Produto
            FROM
				App_Servico AS APV 
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata                    
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Servico
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ') 
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "4"
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Devolvidos'] = $query['Devolvidos']->result();

        ####################################################################
        #DEVOLVIDOS NA COMPRA

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['Devolvidos2'] = $this->db->query(
            'SELECT
                (APV.QtdServico) AS QtdDevolve2,
                TP.idTab_Produto
            FROM
				App_Servico AS APV 
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata                    
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Servico
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')  
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "3"
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Devolvidos2'] = $query['Devolvidos2']->result();		

        ####################################################################
        #CONSUMIDOS
 
		if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Consumidos'] = $this->db->query(
            'SELECT
                (APV.QtdProduto) AS QtdConsumo,
                TP.idTab_Produto
            FROM
				App_Produto AS APV 
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = APV.idApp_OrcaTrata                   
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ') 			
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "5"
								
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Consumidos'] = $query['Consumidos']->result();		

		$estoque = new stdClass();
		#$estoque = array();
        foreach ($query['Produtos'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $estoque->{$row->idTab_Produto} = new stdClass();
            $estoque->{$row->idTab_Produto}->Produtos = $row->Produtos;
        }

        foreach ($query['Prodaux1'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux1 = $row->Prodaux1;
        }

        foreach ($query['Prodaux2'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux2 = $row->Prodaux2;
        }

        foreach ($query['Prodaux3'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux3 = $row->Prodaux3;
        }

/*		
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/
        foreach ($query['Comprados'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdCompra = $row->QtdCompra;
		}

        foreach ($query['Vendidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Qtd = $row->Qtd;
        }

        foreach ($query['Devolvidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdDevolve = $row->QtdDevolve;
        }
		
        foreach ($query['Devolvidos2'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdDevolve2 = $row->QtdDevolve2;
        }		

        foreach ($query['Consumidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdConsumo = $row->QtdConsumo;
        }

		$estoque->soma = new stdClass();
		$somaqtdcompra = $somaqtdvenda = $somaqtddevolve = $somaqtddevolve2 = $somaqtdconsumo = $somaqtdestoque = 0;

		foreach ($estoque as $row) {

			$row->QtdCompra = (!isset($row->QtdCompra)) ? 0 : $row->QtdCompra;
            $row->Qtd = (!isset($row->Qtd)) ? 0 : $row->Qtd;
            $row->QtdDevolve = (!isset($row->QtdDevolve)) ? 0 : $row->QtdDevolve;
            $row->QtdDevolve2 = (!isset($row->QtdDevolve2)) ? 0 : $row->QtdDevolve2;			
            $row->QtdConsumo = (!isset($row->QtdConsumo)) ? 0 : $row->QtdConsumo;

            $row->QtdEstoque = $row->QtdCompra;


			$somaqtdcompra += $row->QtdCompra;
			$row->QtdCompra = ($row->QtdCompra);

			$somaqtdvenda += $row->Qtd;
			$row->Qtd = ($row->Qtd);

			$somaqtddevolve += $row->QtdDevolve;
			$row->QtdDevolve = ($row->QtdDevolve);
			
			$somaqtddevolve2 += $row->QtdDevolve2;
			$row->QtdDevolve2 = ($row->QtdDevolve2);			

			$somaqtdconsumo += $row->QtdConsumo;
			$row->QtdConsumo = ($row->QtdConsumo);



			$somaqtdestoque += $row->QtdEstoque;
			$row->QtdEstoque = ($row->QtdEstoque);


        }


		$estoque->soma->somaqtdcompra = ($somaqtdcompra);
		$estoque->soma->somaqtdvenda = ($somaqtdvenda);
		$estoque->soma->somaqtddevolve = ($somaqtddevolve);
		$estoque->soma->somaqtddevolve2 = ($somaqtddevolve2);		
		$estoque->soma->somaqtdconsumo = ($somaqtdconsumo);

		$estoque->soma->somaqtdestoque = ($somaqtdestoque);

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $estoque;

    }

    public function list_estoqueBKP2($data) {

        $data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
        $data['Prodaux1'] = ($data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
        $data['Prodaux2'] = ($data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        ####################################################################
        #LISTA DE PRODUTOS
        $query['Produtos'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP.CodProd,""), " - ", IFNULL(TP.Produtos,"")) AS Produtos,
                TP1.Prodaux1,
                TP2.Prodaux2,
                TP3.Prodaux3
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Produtos'] . '
                ' . $data['Prodaux1'] . '
                ' . $data['Prodaux2'] . '
                ' . $data['Prodaux3'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Produtos'] = $query['Produtos']->result();

        ####################################################################
        #LISTA DE PRODAUX1
        $query['Prodaux1'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP1.Prodaux1,"")) AS Prodaux1,
                TP1.Prodaux1
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux1'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux1'] = $query['Prodaux1']->result();

        ####################################################################
        #LISTA DE PRODAUX2
        $query['Prodaux2'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP2.Prodaux2,"")) AS Prodaux2,
                TP2.Prodaux2
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux2'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux2'] = $query['Prodaux2']->result();

        ####################################################################
        #LISTA DE PRODAUX3
        $query['Prodaux3'] = $this->db->query(
            'SELECT
                TP.idTab_Produto,
                TP.CodProd,
                CONCAT(IFNULL(TP3.Prodaux3,"")) AS Prodaux3,
                TP3.Prodaux3
            FROM
                Tab_Produto AS TP
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Prodaux3'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['Prodaux3'] = $query['Prodaux3']->result();

/*
        ####################################################################
        #COMPRADOS
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['Comprados'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto) AS QtdCompra,
                TP.idTab_Produto,
				APV.idTab_Produto,
				TVV.idTab_Valor,
				APV.idTab_TipoRD
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_Produto AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
                    LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
					LEFT JOIN App_Fornecedor AS FO ON FO.idApp_Fornecedor = OT.idApp_Fornecedor
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
				APV.idApp_Produto != "0" AND
				TVV.idTab_Valor = APV.idTab_Produto AND
				TP.idTab_Produto = TVV.idTab_Produto AND
				FO.idApp_Fornecedor = OT.idApp_Fornecedor
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "1"
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC
        ');
        $query['Comprados'] = $query['Comprados']->result();
*/
		
        ####################################################################
        #COMPRADOS
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }
		
        $query['Comprados'] = $this->db->query('
            SELECT
                SUM(APV.QtdProduto) AS QtdCompra,
                TP.idTab_Produto				
            FROM
				App_Produto AS APV
					LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3					
            WHERE
                APV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
                ' . $data['Produtos'] . ' AND                
				APV.idTab_TipoRD = "1"
            
			GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC				

        ');
        $query['Comprados'] = $query['Comprados']->result();

/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/		
        ####################################################################
        #VENDIDOS
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Vendidos'] = $this->db->query(
            'SELECT
                (APV.QtdProduto) AS Qtd,
                TP.idTab_Produto,
				APV.idTab_TipoRD
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_Produto AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
                    LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
                    LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                APV.idApp_Produto != "0" AND
				TP.idTab_Produto = TVV.idTab_Produto
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "2"
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Vendidos'] = $query['Vendidos']->result();

        ####################################################################
        #DEVOLVIDOS NA VENDA
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Devolvidos'] = $this->db->query(
            'SELECT
                (APV.QtdServico) AS QtdDevolve,
                TP.idTab_Produto,
                APV.idTab_TipoRD
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_Servico AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
                    LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Servico
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                APV.idApp_Servico != "0" AND
				TP.idTab_Produto = TVV.idTab_Produto
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "4"
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Devolvidos'] = $query['Devolvidos']->result();

        ####################################################################
        #DEVOLVIDOS NA COMPRA
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Devolvidos2'] = $this->db->query(
            'SELECT
                (APV.QtdServico) AS QtdDevolve2,
                TP.idTab_Produto,
                APV.idTab_TipoRD
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_Servico AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
                    LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Servico
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                APV.idApp_Servico != "0" AND
				TP.idTab_Produto = TVV.idTab_Produto
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "3"
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Devolvidos2'] = $query['Devolvidos2']->result();		

        ####################################################################
        #CONSUMIDOS
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $query['Consumidos'] = $this->db->query(
            'SELECT
                (APV.QtdProduto) AS QtdConsumo,
                TP.idTab_Produto,
                APV.idTab_TipoRD
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
                    LEFT JOIN App_Produto AS APV ON APV.idApp_OrcaTrata = OT.idApp_OrcaTrata
                    LEFT JOIN Tab_Valor AS TVV ON TVV.idTab_Valor = APV.idTab_Produto
                    LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TVV.idTab_Produto
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TP.Prodaux1
                    LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TP.Prodaux2
                    LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                APV.idApp_Produto != "0" AND
				TP.idTab_Produto = TVV.idTab_Produto
                ' . $data['Produtos'] . ' AND
                APV.idTab_TipoRD = "5"
            GROUP BY
                TP.idTab_Produto
            ORDER BY
                TP.Produtos ASC'
        );
        $query['Consumidos'] = $query['Consumidos']->result();		


		$estoque = new stdClass();


		#$estoque = array();
        foreach ($query['Produtos'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $estoque->{$row->idTab_Produto} = new stdClass();
            $estoque->{$row->idTab_Produto}->Produtos = $row->Produtos;
        }

        foreach ($query['Prodaux1'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux1 = $row->Prodaux1;
        }

        foreach ($query['Prodaux2'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux2 = $row->Prodaux2;
        }

        foreach ($query['Prodaux3'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            #$estoque->{$row->idTab_Produto} = new stdClass();
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Prodaux3 = $row->Prodaux3;
        }

/*		
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();
*/
        foreach ($query['Comprados'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdCompra = $row->QtdCompra;
		}

        foreach ($query['Vendidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->Qtd = $row->Qtd;
        }

        foreach ($query['Devolvidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdDevolve = $row->QtdDevolve;
        }
		
        foreach ($query['Devolvidos2'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdDevolve2 = $row->QtdDevolve2;
        }		

        foreach ($query['Consumidos'] as $row) {
            if (isset($estoque->{$row->idTab_Produto}))
                $estoque->{$row->idTab_Produto}->QtdConsumo = $row->QtdConsumo;
        }

		$estoque->soma = new stdClass();
		$somaqtdcompra = $somaqtdvenda = $somaqtddevolve = $somaqtddevolve2 = $somaqtdconsumo = $somaqtdvendida = $somaqtdestoque = 0;

		foreach ($estoque as $row) {

			$row->QtdCompra = (!isset($row->QtdCompra)) ? 0 : $row->QtdCompra;
            $row->Qtd = (!isset($row->Qtd)) ? 0 : $row->Qtd;
            $row->QtdDevolve = (!isset($row->QtdDevolve)) ? 0 : $row->QtdDevolve;
            $row->QtdDevolve2 = (!isset($row->QtdDevolve2)) ? 0 : $row->QtdDevolve2;			
            $row->QtdConsumo = (!isset($row->QtdConsumo)) ? 0 : $row->QtdConsumo;

            $row->QtdEstoque = $row->QtdCompra - $row->Qtd + $row->QtdDevolve - $row->QtdConsumo - $row->QtdDevolve2;
            $row->QtdVendida = $row->Qtd - $row->QtdDevolve;

			$somaqtdcompra += $row->QtdCompra;
			$row->QtdCompra = ($row->QtdCompra);

			$somaqtdvenda += $row->Qtd;
			$row->Qtd = ($row->Qtd);

			$somaqtddevolve += $row->QtdDevolve;
			$row->QtdDevolve = ($row->QtdDevolve);
			
			$somaqtddevolve2 += $row->QtdDevolve2;
			$row->QtdDevolve2 = ($row->QtdDevolve2);			

			$somaqtdconsumo += $row->QtdConsumo;
			$row->QtdConsumo = ($row->QtdConsumo);

			$somaqtdvendida += $row->QtdVendida;
			$row->QtdVendida = ($row->QtdVendida);

			$somaqtdestoque += $row->QtdEstoque;
			$row->QtdEstoque = ($row->QtdEstoque);


        }


		$estoque->soma->somaqtdcompra = ($somaqtdcompra);
		$estoque->soma->somaqtdvenda = ($somaqtdvenda);
		$estoque->soma->somaqtddevolve = ($somaqtddevolve);
		$estoque->soma->somaqtddevolve2 = ($somaqtddevolve2);		
		$estoque->soma->somaqtdconsumo = ($somaqtdconsumo);
		$estoque->soma->somaqtdvendida = ($somaqtdvendida);
		$estoque->soma->somaqtdestoque = ($somaqtdestoque);

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $estoque;

    }
	
	public function list_rankingvendas($data) {

        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
		
        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND TC.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TC.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        ####################################################################
        #LISTA DE CLIENTES
        $query['NomeCliente'] = $this->db->query(
            'SELECT
                TC.idApp_Cliente,
                CONCAT(IFNULL(TC.NomeCliente,"")) AS NomeCliente
				
            FROM
                App_Cliente AS TC
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.idApp_Cliente = TC.idApp_Cliente
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPR.Quitado = "S" AND
				' . $consulta . '
                ' . $data['NomeCliente'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['NomeCliente'] = $query['NomeCliente']->result();

        ####################################################################
        #Parcelas

        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idApp_Cliente,
				FP.idTab_FormaPag
            FROM
                App_OrcaTrata AS TOT
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = TOT.FormaPagamento
                    LEFT JOIN App_Cliente AS TC ON TC.idApp_Cliente = TOT.idApp_Cliente
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata

            WHERE
                TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ')
                ' . $data['NomeCliente'] . ' AND
                TOT.AprovadoOrca = "S" AND
				TPR.Quitado = "S" AND
				TPR.idTab_TipoRD = "2" AND
                TC.idApp_Cliente != "0"
            GROUP BY
                TC.idApp_Cliente
            ORDER BY
                TC.NomeCliente ASC'
        );
        $query['Parcelas'] = $query['Parcelas']->result();
	
		$rankingvendas = new stdClass();


		#$estoque = array();
        foreach ($query['NomeCliente'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $rankingvendas->{$row->idApp_Cliente} = new stdClass();
            $rankingvendas->{$row->idApp_Cliente}->NomeCliente = $row->NomeCliente;
        }


				/*
		echo "<pre>";
		print_r($query['Comprados']);
		echo "</pre>";
		exit();*/
	
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idApp_Cliente}))
                $rankingvendas->{$row->idApp_Cliente}->QtdParc = $row->QtdParc;
        }

		$rankingvendas->soma = new stdClass();
		$somaqtdorcam = $somaqtddescon = $somaqtdvendida = $somaqtdparc = $somaqtddevol = 0;

		foreach ($rankingvendas as $row) {
	
			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;
		
			$somaqtdparc += $row->QtdParc;
			#$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');																
        }

		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');
		

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }

	public function list_rankingcompras($data) {

        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
        $data['NomeFornecedor'] = ($data['NomeFornecedor']) ? ' AND TC.idApp_Fornecedor = ' . $data['NomeFornecedor'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TC.NomeFornecedor' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        ####################################################################
        #LISTA DE CLIENTES
        $query['NomeFornecedor'] = $this->db->query(
            'SELECT
                TC.idApp_Fornecedor,
                CONCAT(IFNULL(TC.NomeFornecedor,"")) AS NomeFornecedor
				
            FROM
                App_Fornecedor AS TC
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.idApp_Fornecedor = TC.idApp_Fornecedor
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TPR.Quitado = "S" AND
				' . $consulta . '
                ' . $data['NomeFornecedor'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['NomeFornecedor'] = $query['NomeFornecedor']->result();

        ####################################################################
        #Parcelas 
        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }

        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idApp_Fornecedor
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN App_Fornecedor AS TC ON TC.idApp_Fornecedor = TOT.idApp_Fornecedor
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata

            WHERE
                TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['NomeFornecedor'] . ' AND
                TOT.AprovadoOrca = "S" AND

				TPR.Quitado = "S" AND
				TPR.idTab_TipoRD = "1" AND
                TC.idApp_Fornecedor != "0"
            GROUP BY
                TC.idApp_Fornecedor
            ORDER BY
                TC.NomeFornecedor ASC'
        );
        $query['Parcelas'] = $query['Parcelas']->result();
		
		$rankingvendas = new stdClass();


		#$estoque = array();
        foreach ($query['NomeFornecedor'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $rankingvendas->{$row->idApp_Fornecedor} = new stdClass();
            $rankingvendas->{$row->idApp_Fornecedor}->NomeFornecedor = $row->NomeFornecedor;
        }


		/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();*/


		
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idApp_Fornecedor}))
                $rankingvendas->{$row->idApp_Fornecedor}->QtdParc = $row->QtdParc;
        }

		$rankingvendas->soma = new stdClass();
		$somaqtdorcam = $somaqtddescon = $somaqtdvendida = $somaqtdparc = $somaqtddevol = 0;

		foreach ($rankingvendas as $row) {
	
			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;

			
			$somaqtdparc += $row->QtdParc;
			#$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');																
        }

		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');	

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }

	public function list_rankingreceitas($data) {

        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
        $data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TC.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TC.TipoFinanceiro' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro4 = ($data['Quitado']) ? 'TPR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'TOT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        ####################################################################
        #LISTA DE CLIENTES
        $query['TipoFinanceiro'] = $this->db->query(
            'SELECT
                TC.idTab_TipoFinanceiro,
                CONCAT(IFNULL(TC.TipoFinanceiro,"")) AS TipoFinanceiro
            FROM
                Tab_TipoFinanceiro AS TC
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.TipoFinanceiro = TC.idTab_TipoFinanceiro
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                ' . $permissao . '
				' . $filtro4 . '
				TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['TipoFinanceiro'] . ' AND
                TOT.idTab_TipoRD = "2" AND
				TOT.AprovadoOrca = "S" AND
				TPR.idTab_TipoRD = "2"
				
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['TipoFinanceiro'] = $query['TipoFinanceiro']->result();

        ####################################################################
        #Parcelas 

        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idTab_TipoFinanceiro
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN Tab_TipoFinanceiro AS TC ON TC.idTab_TipoFinanceiro = TOT.TipoFinanceiro
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata

            WHERE
                ' . $permissao . '
				' . $filtro4 . '
				TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['TipoFinanceiro'] . ' AND
                TOT.idTab_TipoRD = "2" AND
				TOT.AprovadoOrca = "S" AND
				TPR.idTab_TipoRD = "2" 
            GROUP BY
                TC.idTab_TipoFinanceiro
            ORDER BY
                TC.TipoFinanceiro ASC'
        );
        $query['Parcelas'] = $query['Parcelas']->result();
		
		$rankingvendas = new stdClass();


		#$estoque = array();
        foreach ($query['TipoFinanceiro'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $rankingvendas->{$row->idTab_TipoFinanceiro} = new stdClass();
            $rankingvendas->{$row->idTab_TipoFinanceiro}->TipoFinanceiro = $row->TipoFinanceiro;
        }


		/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();*/

		
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idTab_TipoFinanceiro}))
                $rankingvendas->{$row->idTab_TipoFinanceiro}->QtdParc = $row->QtdParc;
        }

		$rankingvendas->soma = new stdClass();
		$somaqtdorcam = $somaqtddescon = $somaqtdvendida = $somaqtdparc = $somaqtddevol = 0;

		foreach ($rankingvendas as $row) {

			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;
			
			$somaqtdparc += $row->QtdParc;
			#$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');																
        }

		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }

	public function list_rankingdespesas($data) {

        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
        $data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TC.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TC.TipoFinanceiro' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro4 = ($data['Quitado']) ? 'TPR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'TOT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        ####################################################################
        #LISTA DE CLIENTES
        $query['TipoFinanceiro'] = $this->db->query(
            'SELECT
                TC.idTab_TipoFinanceiro,
                CONCAT(IFNULL(TC.TipoFinanceiro,"")) AS TipoFinanceiro
            FROM
                Tab_TipoFinanceiro AS TC
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.TipoFinanceiro = TC.idTab_TipoFinanceiro
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                ' . $permissao . '
				' . $filtro4 . '
				TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['TipoFinanceiro'] . ' AND
                TOT.idTab_TipoRD = "1" AND
				TOT.AprovadoOrca = "S" AND

				TPR.idTab_TipoRD = "1"
				
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . ''
        );
        $query['TipoFinanceiro'] = $query['TipoFinanceiro']->result();

        ####################################################################
        #Parcelas 

        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idTab_TipoFinanceiro
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN Tab_TipoFinanceiro AS TC ON TC.idTab_TipoFinanceiro = TOT.TipoFinanceiro
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata

            WHERE
                ' . $permissao . '
				' . $filtro4 . '
				TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ')
                ' . $data['TipoFinanceiro'] . ' AND
                TOT.idTab_TipoRD = "1" AND
				TOT.AprovadoOrca = "S" AND

				TPR.idTab_TipoRD = "1" 
            GROUP BY
                TC.idTab_TipoFinanceiro
            ORDER BY
                TC.TipoFinanceiro ASC'
        );
        $query['Parcelas'] = $query['Parcelas']->result();
		
		$rankingvendas = new stdClass();


		#$estoque = array();
        foreach ($query['TipoFinanceiro'] as $row) {
            #echo $row->idTab_Produto . ' # ' . $row->Produtos . '<br />';
            #$estoque[$row->idTab_Produto] = $row->Produtos;
            $rankingvendas->{$row->idTab_TipoFinanceiro} = new stdClass();
            $rankingvendas->{$row->idTab_TipoFinanceiro}->TipoFinanceiro = $row->TipoFinanceiro;
        }


		/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();*/

		
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idTab_TipoFinanceiro}))
                $rankingvendas->{$row->idTab_TipoFinanceiro}->QtdParc = $row->QtdParc;
        }

		$rankingvendas->soma = new stdClass();
		$somaqtdorcam = $somaqtddescon = $somaqtdvendida = $somaqtdparc = $somaqtddevol = 0;

		foreach ($rankingvendas as $row) {

			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;
			
			$somaqtdparc += $row->QtdParc;
			#$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');																
        }

		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }
	
	public function list_servicosprest($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND P.idApp_Profissional = ' . $data['NomeProfissional'] : FALSE;

		$query = $this->db->query('
            SELECT
                C.NomeCliente,
				TSU.Nome,
				P.NomeProfissional,
				OT.idApp_OrcaTrata,
                OT.DataOrca,
				PV.QtdServico,
				PV.idApp_Servico,
				PD.idTab_Servico,
				PD.NomeServico
            FROM
                App_Cliente AS C,
				App_OrcaTrata AS OT
					LEFT JOIN App_Servico AS PV ON PV.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_Servico AS PD ON PD.idTab_Servico = PV.idTab_Servico
					LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = PV.idSis_Usuario
					LEFT JOIN App_Profissional AS P ON P.idApp_Profissional = OT.ProfissionalOrca
            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(' . $consulta . ') AND
				PV.idApp_Servico != "0" AND
				C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '

            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
		LEFT JOIN Tab_ProdutoBase AS TPD ON TPD.idTab_ProdutoBase = PD.idTab_Produto
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
            }
            return $query;
        }
    }

	public function list_consumo($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '" AND TCO.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TCO.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TTC.idTab_TipoConsumo = ' . $data['TipoFinanceiro'] : FALSE;
		$data['Produtos'] = ($data['Produtos']) ? ' AND TPB.idTab_Produto = ' . $data['Produtos'] : FALSE;

        $query = $this->db->query('
            SELECT
                TCO.idApp_Despesas,
				TCO.Despesa,
				TTC.TipoConsumo,
				TCO.TipoProduto,
                TCO.DataDespesas,
				APC.QtdProduto,
				APC.idTab_Produto,
				TPB.Produtos,
				APC.ObsProduto,
				TP3.Prodaux3,
				TP2.Prodaux2,
				TP1.Prodaux1
            FROM
                App_Despesas AS TCO
                    LEFT JOIN Tab_TipoConsumo AS TTC ON TTC.idTab_TipoConsumo = TCO.TipoFinanceiro
					LEFT JOIN App_Produto AS APC ON APC.idApp_Despesas = TCO.idApp_Despesas
					LEFT JOIN Tab_Produto AS TPB ON TPB.idTab_Produto = APC.idTab_Produto
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TPB.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TPB.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TPB.Prodaux1
            WHERE
                TCO.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TCO.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(' . $consulta . ')
				' . $data['TipoFinanceiro'] . '
				' . $data['Produtos'] . ' AND
				TCO.TipoProduto = "C"
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          #exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');

            }
            return $query;
        }
    }

    public function list_orcamento($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataRetorno >= "' . $data['DataInicio3'] . '" AND OT.DataRetorno <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataRetorno >= "' . $data['DataInicio3'] . '")';
        }

		if ($data['DataFim4']) {
            $consulta4 =
                '(OT.DataQuitado >= "' . $data['DataInicio4'] . '" AND OT.DataQuitado <= "' . $data['DataFim4'] . '")';
        }
        else {
            $consulta4 =
                '(OT.DataQuitado >= "' . $data['DataInicio4'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Entregador'] = ($data['Entregador']) ? ' AND OT.Entregador = ' . $data['Entregador'] : FALSE;
		$data['FormaPag'] = ($data['FormaPag']) ? ' AND TFP.idTab_FormaPag = ' . $data['FormaPag'] : FALSE;
		$data['TipoFrete'] = ($data['TipoFrete']) ? ' AND TTF.idTab_TipoFrete = ' . $data['TipoFrete'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,
				C.CelularCliente,
				CONCAT(IFNULL(C.NomeCliente,""), " --- ", IFNULL(C.CelularCliente,"")) AS NomeCliente,
				OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorFrete,
				OT.ValorTotalOrca,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
				OT.DataEntregaOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				TTF.TipoFrete,
				OT.ObsOrca,
				OT.Descricao,
				OT.Entregador,
				TFP.FormaPag,
				TSU.Nome
				
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
				LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = OT.Entregador
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
            WHERE
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
				' . $filtro3 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '
				' . $data['Entregador'] . '
				' . $data['TipoFrete'] . '
				' . $data['FormaPag'] . ' AND
				OT.idTab_TipoRD = "2"
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
			$somafrete=0;
			$somatotal=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
				$row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
				$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

                $somaorcamento += $row->ValorOrca;
                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');
				
				$somafrete += $row->ValorFrete;
                $row->ValorFrete = number_format($row->ValorFrete, 2, ',', '.');

				$somadesconto += $row->ValorEntradaOrca;
                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');

				$somarestante += $row->ValorRestanteOrca;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');

				$somatotal += $row->ValorTotalOrca;
                $row->ValorTotalOrca = number_format($row->ValorTotalOrca, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somafrete = number_format($somafrete, 2, ',', '.');
			$query->soma->somatotal = number_format($somatotal, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');

            return $query;
        }

    }

	public function list_devolucao1($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataConclusao >= "' . $data['DataInicio2'] . '" AND OT.DataConclusao <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataConclusao >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataRetorno >= "' . $data['DataInicio3'] . '" AND OT.DataRetorno <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataRetorno >= "' . $data['DataInicio3'] . '")';
        }

		if ($data['DataFim4']) {
            $consulta4 =
                '(OT.DataQuitado >= "' . $data['DataInicio4'] . '" AND OT.DataQuitado <= "' . $data['DataFim4'] . '")';
        }
        else {
            $consulta4 =
                '(OT.DataQuitado >= "' . $data['DataInicio4'] . '")';
        }

		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;

        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        $query = $this->db->query('
            SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.Orcamento,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataQuitado,
				OT.DataConclusao,
                OT.DataRetorno,
				OT.FormaPagamento,
				OT.idTab_TipoRD,
				TD.TipoDevolucao,
				TFP.FormaPag,
				TSU.Nome
            FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
				LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoDevolucao AS TD ON TD.idTab_TipoDevolucao = OT.TipoDevolucao
            WHERE
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
				(' . $consulta2 . ') AND
				(' . $consulta3 . ') AND
				(' . $consulta4 . ') AND
                ' . $filtro1 . '
                ' . $filtro2 . '
				' . $filtro3 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . ' AND
				OT.idTab_TipoRD = "1"
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '

        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
				$row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
				$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                $row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

                $somaorcamento += $row->ValorOrca;
                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

				$somadesconto += $row->ValorEntradaOrca;
                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');

				$somarestante += $row->ValorRestanteOrca;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');



            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');

            return $query;
        }

    }

	public function list_devolucao($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataDespesas >= "' . $data['DataInicio'] . '" AND OT.DataDespesas <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataDespesas >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataConclusaoDespesas >= "' . $data['DataInicio2'] . '" AND OT.DataConclusaoDespesas <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataConclusaoDespesas >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(OT.DataRetornoDespesas >= "' . $data['DataInicio3'] . '" AND OT.DataRetornoDespesas <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataRetornoDespesas >= "' . $data['DataInicio3'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;

        $filtro1 = ($data['AprovadoDespesas'] != '#') ? 'OT.AprovadoDespesas = "' . $data['AprovadoDespesas'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoDespesas'] != '#') ? 'OT.QuitadoDespesas = "' . $data['QuitadoDespesas'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrcaDespesas'] != '#') ? 'OT.ConcluidoOrcaDespesas = "' . $data['ConcluidoOrcaDespesas'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT

                OT.idApp_Despesas,
				OT.idApp_OrcaTrata,
                OT.AprovadoDespesas,
                OT.DataDespesas,
				OT.DataEntradaDespesas,
                OT.ValorDespesas,
				OT.ValorEntradaDespesas,
				OT.ValorRestanteDespesas,
                OT.ConcluidoOrcaDespesas,
                OT.QuitadoDespesas,
                OT.DataConclusaoDespesas,
                OT.DataRetornoDespesas,
				OT.FormaPagamentoDespesas,
				C.NomeCliente,
				OT.TipoProduto,
				TFP.FormaPag,
				TSU.Nome
            FROM

                App_Despesas AS OT
				LEFT JOIN Sis_Usuario AS TSU ON TSU.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamentoDespesas
				LEFT JOIN App_OrcaTrata AS TR ON TR.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = TR.idApp_Cliente

            WHERE
				OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['NomeCliente'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . ' AND

				OT.TipoProduto = "E"

            ORDER BY
                OT.idApp_Despesas DESC,
				OT.AprovadoDespesas ASC,
				OT.DataDespesas

        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaorcamento=0;
			$somadesconto=0;
			$somarestante=0;
            foreach ($query->result() as $row) {
				$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');
				$row->DataEntradaDespesas = $this->basico->mascara_data($row->DataEntradaDespesas, 'barras');
                $row->DataConclusaoDespesas = $this->basico->mascara_data($row->DataConclusaoDespesas, 'barras');
                $row->DataRetornoDespesas = $this->basico->mascara_data($row->DataRetornoDespesas, 'barras');

                $row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
                $row->ConcluidoOrcaDespesas = $this->basico->mascara_palavra_completa($row->ConcluidoOrcaDespesas, 'NS');
                $row->QuitadoDespesas = $this->basico->mascara_palavra_completa($row->QuitadoDespesas, 'NS');

                $somaorcamento += $row->ValorDespesas;
                $row->ValorDespesas = number_format($row->ValorDespesas, 2, ',', '.');

				$somadesconto += $row->ValorEntradaDespesas;
                $row->ValorEntradaDespesas = number_format($row->ValorEntradaDespesas, 2, ',', '.');

				$somarestante += $row->ValorRestanteDespesas;
                $row->ValorRestanteDespesas = number_format($row->ValorRestanteDespesas, 2, ',', '.');



            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somadesconto = number_format($somadesconto, 2, ',', '.');
			$query->soma->somarestante = number_format($somarestante, 2, ',', '.');

            return $query;
        }

    }

    public function list_clientes1($data, $completo) {

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro10 = ($data['Ativo'] != '#') ? 'C.Ativo = "' . $data['Ativo'] . '" AND ' : FALSE;
        $query = $this->db->query('
            SELECT
				C.idApp_Cliente,
                C.NomeCliente,
				C.Ativo,
                C.DataNascimento,
                C.CelularCliente,
                C.Telefone2,
                C.Telefone3,
                C.Sexo,
                C.Endereco,
                C.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                C.Email,
				CC.NomeContatoCliente,
				TCC.RelaCom,
				TCP.RelaPes,
				CC.Sexo

            FROM
                App_Cliente AS C
                    LEFT JOIN Tab_Municipio AS M ON C.Municipio = M.idTab_Municipio
					LEFT JOIN App_ContatoCliente AS CC ON C.idApp_Cliente = CC.idApp_Cliente
					LEFT JOIN Tab_RelaCom AS TCC ON TCC.idTab_RelaCom = CC.RelaCom
					LEFT JOIN Tab_RelaPes AS TCP ON TCP.idTab_RelaPes = CC.RelaPes
            WHERE
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeCliente'] . '
				OR
				C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeCliente'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
				$row->Ativo = $this->basico->mascara_palavra_completa($row->Ativo, 'NS');
                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->CelularCliente = ($row->CelularCliente) ? $row->CelularCliente : FALSE;
				$row->Telefone2 = ($row->Telefone2) ? $row->Telefone2 : FALSE;
				$row->Telefone3 = ($row->Telefone3) ? $row->Telefone3 : FALSE;

                #$row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                #$row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_clientes($data, $completo) {

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro10 = ($data['Ativo'] != '#') ? 'C.Ativo = "' . $data['Ativo'] . '" AND ' : FALSE;
        #$q = ($_SESSION['log']['Permissao'] > 2) ? ' C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				C.idApp_Cliente,
                C.NomeCliente,
				C.Arquivo,
				C.Ativo,
                C.DataNascimento,
				C.DataCadastroCliente,
                C.CelularCliente,
                C.Telefone2,
                C.Telefone3,
                C.Sexo,
                C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
                C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS MunicipioCliente,
                C.Email,
				C.usuario,
				C.senha,
				C.CodInterno
            FROM
				App_Cliente AS C
                    LEFT JOIN Tab_Municipio AS M ON C.MunicipioCliente = M.idTab_Municipio

            WHERE


				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $data['NomeCliente'] . '

            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
				$row->DataCadastroCliente = $this->basico->mascara_data($row->DataCadastroCliente, 'barras');
				$row->Ativo = $this->basico->mascara_palavra_completa($row->Ativo, 'NS');
                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->CelularCliente = ($row->CelularCliente) ? $row->CelularCliente : FALSE;
				$row->Telefone2 = ($row->Telefone2) ? $row->Telefone2 : FALSE;
				$row->Telefone3 = ($row->Telefone3) ? $row->Telefone3 : FALSE;

                #$row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                #$row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_clenkontraki($data, $completo) {

        $data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND C.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro10 = ($data['Inativo'] != '#') ? 'C.Ativo = "' . $data['Inativo'] . '" AND ' : FALSE;
        #$q = ($_SESSION['log']['Permissao'] > 2) ? ' C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				C.idSis_Empresa,
                C.NomeEmpresa,
				C.NomeAdmin,
				C.Inativo,
				SN.StatusSN,
                C.DataCriacao,
				C.DataDeValidade,
				C.NivelEmpresa,
                C.CelularAdmin,
                C.Endereco,
                C.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                C.Email
            FROM
				Sis_Empresa AS C
                    LEFT JOIN Tab_Municipio AS M ON C.Municipio = M.idTab_Municipio
					LEFT JOIN Tab_StatusSN AS SN ON SN.Inativo = C.Inativo
            WHERE
				C.idSis_Empresa != 1 AND
				C.idSis_Empresa != 2 AND
				C.idSis_Empresa != 5 
				' . $data['NomeEmpresa'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataCriacao = $this->basico->mascara_data($row->DataCriacao, 'barras');
				$row->DataDeValidade = $this->basico->mascara_data($row->DataDeValidade, 'barras');
				#$row->Inativo = $this->basico->mascara_palavra_completa($row->Inativo, 'NS');
                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->CelularAdmin = ($row->CelularAdmin) ? $row->CelularAdmin : FALSE;
				#$row->Telefone2 = ($row->Telefone2) ? $row->Telefone2 : FALSE;
				#$row->Telefone3 = ($row->Telefone3) ? $row->Telefone3 : FALSE;

                #$row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                #$row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_associado($data, $completo) {

        $data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND C.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];



        $query = $this->db->query('
            SELECT
				C.idSis_Empresa,
				C.Associado,
                C.NomeEmpresa,
                C.DataCriacao,
				C.Celular,
				C.Site,
				SN.StatusSN,
				C.Inativo
            FROM
                Sis_Empresa AS C
					LEFT JOIN Tab_StatusSN AS SN ON SN.Inativo = C.Inativo
            WHERE
                C.Associado = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeEmpresa'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataCriacao = $this->basico->mascara_data($row->DataCriacao, 'barras');
                $row->Celular = ($row->Celular) ? $row->Celular : FALSE;
            }

            return $query;
        }

    }

	public function list_empresaassociado($data, $completo) {

        $data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND C.idSis_EmpresaFilial = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];



        $query = $this->db->query('
            SELECT
				C.idSis_EmpresaFilial,
				C.Associado,
                C.NomeEmpresa,
				C.Nome,
                C.Celular,
                C.Email,
				C.UsuarioidSis_EmpresaFilial,
				SN.StatusSN,
				C.Inativo
            FROM
                Sis_EmpresaFilial AS C
					LEFT JOIN Tab_StatusSN AS SN ON SN.Inativo = C.Inativo
            WHERE
                C.Associado = ' . $_SESSION['log']['idSis_EmpresaFilial'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeEmpresa'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {

                $row->Celular = ($row->Celular) ? $row->Celular : FALSE;
            }

            return $query;
        }

    }

	public function list_profissionais($data, $completo) {

        $data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND P.idApp_Profissional = ' . $data['NomeProfissional'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.NomeProfissional' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                P.idApp_Profissional,
                P.NomeProfissional,
				TF.Funcao,
                P.DataNascimento,
                P.CelularCliente,
                P.Telefone2,
                P.Telefone3,
                P.Sexo,
                P.Endereco,
                P.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                P.Email,
				CP.NomeContatoProf,
				TRP.RelaPes,
				CP.Sexo
            FROM
                App_Profissional AS P
                    LEFT JOIN Tab_Municipio AS M ON P.Municipio = M.idTab_Municipio
					LEFT JOIN App_ContatoProf AS CP ON P.idApp_Profissional = CP.idApp_Profissional
					LEFT JOIN Tab_RelaPes AS TRP ON TRP.idTab_RelaPes = CP.RelaPes
					LEFT JOIN Tab_Funcao AS TF ON TF.idTab_Funcao= P.Funcao
            WHERE
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['NomeProfissional'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->CelularCliente) ? $row->CelularCliente : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_funcionario($data, $completo) {

        $data['Nome'] = ($data['Nome']) ? ' AND F.idSis_Usuario = ' . $data['Nome'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'F.Nome' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                F.idSis_Usuario,
                F.Nome,
				FU.Funcao,
				PE.Nivel,
				PE.Permissao
            FROM
                Sis_Usuario AS F
					LEFT JOIN Tab_Funcao AS FU ON FU.idTab_Funcao = F.Funcao
					LEFT JOIN Sis_Permissao AS PE ON PE.idSis_Permissao = F.Permissao
            WHERE
				F.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				F.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
                ' . $data['Nome'] . '
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {

            }

            return $query;
        }

    }

	public function list_empresas($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND E.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
		$data['CategoriaEmpresa'] = ($data['CategoriaEmpresa']) ? ' AND E.CategoriaEmpresa = ' . $data['CategoriaEmpresa'] : FALSE;
		$data['Atuacao'] = ($data['Atuacao']) ? ' AND E.idSis_Empresa = ' . $data['Atuacao'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'E.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idSis_Empresa,
                E.NomeEmpresa,
				E.Site,
                E.EnderecoEmpresa,
                E.BairroEmpresa,
				CE.CategoriaEmpresa,
				E.Atuacao,
				E.Arquivo,
                E.MunicipioEmpresa,
                E.Email
            FROM
                Sis_Empresa AS E
					LEFT JOIN Tab_CategoriaEmpresa AS CE ON CE.idTab_CategoriaEmpresa = E.CategoriaEmpresa
            WHERE
				
				E.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' 
				' . $data['Atuacao'] . ' 
				' . $data['NomeEmpresa'] . ' 
				' . $data['CategoriaEmpresa'] . ' AND

				E.idSis_Empresa != "1" AND
				E.idSis_Empresa != "5" 
			ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {


            }

            return $query;
        }

    }
	
	public function list_empresas1($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND E.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'E.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idSis_Empresa,
                E.NomeEmpresa,
				TF.TipoFornec,
				TS.StatusSN,
				E.Fornec,
				TA.Atividade,
                E.DataNascimento,
                E.CelularCliente,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.EnderecoEmpresa,
                E.BairroEmpresa,
                E.MunicipioEmpresa,
                E.Email,
				CE.NomeContato,
				TCE.RelaCom,
				CE.Sexo
            FROM
                Sis_Empresa AS E
					LEFT JOIN App_Contato AS CE ON E.idSis_Empresa = CE.idSis_Empresa
					LEFT JOIN Tab_RelaCom AS TCE ON TCE.idTab_RelaCom = CE.RelaCom
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.Fornec
					LEFT JOIN App_Atividade AS TA ON TA.idApp_Atividade = E.Atividade
            WHERE
                E.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				E.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeEmpresa'] . '
			ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->CelularCliente) ? $row->CelularCliente : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_fornecedor($data, $completo) {

		$data['NomeFornecedor'] = ($data['NomeFornecedor']) ? ' AND E.idApp_Fornecedor = ' . $data['NomeFornecedor'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'E.NomeFornecedor' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                E.idApp_Fornecedor,
                E.NomeFornecedor,
				TF.TipoFornec,
				TS.StatusSN,
				E.Ativo,
				TA.Atividade,
                E.DataNascimento,
                E.Telefone1,
                E.Telefone2,
                E.Telefone3,
                E.Sexo,
                E.EnderecoFornecedor,
                E.BairroFornecedor,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS MunicipioFornecedor,
                E.Email,
				CE.NomeContatofornec,
				TCE.Relacao,
				CE.Sexo
            FROM
                App_Fornecedor AS E
                    LEFT JOIN Tab_Municipio AS M ON E.MunicipioFornecedor = M.idTab_Municipio
					LEFT JOIN App_Contatofornec AS CE ON E.idApp_Fornecedor = CE.idApp_Fornecedor
					LEFT JOIN Tab_Relacao AS TCE ON TCE.idTab_Relacao = CE.Relacao
					LEFT JOIN Tab_TipoFornec AS TF ON TF.Abrev = E.TipoFornec
					LEFT JOIN Tab_StatusSN AS TS ON TS.Abrev = E.Ativo
					LEFT JOIN App_Atividade AS TA ON TA.idApp_Atividade = E.Atividade
            WHERE
                E.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				E.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['NomeFornecedor'] . '
			ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');

                #$row->Sexo = $this->basico->get_sexo($row->Sexo);
                #$row->Sexo = ($row->Sexo == 2) ? 'F' : 'M';

                $row->Telefone = ($row->Telefone1) ? $row->Telefone1 : FALSE;
                $row->Telefone .= ($row->Telefone2) ? ' / ' . $row->Telefone2 : FALSE;
                $row->Telefone .= ($row->Telefone3) ? ' / ' . $row->Telefone3 : FALSE;

            }

            return $query;
        }

    }

	public function list_produtos2($data, $completo) {

		#$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
		#$data['TipoProduto'] = ($data['TipoProduto']) ? ' AND TTP.idTab_TipoProduto = ' . $data['TipoProduto'] : FALSE;
		#$data['Prodaux1'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		#$data['Prodaux2'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        #$data['Prodaux3'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		#$data['Prodaux4'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux4']) ? ' AND TP3.idTab_Prodaux4 = ' . $data['Prodaux4'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TP4.Prodaux4' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TP.idTab_Produto,
				TP.TipoProduto,
				TP.CodProd,
				TP.Produtos,
				TP.ValorProdutoSite,
				TP.Comissao,
				TP.PesoProduto,
				TP.Arquivo,
				TP.Ativo,
				TP.VendaSite
            FROM
                Tab_Produto AS TP

            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY 
				TP.idTab_Produto DESC
		
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            #$valor_produto=0;
			#$somaorcamento=0;
			#$somacomissao=0;
            foreach ($query->result() as $row) {

				#$valor_produto = $row->Valor_Cor_Prod * $row->Fator_Tam_Prod;
				#$somaorcamento += $row->ValorRestanteOrca;
				#$somacomissao += $row->ValorComissao;
                #$row->Valor_Cor_Prod = number_format($row->Valor_Cor_Prod, 2, ',', '.');
				#$row->Fator_Tam_Prod = number_format($row->Fator_Tam_Prod, 2, ',', '.');
				#$row->Valor_Produto = number_format($row->Valor_Produto, 2, ',', '.');
				#$valor_produto = number_format($valor_produto, 2, ',', '.');
				
            }
            #$query->soma = new stdClass();
			#$query->soma->valor_produto = number_format($valor_produto, 2, ',', '.');
            #$query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			#$query->soma->somacomissao = number_format($somacomissao, 2, ',', '.');			
			
			
            return $query;
        }

    }
	
	public function list_produtos($data, $completo) {

		#$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
		#$data['TipoProduto'] = ($data['TipoProduto']) ? ' AND TTP.idTab_TipoProduto = ' . $data['TipoProduto'] : FALSE;
		#$data['Prodaux1'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		#$data['Prodaux2'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        $data['Prodaux3'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		#$data['Prodaux4'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux4']) ? ' AND TP3.idTab_Prodaux4 = ' . $data['Prodaux4'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TP.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TPS.idTab_Produtos,
				TPS.Cod_Prod,
				TPS.Arquivo,
				TPS.Nome_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(TPS.Nome_Prod,""), " ", IFNULL(TOP2.Opcao,""), " ", IFNULL(TOP1.Opcao,"")) AS Nome_Prod,
				TP.idTab_Produto,
				TP.TipoProduto,
				TP.Produtos,
				TP.ValorProdutoSite,
				TP.Comissao,
				TP.PesoProduto,
				TP.Ativo,
				TP.VendaSite,
				TP3.idTab_Prodaux3,
				TP3.Prodaux3
            FROM
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP.Prodaux3
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
					
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['Prodaux3'] . '
			ORDER BY
				' . $data['Campo'] . '
				' . $data['Ordenamento'] . ', 
				TP.Produtos
		
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            #$valor_produto=0;
			#$somaorcamento=0;
			#$somacomissao=0;
            foreach ($query->result() as $row) {

				#$valor_produto = $row->Valor_Cor_Prod * $row->Fator_Tam_Prod;
				#$somaorcamento += $row->ValorRestanteOrca;
				#$somacomissao += $row->ValorComissao;
                #$row->Valor_Cor_Prod = number_format($row->Valor_Cor_Prod, 2, ',', '.');
				#$row->Fator_Tam_Prod = number_format($row->Fator_Tam_Prod, 2, ',', '.');
				#$row->Valor_Produto = number_format($row->Valor_Produto, 2, ',', '.');
				#$valor_produto = number_format($valor_produto, 2, ',', '.');
				
            }
            #$query->soma = new stdClass();
			#$query->soma->valor_produto = number_format($valor_produto, 2, ',', '.');
            #$query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			#$query->soma->somacomissao = number_format($somacomissao, 2, ',', '.');			
			
			
            return $query;
        }

    }

	public function list_servicos($data, $completo) {

		$data['Servicos'] = ($data['Servicos']) ? ' AND TP.idApp_Servicos = ' . $data['Servicos'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'TP.Servicos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TP.idApp_Servicos,
				TP.CodServ,
				TP.Servicos,
				TP.UnidadeProduto,
				TP.ValorCompraServico,
				TP.Fornecedor,
				TF.NomeFornecedor,

				TV.ValorServico,
				TC.Convenio
            FROM
                App_Servicos AS TP
					LEFT JOIN Tab_ValorServ AS TV ON TV.idApp_Servicos = TP.idApp_Servicos
					LEFT JOIN Tab_Convenio AS TC ON TC.idTab_Convenio = TV.Convenio
					LEFT JOIN App_Fornecedor AS TF ON TF.idApp_Fornecedor = TP.Fornecedor
            WHERE
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $data['Servicos'] . '
			ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {

            }

            return $query;
        }

    }

	public function list_promocao($data, $completo) {
		
		$data['Produtos'] = ($data['Produtos']) ? ' AND TPD.idTab_Produtos = ' . $data['Produtos'] : FALSE;
		$data['Promocao'] = ($data['Promocao']) ? ' AND TPM.idTab_Promocao = ' . $data['Promocao'] : FALSE;
		#$data['TipoProduto'] = ($data['TipoProduto']) ? ' AND TTP.idTab_TipoProduto = ' . $data['TipoProduto'] : FALSE;
		#$data['Prodaux1'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		#$data['Prodaux2'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        #$data['Prodaux3'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TPM.Promocao' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TPM.idTab_Promocao,
				TPM.Promocao,
				TPM.Descricao,
				TPM.Arquivo,
				TPM.Ativo,
				TPM.VendaBalcao,
				TPM.VendaSite,
				TPM.ValorPromocao,
				TDC.Desconto,
				TOP2.Opcao,
				TOP1.Opcao,
				SUM(TV.ValorProduto) AS SubTotal2
            FROM
                Tab_Promocao AS TPM
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPM.idTab_Promocao
					LEFT JOIN Tab_Produtos AS TPD ON TPD.idTab_Produtos = TV.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPD.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPD.Opcao_Atributo_2
					LEFT JOIN Tab_Desconto AS TDC ON TDC.idTab_Desconto = TPM.Desconto
            WHERE
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPM.Desconto = "2"
				' . $data['Promocao'] . '
				' . $data['Produtos'] . '
			GROUP BY
                TPM.idTab_Promocao
			ORDER BY
				TDC.Desconto ASC,
				TPM.idTab_Promocao ASC		
        ');

        if ($completo === FALSE) {
            return TRUE;
        } else {
           
			foreach ($query->result() as $row) {
				$row->ValorPromocao = number_format($row->ValorPromocao, 2, ',', '.');
				$row->SubTotal2 = number_format($row->SubTotal2, 2, ',', '.');
            }
            return $query;
        }

    }

	public function list_precopromocao($data, $completo) {

		$data['Produtos'] = ($data['Produtos']) ? ' AND TPD.idTab_Produtos = ' . $data['Produtos'] : FALSE;
		$data['Promocao'] = ($data['Promocao']) ? ' AND TPM.idTab_Promocao = ' . $data['Promocao'] : FALSE;
		#$data['TipoProduto'] = ($data['TipoProduto']) ? ' AND TTP.idTab_TipoProduto = ' . $data['TipoProduto'] : FALSE;
		#$data['Prodaux1'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		#$data['Prodaux2'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        #$data['Prodaux3'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TPD.Nome_Prod' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TPM.idTab_Promocao,
				TPM.Promocao,
				TPM.Descricao,
				TPD.Arquivo,
				TPM.Ativo,
				TPM.VendaBalcao,
				TPM.VendaSite,
				TV.idTab_Produtos,
				TV.idTab_Modelo,
				TV.Convdesc,
				TV.ValorProduto,
				TV.QtdProdutoDesconto,
				TV.QtdProdutoIncremento,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(TPD.Nome_Prod,""), " ", IFNULL(TOP2.Opcao,""), " ", IFNULL(TOP1.Opcao,""), " ", IFNULL(TV.Convdesc,""), " - ", IFNULL(TV.QtdProdutoIncremento,""), " Unid.") AS Nome_Prod,
				TDC.Desconto
            FROM
                Tab_Promocao AS TPM
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPM.idTab_Promocao
					LEFT JOIN Tab_Produtos AS TPD ON TPD.idTab_Produtos = TV.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPD.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPD.Opcao_Atributo_2
					LEFT JOIN Tab_Desconto AS TDC ON TDC.idTab_Desconto = TPM.Desconto					
            WHERE
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPM.Desconto = "1"
				' . $data['Produtos'] . '
			ORDER BY
				TDC.Desconto ASC,
				TPM.idTab_Promocao ASC		
        ');

        /*
        ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '	, TPM.Promocao ASC
		#AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            #$somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            $subtotal=$total=0;
			foreach ($query->result() as $row) {
				/*
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
				*/
                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                /*
				if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }
				*/
                
				$valor_produto = $row->ValorProduto;
				$qtd_produto = $row->QtdProdutoDesconto;
				$subtotal += $valor_produto * $qtd_produto;
				
				/*
				$somarecebido += $row->ValorPago;
                $somareceber += $row->ValorParcela;
				

                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');
				*/
            }
            $total = $subtotal;
			/*
			$somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;
			*/
            $query->soma = new stdClass();
            /*
			$query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');
			*/
			$query->soma->total = number_format($total, 2, ',', '.');
			
            return $query;
        }

    }
	
	public function list_catprod($data, $completo) {

		$data['Catprod'] = ($data['Catprod']) ? ' AND TPM.idTab_Catprod = ' . $data['Catprod'] : FALSE;
		#$data['TipoProduto'] = ($data['TipoProduto']) ? ' AND TTP.idTab_TipoProduto = ' . $data['TipoProduto'] : FALSE;
		#$data['Prodaux1'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux1']) ? ' AND TP1.idTab_Prodaux1 = ' . $data['Prodaux1'] : FALSE;
		#$data['Prodaux2'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux2']) ? ' AND TP2.idTab_Prodaux2 = ' . $data['Prodaux2'] : FALSE;
        #$data['Prodaux3'] = ($_SESSION['log']['NivelEmpresa'] >= 4  && $data['Prodaux3']) ? ' AND TP3.idTab_Prodaux3 = ' . $data['Prodaux3'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TPD.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TPM.idTab_Catprod,
				TPM.Catprod,
				TPM.idSis_Empresa,
				TAT.Atributo,
				TOP.Opcao
            FROM
                Tab_Catprod AS TPM
					
					LEFT JOIN Tab_Atributo_Select AS TAS ON TAS.idTab_Catprod = TPM.idTab_Catprod
					LEFT JOIN Tab_Atributo AS TAT ON TAT.idTab_Atributo = TAS.idTab_Atributo
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Atributo = TAT.idTab_Atributo
            WHERE
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				TPM.Catprod ASC,
				TAT.Atributo ASC,
				TOP.Opcao ASC
        ');

        /*
        ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '	, TPM.Promocao ASC
		#AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            #$somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            #$subtotal=$total=0;
			foreach ($query->result() as $row) {
				/*
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
				*/
                #esse trecho pode ser melhorado, serve para somar apenas uma vez
                #o valor da entrada que pode aparecer mais de uma vez
                /*
				if ($ant != $row->idApp_OrcaTrata) {
                    $ant = $row->idApp_OrcaTrata;
                    $somaentrada += $row->ValorEntradaOrca;
                }
                else {
                    $row->ValorEntradaOrca = FALSE;
                    $row->DataEntradaOrca = FALSE;
                }
				
                
				$valor_produto = $row->ValorProduto;
				$qtd_produto = $row->QtdProdutoDesconto;
				$subtotal += $valor_produto * $qtd_produto;
				
				
				$somarecebido += $row->ValorPago;
                $somareceber += $row->ValorParcela;
				

                $row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
                $row->ValorPago = number_format($row->ValorPago, 2, ',', '.');
				*/
            }
            /*
				$total = $subtotal;
			
			$somareceber -= $somarecebido;
            $somareal = $somarecebido;
            $balanco = $somarecebido + $somareceber;

			$somapagar -= $somapago;
			$somareal2 = $somapago;
			$balanco2 = $somapago + $somapagar;
			
            $query->soma = new stdClass();
            
			$query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somareal = number_format($somareal, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			$query->soma->somapagar = number_format($somapagar, 2, ',', '.');
            $query->soma->somapago = number_format($somapago, 2, ',', '.');
            $query->soma->somareal2 = number_format($somareal2, 2, ',', '.');
            $query->soma->balanco2 = number_format($balanco2, 2, ',', '.');
			
			$query->soma->total = number_format($total, 2, ',', '.');
			*/
            return $query;
        }

    }

	public function list_atributo($data, $completo) {
	
		$data['Atributo'] = ($data['Atributo']) ? ' AND TPM.idTab_Atributo = ' . $data['Atributo'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'TPD.Produtos' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];

        $query = $this->db->query('
            SELECT
                TPM.idTab_Atributo,
				TPM.Atributo,
				TPM.idSis_Empresa,
				TOP.Opcao
            FROM
                Tab_Atributo AS TPM
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Atributo = TPM.idTab_Atributo
            WHERE
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				TPM.Atributo ASC,
				TOP.Opcao ASC
        ');

        /*
        ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '	, TPM.Promocao ASC
		#AND
        #P.idApp_Profissional = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

			foreach ($query->result() as $row) {

            }

            return $query;
        }

    }
		
	public function list_orcamentoonline($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio'] . '" AND OT.DataVencimentoOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio'] . '")';
        }
        $data['Campo'] = (!$data['Campo']) ? 'EMP.NomeEmpresa' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        #$filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.Tipo_Orca,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.ValorFrete,
				OT.ValorFatura,
				OT.ValorGateway,
				OT.ValorBoleto,
				OT.ValorComissao,
				OT.ValorEnkontraki,
				OT.ValorEmpresa,
                OT.ConcluidoOrca,
				OT.QuitadoOrca,
                OT.DataConclusao,
				OT.DataQuitado,
				OT.DataRetorno,
				OT.DataVencimentoOrca,
				OT.ObsOrca,
				EMP.NomeEmpresa,
				FP.FormaPag
			FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = OT.idSis_Empresa
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
			WHERE
                OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OT.Tipo_Orca = "O" AND
				OT.AprovadoOrca = "S" AND
				OT.idTab_TipoRD = "2" AND
				' . $consulta . '

            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaorcamento=0;
			$somacomissao=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');
				$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$somaorcamento += $row->ValorRestanteOrca;
				$somacomissao += $row->ValorComissao;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');
				$row->ValorComissao = number_format($row->ValorComissao, 2, ',', '.');
            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somacomissao = number_format($somacomissao, 2, ',', '.');
            return $query;
        }

    }	

	public function list_orcamentoonlineempresa($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio'] . '" AND OT.DataVencimentoOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataVencimentoOrca >= "' . $data['DataInicio'] . '")';
        }
        $data['Campo'] = (!$data['Campo']) ? 'U.Nome' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        #$filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
				OT.Tipo_Orca,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.ValorFrete,
				OT.ValorFatura,
				OT.ValorGateway,
				OT.ValorBoleto,
				OT.ValorComissao,
				OT.ValorEnkontraki,
				OT.ValorEmpresa,
                OT.ConcluidoOrca,
				OT.QuitadoOrca,
                OT.DataConclusao,
				OT.DataQuitado,
				OT.DataRetorno,
				OT.DataVencimentoOrca,
				OT.ObsOrca,
				U.Nome,
				FP.FormaPag
			FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.Tipo_Orca = "O" AND
				OT.AprovadoOrca = "S" AND
				OT.idTab_TipoRD = "2" AND
				OT.idSis_Usuario != "0" AND
				OT.idSis_Usuario != "1" AND
				' . $consulta . '

            ORDER BY
				' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaorcamento=0;
			$somacomissao=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                $row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');
				$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
				$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                $row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$somaorcamento += $row->ValorRestanteOrca;
				$somacomissao += $row->ValorComissao;
                $row->ValorRestanteOrca = number_format($row->ValorRestanteOrca, 2, ',', '.');
				$row->ValorComissao = number_format($row->ValorComissao, 2, ',', '.');
            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');
			$query->soma->somacomissao = number_format($somacomissao, 2, ',', '.');
            return $query;
        }

    }	
	
	public function list_orcamentopc($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['NomeProfissional'] = ($data['NomeProfissional']) ? ' AND PR.idApp_Profissional = ' . $data['NomeProfissional'] : FALSE;
        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        #$filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['ConcluidoProcedimento'] != '#') ? 'PC.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;


        $query = $this->db->query('
            SELECT
                C.NomeCliente,
                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataPrazo,
                OT.ValorOrca,
                OT.ConcluidoOrca,
                OT.DataConclusao,
				TPD.NomeProduto,
				PC.DataProcedimento,
				PR.NomeProfissional,
				PC.Procedimento,
				PC.ConcluidoProcedimento
			FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
					LEFT JOIN App_Produto AS PD ON OT.idApp_OrcaTrata = PD.idApp_OrcaTrata
					LEFT JOIN Tab_Produto AS TPD ON TPD.idTab_Produto = PD.idTab_Produto
					LEFT JOIN App_Procedimento AS PC ON OT.idApp_OrcaTrata = PC.idApp_OrcaTrata
					LEFT JOIN App_Profissional AS PR ON PR.idApp_Profissional = PC.Profissional
			WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '
				' . $filtro3 . '
				' . $filtro4 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '
				' . $data['NomeProfissional'] . '
            ORDER BY
                C.NomeCliente ASC,
				OT.AprovadoOrca DESC,
				OT.ConcluidoOrca,
				PC.DataProcedimento,
				PC.ConcluidoProcedimento
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaorcamento=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                #$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                #$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');


				$somaorcamento += $row->ValorOrca;

                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');

            return $query;
        }

    }

	public function list_tarefa($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(P.DataProcedimento >= "' . $data['DataInicio'] . '" AND P.DataProcedimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(P.DataProcedimento >= "' . $data['DataInicio'] . '")';
        }
		
        $data['Campo'] = (!$data['Campo']) ? 'P.Categoria' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		#$filtro4 = ($data['ConcluidoProcedimento']) ? 'P.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;
		#$filtro5 = ($data['Prioridade']) ? 'P.Prioridade = "' . $data['Prioridade'] . '" AND ' : FALSE;
		#$filtro5 = ($data['ConcluidoProcedimento'] != '0') ? 'P.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;
        $filtro6 = ($data['Prioridade'] != '0') ? 'P.Prioridade = "' . $data['Prioridade'] . '" AND ' : FALSE;		
		$filtro11 = ($data['Statustarefa'] != '0') ? 'P.Statustarefa = "' . $data['Statustarefa'] . '" AND ' : FALSE;
		$filtro12 = ($data['Statussubtarefa'] != '0') ? 'SP.Statussubtarefa = "' . $data['Statussubtarefa'] . '" AND ' : FALSE;
		$filtro9 = ($data['Categoria'] != '0') ? 'P.Categoria = "' . $data['Categoria'] . '" AND ' : FALSE;
		#$filtro8 = (($data['ConcluidoSubProcedimento'] != '0') && ($data['ConcluidoSubProcedimento'] != 'M')) ? 'SP.ConcluidoSubProcedimento = "' . $data['ConcluidoSubProcedimento'] . '" AND ' : FALSE;
		#$filtro3 = ($data['ConcluidoSubProcedimento'] == 'M') ? '((SP.ConcluidoSubProcedimento = "S") OR (SP.ConcluidoSubProcedimento = "N")) AND ' : FALSE;
		$filtro10 = ($data['SubPrioridade'] != '0') ? 'SP.Prioridade = "' . $data['SubPrioridade'] . '" AND ' : FALSE;
		$data['Procedimento'] = ($data['Procedimento']) ? ' AND P.idApp_Procedimento = ' . $data['Procedimento'] : FALSE;
		#$data['ConcluidoProcedimento'] = ($data['ConcluidoProcedimento'] != '') ? ' AND P.ConcluidoProcedimento = ' . $data['ConcluidoProcedimento'] : FALSE;
		#$data['Prioridade'] = ($data['Prioridade'] != '') ? ' AND P.Prioridade = ' . $data['Prioridade'] : FALSE;
		#$permissao1 = (($_SESSION['FiltroAlteraProcedimento']['Categoria'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Categoria'] != '' )) ? 'P.Categoria = "' . $_SESSION['FiltroAlteraProcedimento']['Categoria'] . '" AND ' : FALSE;
		#$permissao2 = (($_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] != '' )) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] . '" AND ' : FALSE;
		#$permissao3 = (($_SESSION['FiltroAlteraProcedimento']['Prioridade'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Prioridade'] != '' )) ? 'P.Prioridade = "' . $_SESSION['FiltroAlteraProcedimento']['Prioridade'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				E.NomeEmpresa,
				U.idSis_Usuario,
				U.CpfUsuario,
				U.Nome AS NomeUsuario,
				AU.Nome AS Comp,
				P.idSis_Empresa,
				P.idApp_Procedimento,
                P.Procedimento,
				P.DataProcedimento,
				P.DataProcedimentoLimite,
				P.ConcluidoProcedimento,
				P.Prioridade,
				P.Statustarefa,
				P.Compartilhar,
				CT.Categoria,
				SP.SubProcedimento,
				SP.Statussubtarefa,
				SP.ConcluidoSubProcedimento,
				SP.DataSubProcedimento,
				SP.DataSubProcedimentoLimite,
				SP.Prioridade AS SubPrioridade,
				SN.StatusSN
            FROM
				App_Procedimento AS P
					LEFT JOIN App_SubProcedimento AS SP ON SP.idApp_Procedimento = P.idApp_Procedimento
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = P.Categoria
            WHERE
				' . $filtro6 . '
				' . $filtro9 . '
				' . $filtro10 . '
				' . $filtro11 . '
				' . $filtro12 . '
				(' . $consulta . ') AND
				((U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				AU.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ') OR
				P.Compartilhar = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				(P.Compartilhar = 51 AND P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '))
				' . $data['Procedimento'] . '
			ORDER BY
				P.Statustarefa,
				P.Prioridade,
				' . $data['Campo'] . '
				' . $data['Ordenamento'] . '
				
				
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somatarefa=0;
            foreach ($query->result() as $row) {
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->DataProcedimentoLimite = $this->basico->mascara_data($row->DataProcedimentoLimite, 'barras');
				$row->DataSubProcedimento = $this->basico->mascara_data($row->DataSubProcedimento, 'barras');
				$row->DataSubProcedimentoLimite = $this->basico->mascara_data($row->DataSubProcedimentoLimite, 'barras');				
				#$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                $row->ConcluidoSubProcedimento = $this->basico->mascara_palavra_completa2($row->ConcluidoSubProcedimento, 'NS');
				$row->Prioridade = $this->basico->prioridade($row->Prioridade, '123');
				$row->SubPrioridade = $this->basico->prioridade($row->SubPrioridade, '123');
				$row->Statustarefa = $this->basico->statustrf($row->Statustarefa, '123');
				$row->Statussubtarefa = $this->basico->statustrf($row->Statussubtarefa, '123');
				#$row->Rotina = $this->basico->mascara_palavra_completa($row->Rotina, 'NS');
            }
            $query->soma = new stdClass();
            $query->soma->somatarefa = number_format($somatarefa, 2, ',', '.');

            return $query;
        }

    }

	public function list_procedimento($data, $completo) {

		$data['Dia'] = ($data['Dia']) ? ' AND DAY(C.DataProcedimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(C.DataProcedimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(C.DataProcedimento) = ' . $data['Ano'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.DataProcedimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro10 = ($data['ConcluidoProcedimento'] != '#') ? 'C.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
				U.idSis_Usuario,
				U.CpfUsuario,
				C.idSis_Empresa,
				C.idApp_Procedimento,
                C.Procedimento,
				C.DataProcedimento,
				C.ConcluidoProcedimento
            FROM
				App_Procedimento AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				C.idApp_OrcaTrata = "0" AND
				C.idApp_Cliente = "0" AND
				' . $filtro10 . '
				U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' 
                ' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
				
            ORDER BY
                ' . $data['Campo'] . ' 
				' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');

            }

            return $query;
        }

    }

	public function list_alterarprocedimento($data, $completo) {

		$data['Dia'] = ($data['Dia']) ? ' AND DAY(C.DataProcedimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(C.DataProcedimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(C.DataProcedimento) = ' . $data['Ano'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'C.DataProcedimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro10 = ($data['ConcluidoProcedimento'] != '#') ? 'C.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
				U.idSis_Usuario,
				U.CpfUsuario,
				C.idSis_Empresa,
				C.idApp_Procedimento,
                C.Procedimento,
				C.DataProcedimento,
				C.ConcluidoProcedimento
            FROM
				App_Procedimento AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				C.idApp_OrcaTrata = "0" AND
				C.idApp_Cliente = "0" AND
				' . $filtro10 . '
				U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' 
                ' . $data['Dia'] . ' 
				' . $data['Mesvenc'] . ' 
				' . $data['Ano'] . ' 
				
            ORDER BY
                ' . $data['Campo'] . ' 
				' . $data['Ordenamento'] . '
        ');
        /*

        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');

            }

            return $query;
        }

    }
	
	public function list_clienteprod($data, $completo) {

        $data['Campo'] = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		#$filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;

        $query = $this->db->query('
            SELECT

                C.NomeCliente,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				PD.QtdProduto,
				TPD.NomeProduto,
				PC.Procedimento,
				PC.ConcluidoProcedimento
            FROM
                App_Cliente AS C,
				App_OrcaTrata AS OT
				LEFT JOIN App_Produto AS PD ON OT.idApp_OrcaTrata = PD.idApp_OrcaTrata
				LEFT JOIN Tab_Produto AS TPD ON TPD.idTab_Produto = PD.idTab_Produto
				LEFT JOIN App_Procedimento AS PC ON OT.idApp_OrcaTrata = PC.idApp_OrcaTrata
            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idApp_Cliente = OT.idApp_Cliente
            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
        #AND
        #C.idApp_Cliente = OT.idApp_Cliente

          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {
				#$row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
				$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');

				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');

            }

            return $query;
        }

    }

	public function list_orcamentosv($data, $completo) {

        if ($data['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $data['DataInicio'] . '")';
        }

        $data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;

        $filtro1 = ($data['AprovadoOrca'] != '#') ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        #$filtro2 = ($data['QuitadoOrca'] != '#') ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca'] != '#') ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['ConcluidoProcedimento'] != '#') ? 'PC.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;


        $query = $this->db->query('
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataPrazo,
                OT.ValorOrca,

                OT.ConcluidoOrca,

                OT.DataConclusao,

				TSV.NomeServico,

				PC.DataProcedimento,
				PR.NomeProfissional,
				PC.Procedimento,
				PC.ConcluidoProcedimento

			FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
					LEFT JOIN App_Servico AS SV ON OT.idApp_OrcaTrata = SV.idApp_OrcaTrata
					LEFT JOIN Tab_Servico AS TSV ON TSV.idTab_Servico = SV.idTab_Servico
					LEFT JOIN App_Procedimento AS PC ON OT.idApp_OrcaTrata = PC.idApp_OrcaTrata
					LEFT JOIN App_Profissional AS PR ON PR.idApp_Profissional = PC.Profissional

			WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                (' . $consulta . ') AND
                ' . $filtro1 . '

				' . $filtro3 . '
				' . $filtro4 . '
                C.idApp_Cliente = OT.idApp_Cliente
                ' . $data['NomeCliente'] . '

            ORDER BY
                ' . $data['Campo'] . ' ' . $data['Ordenamento'] . '
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            $somaorcamento=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
				$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
                #$row->DataRetorno = $this->basico->mascara_data($row->DataRetorno, 'barras');

                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                $row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
                #$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');

				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');


				$somaorcamento += $row->ValorOrca;

                $row->ValorOrca = number_format($row->ValorOrca, 2, ',', '.');

            }
            $query->soma = new stdClass();
            $query->soma->somaorcamento = number_format($somaorcamento, 2, ',', '.');

            return $query;
        }

    }

	public function list_slides($data, $completo) {

        $query = $this->db->query('
            SELECT
                idApp_Slides,
				Slide1,
				Texto_Slide1,
				Ativo
            FROM
                App_Slides
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY
				idApp_Slides		
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

        if ($completo === FALSE) {
            return TRUE;
        } else {

            foreach ($query->result() as $row) {

            }

            return $query;
        }

    }

    public function list1_produtos($x) {

        $query = $this->db->query('
			SELECT 
				TP.idTab_Produtos,
				TP.Nome_Prod,
				TP.Arquivo,
				TP.Ativo,
				TP.VendaSite,
				TP.ValorProdutoSite,
				TP.Comissao,
				TV.ValorProduto
			FROM 
				Tab_Produtos AS TP
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produtos = TP.idTab_Produtos
			WHERE
				TP.idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ' AND
				TP.Ativo = "S" AND
				TP.VendaSite = "S"
			ORDER BY 
				TP.Nome_Prod ASC 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function list2_slides($x) {

        $query = $this->db->query('
			SELECT 
				TS.idApp_Slides,
				TS.Slide1,
				TS.Texto_Slide1,
				TS.Ativo
			FROM 
				App_Slides AS TS
			WHERE
				TS.idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . ' AND
				TS.Ativo = "S"
			ORDER BY 
				TS.idApp_Slides ASC 
		');

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function list3_documentos($x) {

        $query = $this->db->query('
			SELECT 
				TD.idApp_Documentos,
				TD.Logo_Nav,
				TD.Icone
			FROM 
				App_Documentos AS TD
			WHERE
				TD.idSis_Empresa = ' . $_SESSION['Empresa']['idSis_Empresa'] . '
			ORDER BY 
				TD.idApp_Documentos ASC 
		');

        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                $query = $query->result_array();
                return $query;
            }
        }
    }
	
    public function select_cliente() {

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                CONCAT(IFNULL(C.idApp_Cliente, ""), " --- ", IFNULL(C.NomeCliente, ""), " --- ", IFNULL(C.CelularCliente, ""), " --- ", IFNULL(C.Telefone2, ""), " --- ", IFNULL(C.Telefone3, "")) As NomeCliente
            FROM
                App_Cliente AS C

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.NomeCliente ASC
        ');

        $array = array();
        $array[0] = ':: Todos os Clientes ::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Cliente] = $row->NomeCliente;
        }

        return $array;
    }

    public function select_clenkontraki() {

        $query = $this->db->query('
            SELECT
                C.idSis_Empresa,
                CONCAT(IFNULL(C.NomeEmpresa, ""), " --- ", IFNULL(C.NomeAdmin, "")) As NomeEmpresa
            FROM
                Sis_Empresa AS C
            WHERE
                C.idSis_Empresa != ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                C.NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }

	public function select_associado() {

        $query = $this->db->query('
            SELECT
                idSis_Empresa,
                NomeEmpresa
            FROM
                Sis_Empresa
            WHERE
                Associado = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }

	public function select_empresaassociado() {

        $query = $this->db->query('
            SELECT
                idSis_EmpresaFilial,
                NomeEmpresa
            FROM
                Sis_EmpresaFilial
            WHERE
                Associado = ' . $_SESSION['log']['idSis_EmpresaFilial'] . ' AND
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
			$array[$row->idSis_EmpresaFilial] = $row->NomeEmpresa;
        }

        return $array;
    }

	public function select_empresas() {

        $query = $this->db->query('
            SELECT
                idSis_Empresa,
				NomeEmpresa
            FROM
                Sis_Empresa
            WHERE
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				idSis_Empresa != "1" AND 
				idSis_Empresa != "5" 
            ORDER BY
                NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }

	public function select_fornecedor() {

        $query = $this->db->query('
            SELECT
                idApp_Fornecedor,
				CONCAT(IFNULL(NomeFornecedor, ""), " --- ", IFNULL(Telefone1, "")) As NomeFornecedor
            FROM
                App_Fornecedor
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeFornecedor ASC
        ');

        $array = array();
        $array[0] = ':: Todos os Fornecedores ::';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Fornecedor] = $row->NomeFornecedor;
        }

        return $array;
    }

    public function select_funcionario() {

        $query = $this->db->query('
            SELECT
                F.idSis_Usuario,
                F.Nome
            FROM
                Sis_Usuario AS F
            WHERE
                F.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				F.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                F.Nome ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->Nome;
        }

        return $array;
    }

	public function select_profissional() {

        $query = $this->db->query('
            SELECT
                P.idApp_Profissional,
                CONCAT(P.NomeProfissional, " ", "---", P.CelularCliente) AS NomeProfissional
            FROM
                App_Profissional AS P
            WHERE
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeProfissional ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Profissional] = $row->NomeProfissional;
        }

        return $array;
    }

	public function select_profissional2() {

        $query = $this->db->query('
            SELECT
                P2.idApp_Profissional,
                P2.NomeProfissional
            FROM
                App_Profissional AS P2
            WHERE
                P2.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				P2.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                NomeProfissional ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Profissional] = $row->NomeProfissional;
        }

        return $array;
    }

	public function select_profissional3() {

        $query = $this->db->query('
            SELECT
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY F.Abrev ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Profissional] = $row->NomeProfissional;
        }

        return $array;
    }

	public function select_convenio() {

        $query = $this->db->query('
            SELECT
                P.idTab_Convenio,
                P.Convenio
            FROM
                Tab_Convenio AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Convenio ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Convenio] = $row->Convenio;
        }

        return $array;
    }

	public function select_formapag() {

        $query = $this->db->query('
            SELECT
                P.idTab_FormaPag,
                P.FormaPag
            FROM
                Tab_FormaPag AS P
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                FormaPag ASC
        ');

        $array = array();
        $array[0] = '::TODOS::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_FormaPag] = $row->FormaPag;
        }

        return $array;
    }
	
	public function select_tipofrete() {

        $query = $this->db->query('
            SELECT
                P.idTab_TipoFrete,
                P.TipoFrete
            FROM
                Tab_TipoFrete AS P
            ORDER BY
                TipoFrete ASC
        ');

        $array = array();
        $array[0] = '::TODOS::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFrete] = $row->TipoFrete;
        }

        return $array;
    }	

	public function select_dia() {

        $query = $this->db->query('
            SELECT
				D.idTab_Dia,
				D.Dia				
			FROM
				Tab_Dia AS D
			ORDER BY
				D.Dia
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Dia] = $row->Dia;
        }

        return $array;
    }	
	
	public function select_mes() {

        $query = $this->db->query('
            SELECT
				M.idTab_Mes,
				M.Mesdesc,
				CONCAT(M.Mes, " - ", M.Mesdesc) AS Mes
			FROM
				Tab_Mes AS M

			ORDER BY
				M.Mes
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Mes] = $row->Mes;
        }

        return $array;
    }	

	public function select_ano() {

        $query = $this->db->query('
            SELECT
				A.idTab_Ano,
				A.Ano				
			FROM
				Tab_Ano AS A
			ORDER BY
				A.Ano
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->Ano] = $row->Ano;
        }

        return $array;
    }	
	
	public function select_tipofinanceiro() {

        $query = $this->db->query('
            SELECT
				TR.idTab_TipoFinanceiro,
				TR.TipoFinanceiro
			FROM
				Tab_TipoFinanceiro AS TR
			WHERE
				TR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY
				TR.TipoFinanceiro
        ');

        $array = array();
        $array[0] = ':: TODOS ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }
	
	public function select_tipofinanceiroR() {

		$permissao1 = ($_SESSION['log']['idSis_Empresa'] != 5 ) ? ' AND (TR.EP = "E" OR TR.EP = "EP")' : FALSE;
		$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? ' AND (TR.EP = "P" OR TR.EP = "EP" )' : FALSE;
		
        $query = $this->db->query('
            SELECT
				TR.idTab_TipoFinanceiro,
				TR.TipoFinanceiro,
				TR.RD
			FROM
				Tab_TipoFinanceiro AS TR
			WHERE
				TR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TR.RD = "R" OR TR.RD = "RD")
					' . $permissao1 . '
					' . $permissao2 . '				
			ORDER BY
				TR.TipoFinanceiro
        ');

        $array = array();
        $array[0] = ':: TODOS ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }

	public function select_tipofinanceiroD() {

		$permissao1 = ($_SESSION['log']['idSis_Empresa'] != 5 ) ? ' AND (TR.EP = "E" OR TR.EP = "EP")' : FALSE;
		$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? ' AND (TR.EP = "P" OR TR.EP = "EP" )' : FALSE;	
	
        $query = $this->db->query('
            SELECT
				TR.idTab_TipoFinanceiro,
				TR.TipoFinanceiro,
				TR.RD
			FROM
				Tab_TipoFinanceiro AS TR
			WHERE
				TR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TR.RD = "D" OR TR.RD = "RD")
					' . $permissao1 . '
					' . $permissao2 . '				
			ORDER BY
				TR.TipoFinanceiro
        ');

        $array = array();
        $array[0] = ':: TODOS ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }
	
	public function select_tiporeceita() {

        $query = $this->db->query('
            SELECT
				TR.idTab_TipoFinanceiro,
				TR.TipoFinanceiro
			FROM
				Tab_TipoFinanceiro AS TR
			WHERE
				TR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY
				TR.TipoFinanceiro
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }
	
	public function select_tipodespesa() {

        $query = $this->db->query('
            SELECT
				TD.idTab_TipoFinanceiro,
				CONCAT(TD.TipoFinanceiro) AS TipoFinanceiro


			FROM
				Tab_TipoFinanceiro AS TD

			WHERE
				TD.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY

				TD.TipoFinanceiro
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoFinanceiro] = $row->TipoFinanceiro;
        }

        return $array;
    }

	public function select_tipoproduto() {

        $query = $this->db->query('
            SELECT
				TD.idTab_TipoProduto,
				TD.Abrev,
				CONCAT(TD.TipoProduto) AS TipoProduto
			FROM
				Tab_TipoProduto AS TD

			ORDER BY
				TD.TipoProduto DESC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoProduto] = $row->TipoProduto;
        }

        return $array;
    }
	
	public function select_categoriadesp() {

        $query = $this->db->query('
            SELECT
				Categoriadesp
			FROM
				Tab_Categoriadesp

			ORDER BY
				Categoriadesp
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->Categoriadesp] = $row->Categoriadesp;
        }

        return $array;
    }

	public function select_categoriaempresa() {

        $query = $this->db->query('
            SELECT
				idTab_CategoriaEmpresa,
				CategoriaEmpresa
			FROM
				Tab_CategoriaEmpresa

			ORDER BY
				CategoriaEmpresa
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_CategoriaEmpresa] = $row->CategoriaEmpresa;
        }

        return $array;
    }
	
	public function select_atuacao() {

        $query = $this->db->query('
            SELECT
				idSis_Empresa,
				NomeEmpresa,
				CONCAT(idSis_Empresa, " - ", NomeEmpresa, " ->>>>- ", Atuacao) AS Atuacao
			FROM
				Sis_Empresa

			ORDER BY
				NomeEmpresa
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Empresa] = $row->Atuacao;
        }

        return $array;
    }	
	
	public function select_tipoconsumo() {

        $query = $this->db->query('
            SELECT
                TD.idTab_TipoConsumo,
                TD.TipoConsumo
            FROM
                Tab_TipoConsumo AS TD
			WHERE
				TD.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                TipoConsumo ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoConsumo] = $row->TipoConsumo;
        }

        return $array;
    }

	public function select_tipodevolucao() {

        $query = $this->db->query('
            SELECT
                idTab_TipoDevolucao,
                TipoDevolucao
            FROM
                Tab_TipoDevolucao
            ORDER BY
                TipoDevolucao DESC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_TipoDevolucao] = $row->TipoDevolucao;
        }

        return $array;
    }

	public function select_obstarefa() {

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
                OB.idApp_Procedimento,
                OB.Procedimento
            FROM
                App_Procedimento AS OB
            WHERE
                ' . $permissao . '
				OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                OB.Procedimento ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Procedimento] = $row->Procedimento;
        }

        return $array;
    }

	public function select_tarefa() {

		$permissao1 = (($_SESSION['FiltroAlteraProcedimento']['Categoria'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Categoria'] != '' )) ? 'P.Categoria = "' . $_SESSION['FiltroAlteraProcedimento']['Categoria'] . '" AND ' : FALSE;
		#$permissao2 = (($_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] != '' )) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] . '" AND ' : FALSE;
		$permissao3 = (($_SESSION['FiltroAlteraProcedimento']['Prioridade'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Prioridade'] != '' )) ? 'P.Prioridade = "' . $_SESSION['FiltroAlteraProcedimento']['Prioridade'] . '" AND ' : FALSE;
		$permissao7 = (($_SESSION['FiltroAlteraProcedimento']['Statustarefa'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Statustarefa'] != '' )) ? 'P.Statustarefa = "' . $_SESSION['FiltroAlteraProcedimento']['Statustarefa'] . '" AND ' : FALSE;
		$permissao8 = (($_SESSION['FiltroAlteraProcedimento']['Statussubtarefa'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['Statussubtarefa'] != '' )) ? 'SP.Statussubtarefa = "' . $_SESSION['FiltroAlteraProcedimento']['Statussubtarefa'] . '" AND ' : FALSE;
		$permissao6 = (($_SESSION['FiltroAlteraProcedimento']['SubPrioridade'] != "0" ) && ($_SESSION['FiltroAlteraProcedimento']['SubPrioridade'] != '' )) ? 'SP.Prioridade = "' . $_SESSION['FiltroAlteraProcedimento']['SubPrioridade'] . '" AND ' : FALSE;
		#$permissao4 = ((($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] != "0")&& ($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] != 'M') ) && ($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] != '' )) ? 'SP.ConcluidoSubProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] . '" AND ' : FALSE;
		#$permissao5 = (($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] == 'M') && ($_SESSION['FiltroAlteraProcedimento']['ConcluidoSubProcedimento'] != '' )) ? '((SP.ConcluidoSubProcedimento = "S") OR (SP.ConcluidoSubProcedimento = "N")) AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
                P.idApp_Procedimento,
                P.Procedimento
            FROM
				App_Procedimento AS P
					LEFT JOIN App_SubProcedimento AS SP ON SP.idApp_Procedimento = P.idApp_Procedimento
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
					LEFT JOIN Tab_Prioridade AS PR ON PR.idTab_Prioridade = P.Prioridade
            WHERE
				' . $permissao1 . '
				' . $permissao3 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao8 . '
				(U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				AU.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				P.Compartilhar = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				(P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ') OR
				(P.Compartilhar = 51 AND P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '))
            ORDER BY
                P.Procedimento ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Procedimento] = $row->Procedimento;
        }

        return $array;
    }

    public function select_categoria() {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
                C.idTab_Categoria,
                C.Categoria
            FROM
                Tab_Categoria AS C
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = C.idSis_Usuario
            WHERE
				U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				(C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' )
            ORDER BY
                C.Categoria ASC
        ');

        $array = array();
        $array[0] = '::Todos::';
        foreach ($query->result() as $row) {
			$array[$row->idTab_Categoria] = $row->Categoria;
        }

        return $array;
    }

	public function select_tarefa1() {

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        
		$query = $this->db->query('
            SELECT
                OB.idApp_Procedimento,
                OB.Procedimento
            FROM
                App_Procedimento AS OB
            WHERE
                ' . $permissao . '
				OB.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
                OB.Procedimento ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Procedimento] = $row->Procedimento;
        }

        return $array;
    }

	public function select_promocao() {
		
        $query = $this->db->query('
            SELECT
                TPM.idTab_Promocao,
				TPM.Promocao,
				OB.idTab_Produtos,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(OB.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,"")) AS Produtos
            FROM
                Tab_Promocao AS TPM
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPM.idTab_Promocao
					LEFT JOIN Tab_Produtos AS OB ON OB.idTab_Produtos = TV.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = OB.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = OB.Opcao_Atributo_2
            WHERE
				TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
            ORDER BY
				Produtos ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Promocao] = $row->Promocao;
        }

        return $array;
    }
	
	public function select_produtos1() {
		
        $query = $this->db->query('
            SELECT
                OB.idTab_Produtos,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(OB.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,"")) AS Produtos
            FROM
                Tab_Produtos AS OB
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = OB.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = OB.Opcao_Atributo_2
            WHERE
				OB.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
				Produtos ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Produtos] = $row->Produtos;
        }

        return $array;
    }

	public function select_produtos() {
	
        $query = $this->db->query('
            SELECT
                OB.idTab_Produto,
				CONCAT(IFNULL(OB.CodProd,""), " - ", IFNULL(TP3.Prodaux3,""), " - ", IFNULL(OB.Produtos,""), " - ", IFNULL(TP1.Prodaux1,""), " - ", IFNULL(TP2.Prodaux2,""), " -R$ ", IFNULL(TV.ValorProduto,"")) AS Produtos,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TP3.Prodaux3,
				TP1.Abrev1,
				TP2.Abrev2,
                OB.CodProd,
				TV.ValorProduto
            FROM
                Tab_Produto AS OB
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = OB.Prodaux1
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = OB.Prodaux2
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = OB.Prodaux3
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Modelo = OB.idTab_Produto
            WHERE
				OB.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                OB.CodProd,
				TP3.Prodaux3,
				Produtos ASC,
				TP1.Abrev1 DESC,
				TP2.Abrev2 DESC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Produto] = $row->Produtos;
        }

        return $array;
    }

	public function select_prodaux1() {

        $query = $this->db->query('
            SELECT
                P.idTab_Prodaux1,
                P.Prodaux1
            FROM
                Tab_Prodaux1 AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Prodaux1 ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Prodaux1] = $row->Prodaux1;
        }

        return $array;
    }

	public function select_prodaux2() {

        $query = $this->db->query('
            SELECT
                P.idTab_Prodaux2,
                P.Prodaux2
            FROM
                Tab_Prodaux2 AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Prodaux2 ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Prodaux2] = $row->Prodaux2;
        }

        return $array;
    }

	public function select_prodaux3() {

        $query = $this->db->query('
            SELECT
                P.idTab_Prodaux3,
                P.Prodaux3
            FROM
                Tab_Prodaux3 AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Prodaux3 ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Prodaux3] = $row->Prodaux3;
        }

        return $array;
    }

	public function select_prodaux4() {

        $query = $this->db->query('
            SELECT
                P.idTab_Prodaux4,
                P.Prodaux4
            FROM
                Tab_Prodaux4 AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Prodaux4 ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Prodaux4] = $row->Prodaux4;
        }

        return $array;
    }
	
	public function select_orcatrata() {

        $query = $this->db->query('
            SELECT
                CONCAT(P.idApp_OrcaTrata, " - ",C.NomeCliente) AS idApp_OrcaTrata,
                P.idApp_Cliente,
				C.NomeCliente
            FROM
                App_OrcaTrata AS P
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                idApp_OrcaTrata ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->idApp_OrcaTrata;
        }

        return $array;
    }

	public function select_obsorca() {

        $query = $this->db->query('
            SELECT
                P.idApp_OrcaTrata,
                P.ObsOrca
            FROM
                App_OrcaTrata AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                idApp_OrcaTrata ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->ObsOrca;
        }

        return $array;
    }
	
	public function select_servicos() {

        $query = $this->db->query('
            SELECT
                OB.idApp_Servicos,
                OB.Servicos
            FROM
                App_Servicos AS OB
            WHERE
                OB.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Servicos ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Servicos] = $row->Servicos;
        }

        return $array;
    }

	public function select_procedtarefa() {

        $query = $this->db->query('
            SELECT
                OB.idApp_SubProcedimento,
                OB.SubProcedimento
            FROM
                App_SubProcedimento AS OB
            WHERE
                OB.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OB.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                SubProcedimento ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_SubProcedimento] = $row->SubProcedimento;
        }

        return $array;
    }

	public function select_usuario() {

        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(F.Funcao,""), " --- ", IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY F.Funcao ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }

	public function select_orcarec() {

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
				idApp_OrcaTrata,
				idSis_Usuario,
				idSis_Empresa,
				idTab_TipoRD
			FROM
				App_OrcaTrata
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				idTab_TipoRD = "2"
			ORDER BY
				idApp_OrcaTrata
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->idApp_OrcaTrata;
        }

        return $array;
    }	

	public function select_orcades() {

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		
        $query = $this->db->query('
            SELECT
				idApp_OrcaTrata,
				idSis_Usuario,
				idSis_Empresa,
				idTab_TipoRD
			FROM
				App_OrcaTrata
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				idTab_TipoRD = "1"
			ORDER BY
				idApp_OrcaTrata
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
            $array[$row->idApp_OrcaTrata] = $row->idApp_OrcaTrata;
        }

        return $array;
    }	

}
