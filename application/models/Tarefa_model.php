<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_tarefa($data) {

        $query = $this->db->insert('App_Procedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_procedtarefa($data) {

        $query = $this->db->insert_batch('App_SubProcedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_tarefa($data) {
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

    public function get_procedtarefa($data) {
		$query = $this->db->query('
			SELECT 
				PC.*,
				USC.*,
				USC.idSis_Usuario AS idSis_Usuario,
				USC.CelularUsuario AS CelularCadastrou,
				USC.Nome AS NomeCadastrou
				
			FROM 
				App_SubProcedimento AS PC
					LEFT JOIN Sis_Usuario AS USC ON USC.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_Procedimento = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }


    public function get_procedtarefa_posterior($data) {
		$query = $this->db->query('
			SELECT 
				PC.*
			FROM 
				App_SubProcedimento AS PC
			WHERE 
				PC.idApp_Procedimento = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function list_tarefa($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idApp_Procedimento,
                TF.DataProcedimento,
    			TF.DataProcedimentoLimite,
				TF.Prioridade,
				TF.Statustarefa,
				TF.Rotina,
                TF.ProfissionalProcedimento,
                TF.ConcluidoProcedimento,
                TF.Procedimento
            FROM
                App_Procedimento AS TF
            WHERE
                TF.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
                TF.ConcluidoProcedimento = "' . $aprovado . '"
            ORDER BY
                TF.ProfissionalProcedimento ASC,
				TF.Rotina DESC,				
				TF.Prioridade DESC,
				TF.DataProcedimentoLimite ASC
				
        ');
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
					$row->DataProcedimentoLimite = $this->basico->mascara_data($row->DataProcedimentoLimite, 'barras');
                    $row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
					$row->Rotina = $this->basico->mascara_palavra_completa($row->Rotina, 'NS');
					#$row->Prioridade = $this->basico->mascara_palavra_completa($row->Prioridade, 'NS');
                    $row->ProfissionalProcedimento = $this->get_profissional($row->ProfissionalProcedimento);
                }
                return $query;
            }
        }
    }

    public function list_tarefaBKP($x) {

        $query = $this->db->query('SELECT '
            . 'TF.idApp_Procedimento, '
            . 'TF.DataProcedimento, '
			. 'TF.DataProcedimentoLimite, '
            . 'TF.ProfissionalProcedimento, '
            . 'TF.ConcluidoProcedimento, '
            . 'TF.Procedimento '
            . 'FROM '
            . 'App_Procedimento AS TF '
            . 'WHERE '
            #. 'TF.idApp_Cliente = ' . $_SESSION['Procedimento']['idApp_Cliente'] . ' '
            . 'ORDER BY TF.DataProcedimento ASC ');
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
					$row->DataProcedimentoLimite = $this->basico->mascara_data($row->DataProcedimentoLimite, 'barras');
                    $row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
                    $row->ProfissionalProcedimento = $this->get_profissional($row->ProfissionalProcedimento);
                }

                return $query;
            }
        }
    }

    public function update_tarefa($data, $id) {

        unset($data['idApp_Procedimento']);
        $query = $this->db->update('App_Procedimento', $data, array('idApp_Procedimento' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_procedtarefa($data) {

        $query = $this->db->update_batch('App_SubProcedimento', $data, 'idApp_SubProcedimento');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_procedtarefa($data) {

        $this->db->where_in('idApp_SubProcedimento', $data);
        $this->db->delete('App_SubProcedimento');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_tarefa($id) {

        /*
        $tables = array('App_ServicoVenda', 'App_ProdutoVenda', 'App_ParcelasRecebiveis', 'App_SubProcedimento', 'App_Procedimento');
        $this->db->where('idApp_Procedimento', $id);
        $this->db->delete($tables);
        */

        #$query = $this->db->delete('App_ServicoVenda', array('idApp_Procedimento' => $id));
        #$query = $this->db->delete('App_ProdutoVenda', array('idApp_Procedimento' => $id));
        #$query = $this->db->delete('App_ParcelasRecebiveis', array('idApp_Procedimento' => $id));
        $query = $this->db->delete('App_SubProcedimento', array('idApp_Procedimento' => $id));
        $query = $this->db->delete('App_Procedimento', array('idApp_Procedimento' => $id));

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

	public function select_categoria() {
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
        foreach ($query->result() as $row) {
            $array[$row->idTab_Categoria] = $row->Categoria;
        }

        return $array;
    }
	
}
