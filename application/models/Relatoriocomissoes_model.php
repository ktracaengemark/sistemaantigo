<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatoriocomissoes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

	public function list_porservicos($data, $completo) {

		$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($data['DataInicio4']) ? 'PR.DataVencimento >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($data['DataFim4']) ? 'PR.DataVencimento <= "' . $data['DataFim4'] . '" AND ' : FALSE;
		
		$date_inicio_prd_entr = ($data['DataInicio8']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio8'] . '" AND ' : FALSE;
		$date_fim_prd_entr = ($data['DataFim8']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim8'] . '" AND ' : FALSE;
		
		$data['Funcionario'] = ($data['Funcionario']) ? ' AND (PRDS.ProfissionalProduto_1 = ' . $data['Funcionario'] . ' OR PRDS.ProfissionalProduto_2 = ' . $data['Funcionario'] . ' OR PRDS.ProfissionalProduto_3 = ' . $data['Funcionario'] . ' OR PRDS.ProfissionalProduto_4 = ' . $data['Funcionario'] . ' )' : FALSE;
		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;
		$data['Fornecedor'] = ($data['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $data['Fornecedor'] : FALSE;
		$data['Produtos'] = ($data['Produtos']) ? ' AND PRDS.idTab_Produtos_Produto = ' . $data['Produtos'] : FALSE;
		$data['Categoria'] = ($data['Categoria']) ? ' AND TCAT.idTab_Catprod = ' . $data['Categoria'] : FALSE;
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;
		$data['TipoFinanceiro'] = ($data['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
		$data['idTab_TipoRD'] = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] . ' AND PRDS.idTab_TipoRD = ' . $data['idTab_TipoRD'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro17 = ($data['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$groupby = (1 == 1) ? 'GROUP BY PRDS.idApp_Produto' : FALSE;
        $query = $this->db->query(
            'SELECT
				CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,""), " - " ,IFNULL(C.CelularCliente,""), " - " ,IFNULL(C.Telefone,""), " - " ,IFNULL(C.Telefone2,""), " - " ,IFNULL(C.Telefone3,"") ) AS NomeCliente,
				CONCAT(IFNULL(F.idApp_Fornecedor,""), " - " ,IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
                OT.idApp_OrcaTrata,
				OT.Tipo_Orca,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
                OT.CombinadoFrete,
				OT.ObsOrca,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.DataEntregaOrca,
                OT.DataVencimentoOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.Modalidade,
				TR.TipoFinanceiro,
				MD.Modalidade,
                PR.idApp_Parcelas,
                PR.idSis_Empresa,
				PR.idSis_Usuario,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.ValorPago,
                PR.Quitado,
				PR.idTab_TipoRD,
				PRDS.idApp_Produto,
				PRDS.idTab_TipoRD,
				PRDS.NomeProduto,
				PRDS.ValorProduto,
				PRDS.ComissaoProduto,
				PRDS.QtdProduto,
				PRDS.QtdIncrementoProduto,
				(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
				PRDS.ConcluidoProduto,
				PRDS.idTab_Produtos_Produto,
				PRDS.Prod_Serv_Produto,
				PRDS.DataConcluidoProduto,
				PRDS.HoraConcluidoProduto,
				
				PRDS.ProfissionalProduto_1,
				PRDS.ProfissionalProduto_2,
				PRDS.ProfissionalProduto_3,
				PRDS.ProfissionalProduto_4,
				
				UP1.Nome AS NomeProf1,
				UP2.Nome AS NomeProf2,
				UP3.Nome AS NomeProf3,
				UP4.Nome AS NomeProf4,
				
				TPRDS.idTab_Produtos,
				TPRDS.Nome_Prod,
				TCAT.idTab_Catprod,
				TCAT.Catprod,
				TAV.AVAP,
				TTF.TipoFrete,
				TFP.FormaPag
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
					
					LEFT JOIN Sis_Usuario AS UP1 ON UP1.idSis_Usuario = PRDS.ProfissionalProduto_1
					LEFT JOIN Sis_Usuario AS UP2 ON UP2.idSis_Usuario = PRDS.ProfissionalProduto_2
					LEFT JOIN Sis_Usuario AS UP3 ON UP3.idSis_Usuario = PRDS.ProfissionalProduto_3
					LEFT JOIN Sis_Usuario AS UP4 ON UP4.idSis_Usuario = PRDS.ProfissionalProduto_4
					
					LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
					LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
					LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
					LEFT JOIN Tab_AVAP AS TAV ON TAV.Abrev2 = OT.AVAP
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
            WHERE
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
                ' . $date_inicio_prd_entr . '
                ' . $date_fim_prd_entr . '
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				' . $filtro10 . '
				' . $filtro11 . '
				' . $filtro13 . '
				' . $filtro17 . '
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PRDS.Prod_Serv_Produto = "S" AND
                PRDS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['Fornecedor'] . '
				' . $data['TipoFinanceiro'] . '
				' . $data['idTab_TipoRD'] . '
                ' . $data['Produtos'] . '
                ' . $data['Categoria'] . '
				' . $data['Funcionario'] . '
                ' . $groupby . '
			ORDER BY
                OT.DataEntregaOrca,
				C.NomeCliente ASC,
				F.NomeFornecedor ASC
		');

        ####################################################################
        #SOMATÓRIO DAS Parcelas Recebidas
		
        $parcelasrecebidas = $this->db->query(
            'SELECT
                PR.ValorParcela,
				PRDS.idApp_Produto,
				PRDS.idTab_TipoRD,
				PRDS.NomeProduto,
				PRDS.ValorProduto,
				PRDS.ComissaoProduto,
				PRDS.QtdProduto,
				PRDS.QtdIncrementoProduto,
				(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
				PRDS.ConcluidoProduto,
				PRDS.idTab_Produtos_Produto,
				PRDS.Prod_Serv_Produto,
				PRDS.DataConcluidoProduto,
				PRDS.HoraConcluidoProduto,
				
				PRDS.ProfissionalProduto_1,
				PRDS.ProfissionalProduto_2,
				PRDS.ProfissionalProduto_3,
				PRDS.ProfissionalProduto_4,
				
				UP1.Nome AS NomeProf1,
				UP2.Nome AS NomeProf2,
				UP3.Nome AS NomeProf3,
				UP4.Nome AS NomeProf4,
				
				TPRDS.idTab_Produtos,
				TPRDS.Nome_Prod,
				TCAT.idTab_Catprod,
				TCAT.Catprod
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN App_Parcelas AS PR ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
					
					LEFT JOIN Sis_Usuario AS UP1 ON UP1.idSis_Usuario = PRDS.ProfissionalProduto_1
					LEFT JOIN Sis_Usuario AS UP2 ON UP2.idSis_Usuario = PRDS.ProfissionalProduto_2
					LEFT JOIN Sis_Usuario AS UP3 ON UP3.idSis_Usuario = PRDS.ProfissionalProduto_3
					LEFT JOIN Sis_Usuario AS UP4 ON UP4.idSis_Usuario = PRDS.ProfissionalProduto_4
					
					
					LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
					LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
					LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
            WHERE
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
                ' . $date_inicio_prd_entr . '
                ' . $date_fim_prd_entr . '			
				' . $permissao . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				' . $filtro10 . '
				' . $filtro11 . '
				' . $filtro13 . '
				' . $filtro17 . '
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PRDS.Prod_Serv_Produto = "S" AND
                PRDS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PRDS.ConcluidoProduto = "S"
				' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['Fornecedor'] . '
				' . $data['TipoFinanceiro'] . '	
				' . $data['idTab_TipoRD'] . '
                ' . $data['Produtos'] . '
                ' . $data['Categoria'] . '
                ' . $groupby . '	
 				
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

            $somacomissaoprof=$somacomissaototal=$diferenca=$somaentregar=$somaentregue=$somapago=$somapagar=$somaentrada=$somareceber=$somarecebido=$somapago=$somapagar=$somareal=$balanco=$ant=0;
            foreach ($query->result() as $row) {
				$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
                $row->DataEntradaOrca = $this->basico->mascara_data($row->DataEntradaOrca, 'barras');
                $row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
                $row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
                $row->DataVencimento = $this->basico->mascara_data($row->DataVencimento, 'barras');
                $row->DataPago = $this->basico->mascara_data($row->DataPago, 'barras');
                $row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
				$row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
                $row->DataConcluidoProduto = $this->basico->mascara_data($row->DataConcluidoProduto, 'barras');
				
				

				$somaentregar += $row->QuantidadeProduto;
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
				
				$contagem=0;
				for ($i = 1; $i <= 4; $i++) {
					$p = 'ProfissionalProduto_'.$i;
					if($row->$p != 0){
						$contagem++;
					}
				}
				
				$row->Contagem = $contagem;
				
				if($contagem == 0){
					//$row->Contagem = 'Ninguém';
					$divisor = 1;
					
				}else{
					//$row->Contagem = $contagem;
					$divisor = $contagem;
				}
				
				$valortotalproduto = $row->QtdProduto*$row->ValorProduto;
				$comissao_total = $valortotalproduto*$row->ComissaoProduto/100;
				$pro_prof = $comissao_total/$divisor;
				$somacomissaototal 	+= $comissao_total;
				$somacomissaoprof	+= $pro_prof;
				
				$row->ValorTotalProduto = number_format($valortotalproduto, 2, ',', '.');
				$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');
				$row->ComissaoProduto = number_format($row->ComissaoProduto, 2, ',', '.');
				$row->ComissaoTotal = number_format($comissao_total, 2, ',', '.');
				$row->ComissaoProf = number_format($pro_prof, 2, ',', '.');
                
				$somareceber += $row->ValorParcela;
				$row->ValorEntradaOrca = number_format($row->ValorEntradaOrca, 2, ',', '.');				
                $row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.'); 			
				
				if($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}elseif($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}else{
					$row->Tipo_Orca = "Outros";
				}				
				/*
				  echo $this->db->last_query();
				  echo "<pre>";
				  print_r($somaentrada);          
				  echo "</pre>";
				  exit();
				*/	
		  
            }
			
            foreach ($parcelasrecebidas as $row) {
				$somaentregue += $row->QuantidadeProduto;
                $somarecebido += $row->ValorParcela;
				$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');
            }			
			$diferenca =  $somaentregar - $somaentregue;
            $balanco =  $somareceber - $somarecebido;
			
			/*
			echo $this->db->last_query();
			echo "<pre>";
			print_r($balanco);
			echo "</pre>";
			exit();			
			*/
			
            $query->soma = new stdClass();
			//$query->soma->contagem = $contagem;
            $query->soma->somacomissaototal = number_format($somacomissaototal, 2, ',', '.');
            $query->soma->somacomissaoprof = number_format($somacomissaoprof, 2, ',', '.');
            $query->soma->diferenca = $diferenca;
            $query->soma->somaentregar = $somaentregar;
            $query->soma->somaentregue = $somaentregue;
            $query->soma->somareceber = number_format($somareceber, 2, ',', '.');
            $query->soma->somarecebido = number_format($somarecebido, 2, ',', '.');
            $query->soma->somaentrada = number_format($somaentrada, 2, ',', '.');
            $query->soma->balanco = number_format($balanco, 2, ',', '.');
			
            return $query;
        }

    }
		
}
