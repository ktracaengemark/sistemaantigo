<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
		$this->load->model(array('Basico_model'));
    }

    public function resumo_estatisticas($data) {

        $query = $this->db->query('SELECT 
                C.idTab_Status, 
                COUNT(*) AS Total 
            FROM
                App_Agenda AS A, 
                App_Consulta AS C 
            WHERE 
                YEAR(DataInicio) = ' . date('Y', time()) . ' AND MONTH(DataInicio) = ' . date('m', time()) . ' AND
                C.Evento IS NULL AND 
                C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND 
                A.idSis_Usuario = ' . $data . ' AND 
                A.idApp_Agenda = C.idApp_Agenda 
            GROUP BY C.idTab_Status
            ORDER BY C.idTab_Status ASC');
        //$query = $query->result_array();
        if ($query->num_rows() !== 0) {

            foreach ($query->result() as $row) {
                $array[$row->idTab_Status] = $row->Total;
            }
            return $array;
        } else
            return FALSE;
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($array);
          echo "</pre>";
          exit ();
         */

        //if ($array->num_rows() === 0)
        //    return FALSE;
        //else
    }

    public function cliente_aniversariantes($data) {

        $query = $this->db->query('
            SELECT 
                idApp_Cliente, 
                NomeCliente,
                DataNascimento,

				Telefone1				
            FROM 
                App_Cliente
            WHERE 

                (MONTH(DataNascimento) = ' . date('m', time()) . ')
            ORDER BY 
				NomeCliente ASC');

        /*
		
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */

        if ($query->num_rows() === 0)
            return FALSE;
        else {

            foreach ($query->result() as $row) {
				$row->Idade = $this->basico->calcula_idade($row->DataNascimento);
            }            
            return $query;
        }
    }

	public function procedimento($data) {

		$query = $this->db->query('
            SELECT
				U.CpfUsuario,
				U.idSis_Usuario,
				U.Nome,
				U.NomeEmpresa,
				P.idSis_Empresa,
				P.idApp_Procedimento,
                P.idApp_OrcaTrata,
				P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento
            FROM
				Sis_Usuario AS U
					LEFT JOIN App_Procedimento AS P ON P.idSis_Usuario = U.idSis_Usuario
            WHERE 
				U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' AND
				P.ConcluidoProcedimento = "N" AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0"
            ORDER BY
                P.DataProcedimento ASC
        ');

        if ($query->num_rows() === FALSE) {
            return TRUE;
        }else {

            foreach ($query->result() as $row) {
				$row->Idade = $this->basico->calcula_idade($row->DataProcedimento);
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
            }
            return $query;
        }

    }	

	public function procedimentoenv($data) {
   
		$query = $this->db->query('
            SELECT
				C.NomeCliente,
				E.NomeEmpresa,
				UE.Nome AS NomeEnv,
				UR.Nome AS NomeRes,
				P.idApp_Procedimento,
                P.idApp_OrcaTrata,
				P.idApp_Cliente,
				P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento,
				P.idSis_EmpresaCli,
				P.ProcedimentoCli,
				P.DataProcedimentoCli,
				P.ConcluidoProcedimentoCli
            FROM
				App_Procedimento AS P
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
            WHERE 
				P.idSis_EmpresaCli = ' . $_SESSION['log']['idSis_Empresa'] . ' 

            ORDER BY
                P.DataProcedimentoCli ASC
        ');

        if ($query->num_rows() === FALSE) {
            return TRUE;
        }else {

            foreach ($query->result() as $row) {
				$row->Idade = $this->basico->calcula_idade($row->DataProcedimento);
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
				$row->DataProcedimentoCli = $this->basico->mascara_data($row->DataProcedimentoCli, 'barras');
				$row->ConcluidoProcedimentoCli = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimentoCli, 'NS');
            }
            return $query;
        }

    }

	public function procedimentorec($data) {
   
		$query = $this->db->query('
            SELECT
				C.NomeCliente,
				E.NomeEmpresa,
				UE.Nome AS NomeEnv,
				UR.Nome AS NomeRes,
				P.idApp_Procedimento,
                P.idApp_OrcaTrata,
				P.idApp_Cliente,
				P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento,
				P.idSis_EmpresaCli,
				P.ProcedimentoCli,
				P.DataProcedimentoCli,
				P.ConcluidoProcedimentoCli
            FROM
				App_Procedimento AS P
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
            WHERE 
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idSis_EmpresaCli != "0"

            ORDER BY
                P.DataProcedimentoCli ASC
        ');

        if ($query->num_rows() === FALSE) {
            return TRUE;
        }else {

            foreach ($query->result() as $row) {
				$row->Idade = $this->basico->calcula_idade($row->DataProcedimento);
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
				$row->DataProcedimentoCli = $this->basico->mascara_data($row->DataProcedimentoCli, 'barras');
				$row->ConcluidoProcedimentoCli = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimentoCli, 'NS');
            }
            return $query;
        }

    }	

    public function contatocliente_aniversariantes($data) {

        $query = $this->db->query('
            SELECT 
                D.idApp_Cliente, 
                D.idApp_ContatoCliente,
                D.NomeContatoCliente,
                D.DataNascimento,
				D.Telefone1
            FROM 
                App_ContatoCliente AS D,
                App_Cliente AS R
            WHERE               
				R.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                (MONTH(D.DataNascimento) = ' . date('m', time()) . ') AND
                R.idApp_Cliente = D.idApp_Cliente            
            ORDER BY 
				NomeContatoCliente ASC');

        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */

        if ($query->num_rows() === 0)
            return FALSE;
        else {

            foreach ($query->result() as $row) {
                $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
            }
            return $query;
        }
    }

	public function select_usuario() {
		
        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				P.CpfUsuario,
				CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(P.Nome,"")) AS NomeUsuario
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
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idSis_Usuario] = $row->NomeUsuario;
        }

        return $array;
    }
	
	public function select_usuario1() {
		
        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				P.CpfUsuario,
				CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(P.Nome,"")) AS NomeUsuario
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
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->CpfUsuario] = $row->NomeUsuario;
        }

        return $array;
    }	
	
    public function select_status_sn1() {

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                CONCAT(IFNULL(C.NomeCliente, ""), " --- ", IFNULL(C.Telefone1, ""), " --- ", IFNULL(C.Telefone2, ""), " --- ", IFNULL(C.Telefone3, "")) As NomeCliente
            FROM
                App_Cliente AS C

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                C.NomeCliente ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Cliente] = $row->NomeCliente;
        }

        return $array;
    }
	
	public function select_status_sn($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
			$array[0] = 'TODOS';
			foreach ($query->result() as $row) {
			$array[$row->Abrev] = $row->StatusSN;
			
            }
        }

        return $array;
    }

	public function list1_procedimento($data, $completo) {

		$data['Dia'] = ($data['Dia']) ? ' AND DAY(P.DataProcedimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(P.DataProcedimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(P.DataProcedimento) = ' . $data['Ano'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.DataProcedimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro10 = ($data['ConcluidoProcedimento'] != '#') ? 'P.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;

		$query = $this->db->query('
            SELECT
				E.NomeEmpresa,
				U.idSis_Usuario,
				U.CpfUsuario,
				P.idSis_Empresa,
				P.idApp_Procedimento,
                P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" AND
				P.idSis_EmpresaCli = "0" AND
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

	public function list2_procedimentocli($data, $completo) {

		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Dia'] = ($data['Dia']) ? ' AND DAY(P.DataProcedimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(P.DataProcedimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(P.DataProcedimento) = ' . $data['Ano'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.DataProcedimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro10 = ($data['ConcluidoProcedimento'] != '#') ? 'P.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;

		$query = $this->db->query('
            SELECT
				C.idApp_Cliente,
				C.NomeCliente,
				U.idSis_Usuario,
				U.CpfUsuario,
				P.idSis_Empresa,
				P.idApp_Procedimento,
                P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_EmpresaCli = "0" AND
				P.idApp_Cliente != "0" AND
				' . $filtro10 . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                ' . $data['NomeCliente'] . '
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

    public function select_cliente() {

        $query = $this->db->query('
            SELECT
                C.idApp_Cliente,
                CONCAT(IFNULL(C.NomeCliente, ""), " --- ", IFNULL(C.Telefone1, ""), " --- ", IFNULL(C.Telefone2, ""), " --- ", IFNULL(C.Telefone3, "")) As NomeCliente
            FROM
                App_Cliente AS C

            WHERE
                C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                C.NomeCliente ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Cliente] = $row->NomeCliente;
        }

        return $array;
    }
	
/*	
	public function profissional_aniversariantes($data) {

        $query = $this->db->query('
            SELECT 
                idApp_Profissional, 
                NomeProfissional,
                DataNascimento,
				Telefone1
            FROM 
                app.App_Profissional
            WHERE 
                idSis_Usuario = ' . $data . ' AND 
                (MONTH(DataNascimento) = ' . date('m', time()) . ')
            ORDER BY DAY(DataNascimento) ASC');

        
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         

        if ($query->num_rows() === 0)
            return FALSE;
        else {

            foreach ($query->result() as $row) {
                $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
            }            
            return $query;
        }
        
    }
*/	
/*	
	public function contatoprof_aniversariantes($data) {

        $query = $this->db->query('
            SELECT 
                D.idApp_Profissional, 
                D.idApp_ContatoProf,
                D.NomeContatoProf,
                D.DataNascimento,
				D.TelefoneContatoProf
            FROM 
                app.App_ContatoProf AS D,
                app.App_Profissional AS R
            WHERE 
                R.idSis_Usuario = ' . $data . ' AND 
                (MONTH(D.DataNascimento) = ' . date('m', time()) . ') AND
                R.idApp_Profissional = D.idApp_Profissional            
            ORDER BY DAY(D.DataNascimento) ASC');

        
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         

        if ($query->num_rows() === 0)
            return FALSE;
        else {

            foreach ($query->result() as $row) {
                $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
            }
            return $query;
        }
    }
*/
}
