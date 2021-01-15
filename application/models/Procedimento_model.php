<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Procedimento_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_procedimento($data) {

        $query = $this->db->insert('App_Procedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_procedimento($data) {
        $query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_Procedimento = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_subprocedimento($data) {
        $query = $this->db->query('SELECT * FROM App_SubProcedimento WHERE idApp_Procedimento = ' . $data);

        $query = $query->result_array();

        return $query;
    }
	
    public function update_procedimento($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Procedimento', $data, array('idApp_Procedimento' => $id));
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_procedimento($data) {

        $query = $this->db->query('SELECT* FROM App_Procedimento WHERE idApp_Procedimento = ' . $data);
        $query = $query->result_array();

        /*
        echo $this->db->last_query();
        #$query = $query->result();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";


        foreach ($query as $key) {
            /*
            echo $key['idApp_OrcaTrata'];
            echo '<br />';
            #echo $value;
            echo '<br />';
        }

        exit();

        */

        $this->db->delete('App_Procedimento', array('idApp_Procedimento' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_procedimento($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Procedimento WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
				. 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
                . '(Procedimento like "%' . $data . '%" OR '
                #. 'DataProcedimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'Procedimento like "%' . $data . '%" OR '
                . 'DataProcedimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
				. 'DataConcluidoProcedimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY Procedimento ASC ');
        /*
          echo $this->db->last_query();
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
                foreach ($query->result() as $row) {
                    $row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
                }

                return $query;
            }
        }
    }
	
	public function select_procedimento($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Procedimento,
				CONCAT(IFNULL(Procedimento, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Procedimento				
            FROM
                App_Procedimento					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY 
				Procedimento ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Procedimento,
				CONCAT(IFNULL(Procedimento, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Procedimento				
            FROM
                App_Procedimento					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
			ORDER BY 
				Procedimento ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Procedimento] = $row->Procedimento;
            }
        }

        return $array;
    }	

	public function select_compartilhar() {
		$query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS NomeUsuario
            FROM
				Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				F.Abrev ASC
        ');

        $array = array();
        //$array[50] = ':: O Próprio ::';
        //$array[51] = ':: Todos ::';
		$array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }
	
    public function set_orcatrata($data) {

        $query = $this->db->insert('App_Procedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_orcatrata_original($data) {
        $query = $this->db->query('
			SELECT 
				* 
			FROM 
				App_Procedimento 
			WHERE 
				idApp_Procedimento = ' . $data . '
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

        return $query[0];
    }
	
    public function get_orcatrata($data) {
        $query = $this->db->query('
			SELECT
				PC.*,
				PC.Compartilhar AS idCompartilhar,
				CT.*,
				CT.idTab_Categoria AS Categoria,
				CT.Categoria AS NomeCategoria,
				US.*,
				US.idSis_Usuario AS Compartilhar,
				US.CelularUsuario AS CelularCompartilhou,
				US.Nome AS NomeCompartilhar,
				USC.*,
				USC.idSis_Usuario AS idSis_Usuario,
				USC.CelularUsuario AS CelularCadastrou,
				USC.Nome AS NomeCadastrou
			FROM 
				App_Procedimento AS PC
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = PC.Categoria
					LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = PC.Compartilhar
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Procedimento = ' . $data . '
		');
		
		foreach ($query->result_array() as $row) {
			//$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
			//$row->DataProcedimentoLimite = $this->basico->mascara_data($row->DataProcedimentoLimite, 'barras');
			//$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
			//$row->ConcluidoSubProcedimento = $this->basico->mascara_palavra_completa2($row->ConcluidoSubProcedimento, 'NS');
			//$row->Prioridade = $this->basico->prioridade($row->Prioridade, '123');
			//$row->SubPrioridade = $this->basico->prioridade($row->SubPrioridade, '123');
			//$row->Statustarefa = $this->basico->statustrf($row->Statustarefa, '123');
			//$row->Statussubtarefa = $this->basico->statustrf($row->Statussubtarefa, '123');
			
			if($row['Compartilhar'] == 0){
				$row['NomeCompartilhar'] = 'TODOS';
			}
			
		}
		
		//$query = $query->result_array();		
		
		/*
        echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($row);
        echo '<br>';
        print_r($row['Compartilhar']);
        echo '<br>';
        print_r($row['NomeCompartilhar']);
        echo "</pre>";
        exit ();
       */

		return $row;
        //return $query[0];
    }	
	
    public function get_procedimento_empresa($data, $completo) {
		/*
		if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
				'(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim2']) {
            $consulta2 =
				'(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '")';
        }

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
		
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '" AND ' : FALSE;
		$permissao36 = ($_SESSION['FiltroAlteraParcela']['Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] . '" AND ' : FALSE;
		$permissao35 = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] != "" ) ? 'OT.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND PR.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND' : FALSE;
		
		$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao60 = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroAlteraParcela']['Campo'];
        $permissao61 = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
		*/
		
		$data['TipoProcedimento'] = $data['TipoProcedimento'];
		$data['idApp_Procedimento'] = ($_SESSION['FiltroAlteraParcela']['idApp_Procedimento'] != "" ) ? ' AND PRC.idApp_Procedimento = ' . $_SESSION['FiltroAlteraParcela']['idApp_Procedimento'] . '  ': FALSE;
		
		/*
        echo '<br>';
        echo "<pre>";
        print_r($data['idSis_Empresa']);
		echo '<br>';
        print_r($data['TipoProcedimento']);
        echo "</pre>";
        exit ();
       	*/	
		
		$query = $this->db->query(
            'SELECT
				PRC.*,
				SPRC.*,
				C.*,
				EMP.*
				
            FROM 
				App_Procedimento AS PRC
				LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = PRC.idSis_Empresa
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
				LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = PRC.idApp_Fornecedor
				LEFT JOIN App_SubProcedimento AS SPRC ON SPRC.idApp_Procedimento = PRC.idApp_Procedimento
            WHERE
				PRC.idSis_Empresa = ' . $data['idSis_Empresa'] . ' AND
				SPRC.idSis_Empresa = ' . $data['idSis_Empresa'] . ' AND
				PRC.TipoProcedimento = ' . $data['TipoProcedimento'] . '
				' . $data['idApp_Procedimento'] . '
			GROUP BY
                PRC.idApp_Procedimento		
        ');
        

		$query = $query->result_array();
       /*
        echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
       */
        return $query;
    }

    public function get_subprocedimento_empresa($data) {
		$query = $this->db->query('SELECT * FROM App_SubProcedimento WHERE idSis_Empresa = ' . $data['idSis_Empresa']);
        $query = $query->result_array();

        return $query;
    }	
	
    public function list_procedimento($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
			. 'PRC.Marketing, '
			. 'PRC.Sac, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 0 AND '
            . '(PRC.Sac = 0 OR PRC.Sac = 1) AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        }
    }

    public function list_informacao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
			. 'PRC.Marketing, '
			. 'PRC.Sac, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 0 AND '
            . '(PRC.Sac = 0 OR PRC.Sac = 1) AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
				
                return $query;
            }
        
    }

    public function list_elogio($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
			. 'PRC.Sac, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Sac = 2 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }

    public function list_reclamacao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
			. 'PRC.Sac, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Sac = 3 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
       
    }
			
    public function list_procedimento_orc($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata != 0 AND '
            . 'PRC.Marketing = 0 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
       
    }
	
    public function list_orcamento($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Procedimento, '
			. 'OT.idApp_OrcaTrata, '
            . 'OT.DataProcedimento, '
			. 'OT.DataConcluidoProcedimento, '
			. 'OT.ConcluidoProcedimento, '
            . 'OT.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $id . ' AND '
            . 'OT.ConcluidoProcedimento = "' . $aprovado . '" '
            . 'ORDER BY '
			. 'OT.ConcluidoProcedimento ASC, '
			. 'OT.DataProcedimento DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        }
    }

    public function list_atualizacao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 1 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }

    public function list_pesquisa($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 2 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_retorno($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 3 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_promocao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 4 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }
	
    public function list_felicitacao($id, $concluido, $completo) {

        $query = $this->db->query('SELECT '
            . 'PRC.idApp_Procedimento, '
			. 'PRC.idApp_OrcaTrata, '
			. 'PRC.Marketing, '
            . 'PRC.DataProcedimento, '
			. 'PRC.DataConcluidoProcedimento, '
			. 'PRC.ConcluidoProcedimento, '
            . 'PRC.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS PRC '
            . 'WHERE '
            . 'PRC.idApp_Cliente = ' . $id . ' AND '
            . 'PRC.idApp_OrcaTrata = 0 AND '
            . 'PRC.Marketing = 5 AND '
            . 'PRC.ConcluidoProcedimento = "' . $concluido . '" '
            . 'ORDER BY '
			. 'PRC.ConcluidoProcedimento ASC, '
			. 'PRC.DataProcedimento DESC ');
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
					$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
					$row->DataConcluidoProcedimento = $this->basico->mascara_data($row->DataConcluidoProcedimento, 'barras');
					$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                }
                return $query;
            }
        
    }
			
    public function update_orcatrata($data, $id) {

        unset($data['idApp_Procedimento']);
        $query = $this->db->update('App_Procedimento', $data, array('idApp_Procedimento' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_orcatrata($id) {

        $query = $this->db->delete('App_Procedimento', array('idApp_Procedimento' => $id));
        $query = $this->db->delete('App_SubProcedimento', array('idApp_Procedimento' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }

	public function select_Marketing() {
		$query = $this->db->query('
            SELECT
                C.idTab_Marketing,
                C.Marketing
            FROM
                Tab_Marketing AS C
            ORDER BY
                C.idTab_Marketing ASC
        ');

        $array = array();	
        foreach ($query->result() as $row) {
            $array[$row->idTab_Marketing] = $row->Marketing;
        }

        return $array;
    }

	public function select_titulo() {
		$query = $this->db->query('
            SELECT
                C.idTab_Titulo,
                C.Titulo
            FROM
                Tab_Titulo AS C
            WHERE
				C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
            ORDER BY
                C.Titulo ASC
        ');

        $array = array();	
        foreach ($query->result() as $row) {
            $array[$row->idTab_Titulo] = $row->Titulo;
        }

        return $array;
    }
		
}
