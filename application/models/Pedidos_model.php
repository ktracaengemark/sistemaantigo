<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }
	
    public function list_pedidos_combinar($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
		'(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca  <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $data['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '" AND PR.DataVencimento <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '")';
        }		
		
		//$data['Orcamento'] = ($data['Orcamento']) ? ' OT.idApp_OrcaTrata = ' . $data['Orcamento'] . ' AND ' : FALSE;
        //$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        //$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['selecione'] = $data['selecione'];
		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        
		$query = $this->db->query('
			' . $data['selecione'] . '
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . ' AND
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
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
                $row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
                $row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				
				if($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}elseif($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}else{
					$row->Tipo_Orca = "Outros";
				}
            }
            return $query;
        }		

    }

    public function list_pedidos_aprovar($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
		'(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca  <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $data['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '" AND PR.DataVencimento <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '")';
        }		
		
		//$data['Orcamento'] = ($data['Orcamento']) ? ' OT.idApp_OrcaTrata = ' . $data['Orcamento'] . ' AND ' : FALSE;
        //$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        //$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['selecione'] = $data['selecione'];
		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
        
		$query = $this->db->query('
			' . $data['selecione'] . '
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . ' AND
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
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
                $row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
                $row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				
				if($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}elseif($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}else{
					$row->Tipo_Orca = "Outros";
				}
            }
            return $query;
        }		

    }	
	
    public function list_pedidos_producao($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
		'(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca  <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $data['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '" AND PR.DataVencimento <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '")';
        }		
		
		//$data['Orcamento'] = ($data['Orcamento']) ? ' OT.idApp_OrcaTrata = ' . $data['Orcamento'] . ' AND ' : FALSE;
        //$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        //$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['selecione'] = $data['selecione'];
		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        $query = $this->db->query('
			' . $data['selecione'] . '
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . ' AND
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" AND
				OT.ProntoOrca = "N" AND
				PRD.ConcluidoProduto = "N" 
				
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
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
                $row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
                $row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				
				if($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}elseif($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}else{
					$row->Tipo_Orca = "Outros";
				}
            }
            return $query;
        }		
		
    }

    public function list_pedidos_envio($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
		'(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca  <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $data['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '" AND PR.DataVencimento <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '")';
        }		
		
		//$data['Orcamento'] = ($data['Orcamento']) ? ' OT.idApp_OrcaTrata = ' . $data['Orcamento'] . ' AND ' : FALSE;
        //$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        //$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['selecione'] = $data['selecione'];
		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        $query = $this->db->query('
			' . $data['selecione'] . '
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . ' AND
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" AND
				OT.ProntoOrca = "S" AND
				OT.EnviadoOrca = "N" AND
				PRD.ConcluidoProduto = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
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
                $row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
                $row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				
				if($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}elseif($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}else{
					$row->Tipo_Orca = "Outros";
				}
            }
            return $query;
        }		

    }

    public function list_pedidos_entrega($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
		'(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca  <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $data['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '" AND PR.DataVencimento <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '")';
        }		
		
		//$data['Orcamento'] = ($data['Orcamento']) ? ' OT.idApp_OrcaTrata = ' . $data['Orcamento'] . ' AND ' : FALSE;
        //$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        //$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['selecione'] = $data['selecione'];
		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        $query = $this->db->query('
			' . $data['selecione'] . '
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . ' AND
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				
				OT.ConcluidoOrca = "N" AND
				PRD.ConcluidoProduto = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
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
                $row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
                $row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				
				if($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}elseif($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}else{
					$row->Tipo_Orca = "Outros";
				}
            }
            return $query;
        }		

    }

    public function list_pedidos_pagamento($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
		'(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca  <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $data['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '" AND PR.DataVencimento <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '")';
        }		
		
		//$data['Orcamento'] = ($data['Orcamento']) ? ' OT.idApp_OrcaTrata = ' . $data['Orcamento'] . ' AND ' : FALSE;
        //$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        //$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['selecione'] = $data['selecione'];
		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        $query = $this->db->query('
			' . $data['selecione'] . '
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . ' AND
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AprovadoOrca = "S" AND
				OT.QuitadoOrca = "N"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				PR.DataVencimento ASC
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
                $row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
                $row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				
				if($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}elseif($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}else{
					$row->Tipo_Orca = "Outros";
				}
            }
            return $query;
        }		

    }
	
    public function list_pedidos_pagonline($data, $completo) {
		
        if ($data['DataFim']) {
            $consulta =
		'(OT.DataOrca >= "' . $data['DataInicio'] . '" AND OT.DataOrca  <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $data['DataInicio'] . '")';
        }

        if ($data['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $data['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $data['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '")';
        }

        if ($data['DataFim3']) {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '" AND PR.DataVencimento <= "' . $data['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(PR.DataVencimento >= "' . $data['DataInicio3'] . '")';
        }		
		
		//$data['Orcamento'] = ($data['Orcamento']) ? ' OT.idApp_OrcaTrata = ' . $data['Orcamento'] . ' AND ' : FALSE;
        //$data['Campo'] = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
        //$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$data['selecione'] = $data['selecione'];
		$data['Orcamento'] = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;
		$data['Cliente'] = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] : FALSE;		
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Mespag'] = ($data['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $data['Mespag'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $data['Ano'] : FALSE;		
		$data['TipoFinanceiroR'] = ($data['TipoFinanceiroR']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiroR'] : FALSE;
		$data['ObsOrca'] = ($data['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $data['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($data['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcarec'] : FALSE;
		$data['Campo'] = (!$data['Campo']) ? 'PR.DataVencimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
        $filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

        $query = $this->db->query('
			' . $data['selecione'] . '
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $consulta . ' AND
				' . $consulta2 . ' AND
				' . $consulta3 . ' AND
				' . $permissao . '
				' . $filtro4 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "S"
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
			GROUP BY
                OT.idApp_OrcaTrata
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
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
                $row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
				$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
				$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
				$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                $row->Quitado = $this->basico->mascara_palavra_completa($row->Quitado, 'NS');
                $row->ConcluidoProduto = $this->basico->mascara_palavra_completa($row->ConcluidoProduto, 'NS');
				
				if($row->Tipo_Orca == "O"){
					$row->Tipo_Orca = "On Line";
				}elseif($row->Tipo_Orca == "B"){
					$row->Tipo_Orca = "Na Loja";
				}else{
					$row->Tipo_Orca = "Outros";
				}
            }
            return $query;
        }		

    }
	
}
