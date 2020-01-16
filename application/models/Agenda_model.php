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

				CelularCliente				
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
				U.CelularUsuario,
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
				U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' AND
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

	public function procedempresa($data) {
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
		$query = $this->db->query('
            SELECT
				C.NomeCliente,
				EE.NomeEmpresa AS NomeEmpresaCli,
				ER.NomeEmpresa AS NomeEmpresa,
				UE.Nome AS NomeCli,
				UR.Nome AS Nome,
				P.idSis_Empresa,
				P.idSis_EmpresaCli,
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
					LEFT JOIN Sis_Empresa AS EE ON EE.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Empresa AS ER ON ER.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
            WHERE 
				(P.idSis_EmpresaCli = ' . $_SESSION['log']['idSis_Empresa'] . ' OR
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' ) AND
				' . $permissao . '
				P.idSis_EmpresaCli != "0" AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" 
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

    public function get_agenda($data) {
        $query = $this->db->query('
			SELECT 
				U.Nome
			FROM 
				Sis_Usuario AS U
					LEFT JOIN App_Agenda AS A ON A.idSis_Usuario = U.idSis_Usuario
			WHERE 
				A.idApp_Agenda = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }
	
	public function select_usuario() {
		
        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
				P.CpfUsuario,
				P.CelularUsuario,
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

	public function select_compartilhar() {

        $query = $this->db->query('
            SELECT
				P.idSis_Usuario,
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
        $array[50] = ':: Ninguém ::';
        $array[51] = ':: Todos ::';
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
				P.CelularUsuario,
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
	
    public function select_status_sn2($data = FALSE) {

        $query = $this->db->query('
            SELECT
                idTab_StatusSN,
                StatusSN,
				Abrev
            FROM
                Tab_StatusSN 

            ORDER BY
                StatusSN DESC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->Abrev] = $row->StatusSN;
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
                CONCAT(IFNULL(C.NomeCliente, ""), " --- ", IFNULL(C.CelularCliente, ""), " --- ", IFNULL(C.Telefone2, ""), " --- ", IFNULL(C.Telefone3, "")) As NomeCliente
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

    public function select_categoria() {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
        
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
				C.idSis_Usuario = ' . $_SESSION['log']['id'] . ' )
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

    public function select_empresarec() {

        $query = $this->db->query('
            SELECT
                ER.idSis_Empresa,
                ER.NomeEmpresa
            FROM
                Sis_Empresa AS ER

            WHERE
                ER.idSis_Empresa != "1"
			ORDER BY	
                ER.NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresa;
        }

        return $array;
    }

    public function select_empresaenv() {

        $query = $this->db->query('
            SELECT
                EE.idSis_Empresa,
                EE.NomeEmpresa AS NomeEmpresaCli
            FROM
                Sis_Empresa AS EE

            WHERE
                EE.idSis_Empresa != "1"
			ORDER BY	
                EE.NomeEmpresa ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idSis_Empresa] = $row->NomeEmpresaCli;
        }

        return $array;
    }	

    public function select_procedimento() {

        $query = $this->db->query('
            SELECT
                P.idApp_Procedimento,
                P.Procedimento
            FROM
                App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" AND
				P.idSis_EmpresaCli = "0" AND
				U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' 
            ORDER BY
                P.idApp_Procedimento ASC
        ');

        $array = array();
        $array[0] = 'TODOS';
        foreach ($query->result() as $row) {
			$array[$row->idApp_Procedimento] = $row->Procedimento;
        }

        return $array;
    }

	public function select_tarefa() {

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

				(U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				AU.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				P.Compartilhar = ' . $_SESSION['log']['id'] . ' OR
				(P.idSis_Usuario = ' . $_SESSION['log']['id'] . ') OR
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
	
	public function list1_procedimento1($data, $completo) {


		$data['Dia'] = ($data['Dia']) ? ' AND DAY(P.DataProcedimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(P.DataProcedimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(P.DataProcedimento) = ' . $data['Ano'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.Prioridade' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro4 = ($data['ConcluidoProcedimento']) ? 'P.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;
		$filtro5 = ($data['Prioridade']) ? 'P.Prioridade = "' . $data['Prioridade'] . '" AND ' : FALSE;
		$filtro6 = ($data['Categoria']) ? 'P.Categoria = "' . $data['Categoria'] . '" AND ' : FALSE;
		$data['ConcluidoProcedimento'] = ($data['ConcluidoProcedimento'] != '') ? ' AND P.ConcluidoProcedimento = ' . $data['ConcluidoProcedimento'] : FALSE;
		$data['Prioridade'] = ($data['Prioridade'] != '') ? ' AND P.Prioridade = ' . $data['Prioridade'] : FALSE;
		$data['Procedimento'] = ($data['Procedimento']) ? ' AND P.idApp_Procedimento = ' . $data['Procedimento'] : FALSE;

		
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
				P.Compartilhar,
				CT.Categoria,
				SN.StatusSN
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = P.Categoria
            WHERE

				' . $filtro4 . '
				' . $filtro5 . '
				' . $filtro6 . '
				(U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				AU.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR	
				P.Compartilhar = ' . $_SESSION['log']['id'] . ' OR
				(P.Compartilhar = 51 AND P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '))
				' . $data['Procedimento'] . '
            ORDER BY
				P.ConcluidoProcedimento ASC,
				P.DataProcedimento DESC,
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
				$row->DataProcedimentoLimite = $this->basico->mascara_data($row->DataProcedimentoLimite, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
				$row->Prioridade = $this->basico->prioridade($row->Prioridade, '123');
            }

            return $query;
        }

    }

	public function list1_procedimento($data, $completo) {


		$data['Dia'] = ($data['Dia']) ? ' AND DAY(P.DataProcedimento) = ' . $data['Dia'] : FALSE;
		$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(P.DataProcedimento) = ' . $data['Mesvenc'] : FALSE;
		$data['Ano'] = ($data['Ano']) ? ' AND YEAR(P.DataProcedimento) = ' . $data['Ano'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.Prioridade' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro4 = ($data['ConcluidoProcedimento']) ? 'P.ConcluidoProcedimento = "' . $data['ConcluidoProcedimento'] . '" AND ' : FALSE;
		$filtro5 = ($data['Prioridade']) ? 'P.Prioridade = "' . $data['Prioridade'] . '" AND ' : FALSE;
		$filtro6 = ($data['Categoria']) ? 'P.Categoria = "' . $data['Categoria'] . '" AND ' : FALSE;
		$data['ConcluidoProcedimento'] = ($data['ConcluidoProcedimento'] != '') ? ' AND P.ConcluidoProcedimento = ' . $data['ConcluidoProcedimento'] : FALSE;
		$data['Prioridade'] = ($data['Prioridade'] != '') ? ' AND P.Prioridade = ' . $data['Prioridade'] : FALSE;
		$data['Procedimento'] = ($data['Procedimento']) ? ' AND P.idApp_Procedimento = ' . $data['Procedimento'] : FALSE;

		
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
				P.Compartilhar,
				CT.Categoria,
				SN.StatusSN
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = P.Categoria
            WHERE

				' . $filtro4 . '
				' . $filtro5 . '
				' . $filtro6 . '
				(U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				(P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idSis_Usuario = ' . $_SESSION['log']['id'] . '))
				' . $data['Procedimento'] . '
            ORDER BY
				P.ConcluidoProcedimento ASC,
				P.DataProcedimento DESC,
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
				$row->DataProcedimentoLimite = $this->basico->mascara_data($row->DataProcedimentoLimite, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
				$row->Prioridade = $this->basico->prioridade($row->Prioridade, '123');
            }

            return $query;
        }

    }

	public function list2_procedimentocli($data, $completo) {

		$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
		$data['Diacli'] = ($data['Diacli']) ? ' AND DAY(P.DataProcedimentoLimite) = ' . $data['Diacli'] : FALSE;
		$data['Mesvenccli'] = ($data['Mesvenccli']) ? ' AND MONTH(P.DataProcedimentoLimite) = ' . $data['Mesvenccli'] : FALSE;
		$data['Anocli'] = ($data['Anocli']) ? ' AND YEAR(P.DataProcedimentoLimite) = ' . $data['Anocli'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.DataProcedimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'DESC' : $data['Ordenamento'];
		$filtro4 = ($data['Concluidocli']) ? 'P.ConcluidoProcedimento = "' . $data['Concluidocli'] . '" AND ' : FALSE;
		
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
				P.DataProcedimentoLimite,
				P.ConcluidoProcedimento,
				SN.StatusSN
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_EmpresaCli = "0" AND
				P.idApp_Cliente != "0" AND
				' . $filtro4 . '
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                ' . $data['NomeCliente'] . '

				' . $data['Diacli'] . ' 
				' . $data['Mesvenccli'] . ' 
				' . $data['Anocli'] . ' 
				
            ORDER BY
                P.ConcluidoProcedimento ASC,
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
				$row->DataProcedimentoLimite = $this->basico->mascara_data($row->DataProcedimentoLimite, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');

            }

            return $query;
        }

    }

	public function list3_mensagemenv($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND P.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
		$data['NomeEmpresaCli'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['NomeEmpresaCli']) ? ' AND P.idSis_EmpresaCli = ' . $data['NomeEmpresaCli'] : FALSE;
		$data['Diaemp'] = ($data['Diaemp']) ? ' AND DAY(P.DataProcedimento) = ' . $data['Diaemp'] : FALSE;
		$data['Mesvencemp'] = ($data['Mesvencemp']) ? ' AND MONTH(P.DataProcedimento) = ' . $data['Mesvencemp'] : FALSE;
		$data['Anoemp'] = ($data['Anoemp']) ? ' AND YEAR(P.DataProcedimento) = ' . $data['Anoemp'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.ConcluidoProcedimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
		$filtro4 = ($data['Concluidoemp']) ? 'P.ConcluidoProcedimento = "' . $data['Concluidoemp'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				EE.NomeEmpresa AS NomeEmpresaCli,
				ER.NomeEmpresa AS NomeEmpresa,
				UE.Nome AS NomeCli,
				UR.Nome AS Nome,
				P.idSis_Empresa,
				P.idSis_EmpresaCli,
				P.idApp_Procedimento,
                P.idApp_OrcaTrata,
				P.idApp_Cliente,
				P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento,
				P.idSis_EmpresaCli,
				P.ProcedimentoCli,
				P.DataProcedimentoCli,
				P.ConcluidoProcedimentoCli,
				SN.StatusSN
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Empresa AS EE ON EE.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Empresa AS ER ON ER.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
            WHERE 
				P.idSis_EmpresaCli = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				' . $filtro4 . '
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" 
				' . $data['NomeEmpresa'] . '
				' . $data['NomeEmpresaCli'] . '
				' . $data['Diaemp'] . ' 
				' . $data['Mesvencemp'] . ' 
				' . $data['Anoemp'] . ' 
            ORDER BY
				P.ConcluidoProcedimento,
				P.DataProcedimentoCli ASC
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
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
				$row->DataProcedimentoCli = $this->basico->mascara_data($row->DataProcedimentoCli, 'barras');
				$row->ConcluidoProcedimentoCli = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimentoCli, 'NS');
            }

            return $query;
        }

    }
	
	public function list4_mensagemrec($data, $completo) {

		$data['NomeEmpresa'] = ($data['NomeEmpresa']) ? ' AND P.idSis_Empresa = ' . $data['NomeEmpresa'] : FALSE;
		$data['NomeEmpresaCli'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $data['NomeEmpresaCli']) ? ' AND P.idSis_EmpresaCli = ' . $data['NomeEmpresaCli'] : FALSE;
		$data['Diaemp'] = ($data['Diaemp']) ? ' AND DAY(P.DataProcedimento) = ' . $data['Diaemp'] : FALSE;
		$data['Mesvencemp'] = ($data['Mesvencemp']) ? ' AND MONTH(P.DataProcedimento) = ' . $data['Mesvencemp'] : FALSE;
		$data['Anoemp'] = ($data['Anoemp']) ? ' AND YEAR(P.DataProcedimento) = ' . $data['Anoemp'] : FALSE;
        $data['Campo'] = (!$data['Campo']) ? 'P.ConcluidoProcedimento' : $data['Campo'];
        $data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
		$filtro4 = ($data['Concluidoemp']) ? 'P.ConcluidoProcedimento = "' . $data['Concluidoemp'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				EE.NomeEmpresa AS NomeEmpresaCli,
				ER.NomeEmpresa AS NomeEmpresa,
				UE.Nome AS NomeCli,
				UR.Nome AS Nome,
				P.idSis_Empresa,
				P.idSis_EmpresaCli,
				P.idApp_Procedimento,
                P.idApp_OrcaTrata,
				P.idApp_Cliente,
				P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento,
				P.idSis_EmpresaCli,
				P.ProcedimentoCli,
				P.DataProcedimentoCli,
				P.ConcluidoProcedimentoCli,
				SN.StatusSN
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Empresa AS EE ON EE.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Empresa AS ER ON ER.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
            WHERE 
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				' . $filtro4 . '
				P.idSis_EmpresaCli != "0" AND
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" 
				' . $data['NomeEmpresa'] . '
				' . $data['NomeEmpresaCli'] . '
				' . $data['Diaemp'] . ' 
				' . $data['Mesvencemp'] . ' 
				' . $data['Anoemp'] . ' 
            ORDER BY
				P.ConcluidoProcedimento,
				P.DataProcedimentoCli ASC
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
				$row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
				$row->ConcluidoProcedimento = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimento, 'NS');
				$row->DataProcedimentoCli = $this->basico->mascara_data($row->DataProcedimentoCli, 'barras');
				$row->ConcluidoProcedimentoCli = $this->basico->mascara_palavra_completa($row->ConcluidoProcedimentoCli, 'NS');
            }

            return $query;
        }

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
