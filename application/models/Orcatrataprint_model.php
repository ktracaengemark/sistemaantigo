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
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.QtdParcelasOrca,
				OT.DataVencimentoOrca,
				OT.idSis_Usuario,
				OT.ObsOrca,
				OT.Descricao,
				OT.TipoFinanceiro,
				FP.FormaPag,				
				EF.NomeEmpresa,
				MO.AVAP,
				MO.Abrev3,
				MO.Modalidade,
				TP.TipoFinanceiro,
				FO.NomeFornecedor
            FROM           	
                Tab_FormaPag AS FP,
				App_OrcaTrata AS OT
				LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN Tab_Modalidade AS MO ON MO.Abrev2 = OT.AVAP
				LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN App_Fornecedor AS FO ON FO.idApp_Fornecedor = OT.idApp_Fornecedor
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
				P.UnidadeProduto,
				P.CodProd,
				TP3.Prodaux3,
				TP1.Prodaux1,
            	TP2.Prodaux2,
				TCO.Convenio,
				V.Convdesc,
				TFO.NomeFornecedor,
				CONCAT(IFNULL(PV.idApp_Servico,""), " - Obs.: " , IFNULL(PV.ObsServico,"")) AS idApp_Servico,
				CONCAT(IFNULL(PV.QtdServico,""), " - " , IFNULL(P.UnidadeProduto,"")) AS QtdServico,
            	CONCAT(IFNULL(P.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(P.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,"")) AS NomeServico,
            	PV.ValorServico
            FROM
            	App_Servico AS PV,
            	Tab_Valor AS V
            		LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
            		LEFT JOIN Tab_Produto AS P ON P.idTab_Produto = V.idTab_Produto
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
            		LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
            		LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
            		LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
                PV.idTab_Servico = V.idTab_Valor AND
            	P.idTab_Produto = V.idTab_Produto
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
				PV.DataValidadeProduto,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.idApp_OrcaTrata,
				P.UnidadeProduto,
				P.CodProd,
				TP3.Prodaux3,
				TP1.Prodaux1,
            	TP2.Prodaux2,
				TCO.Convenio,
				V.Convdesc,
				TFO.NomeFornecedor,
				CONCAT(IFNULL(PV.idApp_Produto,""), " - Obs.: " , IFNULL(PV.ObsProduto,"")) AS idApp_Produto,
				CONCAT(IFNULL(PV.QtdProduto,""), " - " , IFNULL(P.UnidadeProduto,"")) AS QtdProduto,
            	CONCAT(IFNULL(P.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(P.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,"")) AS NomeProduto,
            	PV.ValorProduto
            FROM
            	App_Produto AS PV,
            	Tab_Valor AS V
            		LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
            		LEFT JOIN Tab_Produto AS P ON P.idTab_Produto = V.idTab_Produto
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
            		LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
            		LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
            		LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
                PV.idTab_Produto = V.idTab_Valor AND
            	P.idTab_Produto = V.idTab_Produto
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
