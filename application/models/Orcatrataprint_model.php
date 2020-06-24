<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrataprint_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function get_orcatrata($data) {
        $query = $this->db->query(
            'SELECT
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
				OT.ValorDev,
				OT.ValorDinheiro,
				OT.ValorTroco,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.QtdParcelasOrca,
				OT.DataVencimentoOrca,
				OT.idSis_Usuario,
				OT.ObsOrca,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.Tipo_Orca,
				FP.FormaPag,				
				EF.NomeEmpresa,
				MO.AVAP,
				MO.Abrev3,
				OT.Modalidade,
				MO.Modalidade,
				TP.TipoFinanceiro

            FROM           	
                Tab_FormaPag AS FP,
				App_OrcaTrata AS OT
				LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro				
				LEFT JOIN Tab_Modalidade AS MO ON MO.Abrev = OT.Modalidade


            WHERE
            	OT.idApp_OrcaTrata = ' . $data . ' AND
                OT.FormaPagamento = FP.idTab_FormaPag'
        );
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }

	public function get_servico1($data) {
		$query = $this->db->query('SELECT * FROM App_Servico WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

	public function get_servico($data) {
		$query = $this->db->query(
            'SELECT
            	PV.QtdServico,
				PV.DataValidadeServico,
				PV.ObsServico,
				PV.idApp_Servico,
				PV.idApp_OrcaTrata,
				PV.ConcluidoServico,
				P.UnidadeProduto,
				P.Cod_Prod,

				TCO.Convenio,
				V.Convdesc,
				TFO.NomeFornecedor,
				CONCAT(IFNULL(PV.idApp_Servico,""), " - " , IFNULL(PV.ConcluidoServico,""), " - Obs.: " , IFNULL(PV.ObsServico,"")) AS idApp_Servico,
				CONCAT(IFNULL(PV.QtdServico,""), " - " , IFNULL(P.UnidadeProduto,"")) AS QtdServico,
            	CONCAT(IFNULL(P.Cod_Prod,""), " -- ", IFNULL(P.Nome_Prod,"")) AS NomeServico,
            	PV.ValorServico
            FROM
            	App_Servico AS PV,
            	Tab_Valor AS V
            		LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor

            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
                PV.idTab_Servico = V.idTab_Valor AND
            	P.idTab_Produtos = V.idTab_Produtos
            ORDER BY
            	PV.idApp_Servico'
        );
        $query = $query->result_array();

        return $query;
    }

    public function get_produto($data) {
		$query = $this->db->query(
            'SELECT
            	PV.QtdProduto,
				PV.QtdIncremento,
				PV.DataValidadeProduto,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.idApp_OrcaTrata,
				PV.ConcluidoProduto,
				PV.DevolvidoProduto,
				P.UnidadeProduto,
				P.Cod_Prod,
				TCP.idTab_Cor_Prod,
				TCP.Nome_Cor_Prod,
				TTP.idTab_Tam_Prod,
				TTP.Nome_Tam_Prod,
				TPAX1.Prodaux1,
				TPAX2.Prodaux2,
				TCO.Convenio,
				V.Convdesc,
				TFO.NomeFornecedor,
				CONCAT(IFNULL(PV.QtdProduto,""), " X " , IFNULL(PV.QtdIncremento,""), " " , IFNULL(P.UnidadeProduto,"")) AS QtdProduto,
            	CONCAT(IFNULL(P.Cod_Prod,""), " - ", IFNULL(P.Nome_Prod,""), " - ", IFNULL(TPAX2.Prodaux2,""), " - ", IFNULL(TPAX1.Prodaux1,"")) AS NomeProduto,
            	PV.ValorProduto
            FROM
            	App_Produto AS PV,
            	Tab_Valor AS V
            		LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Cor_Prod AS TCP ON TCP.idTab_Cor_Prod = P.Cor_Prod_Aux2
					LEFT JOIN Tab_Prodaux2 AS TPAX2 ON TPAX2.idTab_Prodaux2 = TCP.Cor_Prod
					LEFT JOIN Tab_Tam_Prod AS TTP ON TTP.idTab_Tam_Prod = P.Tam_Prod_Aux1	
					LEFT JOIN Tab_Prodaux1 AS TPAX1 ON TPAX1.idTab_Prodaux1 = TTP.Tam_Prod					
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor

            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
                PV.idTab_Produto = V.idTab_Valor AND
            	P.idTab_Produtos = V.idTab_Produtos
            ORDER BY
            	PV.idApp_Produto'
        );
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelasrec($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }

}
