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
				
				OT.Cep,
				OT.Logradouro,
				OT.Numero,
				OT.Complemento,
				OT.Bairro,
				OT.Cidade,
				OT.Estado,
				OT.Referencia,
				
				OT.NomeRec,
				OT.TelefoneRec,
				OT.ParentescoRec,
				OT.ObsEntrega,
				OT.Aux1Entrega,
				OT.Aux2Entrega,

				OT.PrazoEntrega,
				OT.ValorTotalOrca,
				OT.ValorFrete,
				OT.CombinadoFrete,
				TF.TipoFrete,
				OT.FinalizadoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
				SU.Nome AS Entregador,
				
				OT.DataOrca,
				OT.DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataPrazo,
				OT.DataConclusao,
				OT.DataQuitado,				
				OT.DataRetorno,
				OT.DataEntradaOrca,
				OT.idApp_Cliente,
				OT.idApp_Fornecedor,
				OT.ValorOrca,
				OT.ValorDev,
				OT.QtdPrdOrca,
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
				
				EF.Cnpj,
				EF.CepEmpresa,
				EF.EnderecoEmpresa,
				EF.NumeroEmpresa,
				EF.ComplementoEmpresa,
				EF.BairroEmpresa,
				EF.MunicipioEmpresa,
				EF.EstadoEmpresa,
				
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
				LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
				LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = OT.Entregador

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
				TOP2.Opcao,
				TOP1.Opcao,
				TCO.Convenio,
				V.Convdesc,
				TFO.NomeFornecedor,
				SU.Nome,
				CONCAT(IFNULL(PV.idApp_Servico,""), " - " , IFNULL(PV.ConcluidoServico,""), " - Obs.: " , IFNULL(PV.ObsServico,"")) AS idApp_Servico,
				CONCAT(IFNULL(PV.QtdServico,"")) AS QtdServico,
            	CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TPM.Promocao,""), " - ", IFNULL(SU.Nome,"")) AS NomeServico,
            	PV.ValorServico
				
            FROM
            	App_Servico AS PV
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = PV.ProfissionalServico
            		LEFT JOIN Tab_Valor AS V ON V.idTab_Valor = PV.idTab_Servico
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
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
				PV.QtdIncrementoProduto,
				(PV.QtdProduto * PV.QtdIncrementoProduto) AS SubTotalQtd,
				PV.DataValidadeProduto,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.idApp_OrcaTrata,
				PV.ConcluidoProduto,
				PV.DevolvidoProduto,
				P.UnidadeProduto,
				P.Cod_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				TCO.Convenio,
				V.Convdesc,
				TFO.NomeFornecedor,
				CONCAT(IFNULL(PV.QtdProduto,""), " X " , IFNULL(PV.QtdIncrementoProduto,"")) AS QtdProduto,
            	CONCAT(IFNULL(P.Nome_Prod,""), " - ",  IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(V.Convdesc,"")) AS NomeProduto,
            	PV.ValorProduto
				FROM
            	App_Produto AS PV,
            	Tab_Valor AS V
            		LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2					
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

    public function get_produto_desp($data) {
		$query = $this->db->query(
            'SELECT
            	PV.QtdProduto,
				PV.QtdIncrementoProduto,
				(PV.QtdProduto * PV.QtdIncrementoProduto) AS SubTotalQtd,
				PV.DataValidadeProduto,
				PV.ObsProduto,
				PV.idApp_Produto,
				PV.idApp_OrcaTrata,
				PV.ConcluidoProduto,
				PV.DevolvidoProduto,
				P.UnidadeProduto,
				P.Cod_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				TFO.NomeFornecedor,
				CONCAT(IFNULL(PV.QtdProduto,""), " X " , IFNULL(PV.QtdIncrementoProduto,"")) AS QtdProduto,
            	CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,"")) AS NomeProduto,
            	PV.ValorProduto
            FROM
            	App_Produto AS PV
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = PV.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2					
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor

            WHERE
            	PV.idApp_OrcaTrata = ' . $data . ' AND
                PV.idTab_Produto = P.idTab_Produtos
            ORDER BY
            	PV.idApp_Produto'
        );
        $query = $query->result_array();

        return $query;
    }

	public function get_servico_desp($data) {
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
				TOP2.Opcao,
				TOP1.Opcao,
				TFO.NomeFornecedor,
				SU.Nome,
				CONCAT(IFNULL(PV.idApp_Servico,""), " - " , IFNULL(PV.ConcluidoServico,""), " - Obs.: " , IFNULL(PV.ObsServico,"")) AS idApp_Servico,
				CONCAT(IFNULL(PV.QtdServico,"")) AS QtdServico,
            	CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(SU.Nome,"")) AS NomeServico,
            	PV.ValorServico
            FROM
            	App_Servico AS PV
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = PV.ProfissionalServico
            		LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = PV.idTab_Servico
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
            		LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
            WHERE
            	PV.idApp_OrcaTrata = ' . $data . '
            ORDER BY
            	PV.idApp_Servico'
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
