<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrataprintcomissao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function get_orcatrata($data) {
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
				'(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }
		
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		//$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao10 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] != "0" ) ? 'OT.StatusComissaoOrca = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['NomeUsuario'] != "0" ) ? 'OT.idSis_Usuario = "' . $_SESSION['FiltroAlteraParcela']['NomeUsuario'] . '" AND ' : FALSE;
		//$permissao20 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiroR'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiroR'] . '" AND ' : FALSE;
		
		//$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		//$permissao2 = ($_SESSION['FiltroAlteraParcela']['NomeCliente'] != "0" ) ? 'C.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] . '" AND ' : FALSE;
		$query = $this->db->query(
            'SELECT
				C.NomeCliente,
				C.CelularCliente,
				C.Telefone,
				C.Telefone2,
				C.Telefone3,
				C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
				C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
				OT.idSis_Empresa,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				OT.DataOrca,
				OT.DataPrazo,
				OT.DataConclusao,
				OT.DataQuitado,				
				OT.DataRetorno,
				OT.DataEntradaOrca,
				OT.idApp_Cliente,
				OT.idApp_Fornecedor,
				OT.ValorOrca,
				OT.ValorTotalOrca,
				OT.ValorDev,
				OT.ValorDinheiro,
				OT.ValorTroco,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.ValorComissao,
				OT.QtdParcelasOrca,
				OT.DataVencimentoOrca,
				OT.StatusComissaoOrca,
				OT.idSis_Usuario,
				OT.ObsOrca,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.Tipo_Orca,
				OT.FormaPagamento,
				FP.FormaPag,				
				EF.NomeEmpresa,
				MO.AVAP,
				MO.Abrev3,
				OT.Modalidade,
				MO.Modalidade,
				TP.TipoFinanceiro,
				PR.DataVencimento,
				US.Nome
            FROM
				App_OrcaTrata AS OT
				LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_Modalidade AS MO ON MO.Abrev = OT.Modalidade
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
            WHERE
            	' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao7 . '
				' . $permissao10 . '
				' . $permissao11 . '
				OT.idSis_Empresa = ' . $data . ' AND
                OT.idApp_Cliente = C.idApp_Cliente AND
				OT.idTab_TipoRD = "2" AND
				' . $consulta . '
			GROUP BY
                OT.idApp_OrcaTrata	
            ORDER BY
				OT.DataVencimentoOrca,
				OT.idApp_OrcaTrata		
        ');
        $query = $query->result_array();
		/*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query;
    }

    public function get_produto($data) {
		$query = $this->db->query('
			SELECT  
				PV.idSis_Empresa,
				PV.idApp_OrcaTrata,
				PV.idTab_Produto,
				PV.QtdProduto,
				PV.QtdIncrementoProduto,
				(PV.QtdProduto * PV.QtdIncrementoProduto) AS Qtd_Prod,
				PV.DataValidadeProduto,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.ConcluidoProduto,
				PV.DevolvidoProduto,
				PV.ValorProduto,
				PV.NomeProduto,
				TPS.Nome_Prod
			FROM 
				App_OrcaTrata AS OT,
				App_Produto AS PV
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = PV.idTab_Produtos_Produto
			WHERE 
				PV.idApp_OrcaTrata = OT.idApp_OrcaTrata AND
				PV.idSis_Empresa = ' . $data . ' 
            ORDER BY
            	PV.idApp_OrcaTrata DESC				
		
		');
        $query = $query->result_array();
		
		/*
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        */		
		
        return $query;
    }
	
    public function get_parcelasrec($data) {
		
        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
				'(PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }		
		
		$query = $this->db->query('
			SELECT  
				PR.idSis_Empresa,
				PR.idApp_OrcaTrata,
				PR.Parcela,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.DataPago,
				PR.Quitado
			FROM 
				App_OrcaTrata AS OT,
				App_Parcelas AS PR

			WHERE 
				PR.idApp_OrcaTrata = OT.idApp_OrcaTrata AND
				PR.idSis_Empresa = ' . $data . ' 
            ORDER BY
            	PR.DataVencimento ASC				
		
		');
        $query = $query->result_array();
		
		/*
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        */		
		
        return $query;
    }

    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idSis_Empresa = ' . $data);
        $query = $query->result_array();

        return $query;
    }

}
