<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Consultaprint_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function get_consulta($data) {

		$cliente 		= ($_SESSION['Agendamentos']['idApp_Cliente']) ? ' AND CO.idApp_Cliente = ' . $_SESSION['Agendamentos']['idApp_Cliente'] : FALSE;
		$clientepet		= ($_SESSION['Agendamentos']['idApp_ClientePet']) ? ' AND CO.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet'] : FALSE;		
		
		$campo 			= (!$_SESSION['Agendamentos']['Campo']) ? 'CO.DataInicio' : $_SESSION['Agendamentos']['Campo'];
        $ordenamento 	= (!$_SESSION['Agendamentos']['Ordenamento']) ? 'ASC' : $_SESSION['Agendamentos']['Ordenamento'];
		
		/*       
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($cliente);
		echo '<br>';
        print_r($clientepet);
        echo "</pre>";
        exit ();
        */
		($_SESSION['Agendamentos']['DataInicio']) ? $date_inicio = $_SESSION['Agendamentos']['DataInicio'] : FALSE;
		($_SESSION['Agendamentos']['DataFim']) ? $date_fim = date('Y-m-d', strtotime('+1 days', strtotime($_SESSION['Agendamentos']['DataFim']))) : FALSE;
		
		$date_inicio_orca 	= ($_SESSION['Agendamentos']['DataInicio']) ? 'DataInicio >= "' . $date_inicio . '" AND ' : FALSE;
		$date_fim_orca 		= ($_SESSION['Agendamentos']['DataFim']) ? 'DataInicio <= "' . $date_fim . '" AND ' : FALSE;
		
		$query = $this->db->query('
            SELECT
				CO.*,
				DATE_FORMAT(CO.DataInicio, "%Y-%m-%d") AS DataInicio,
				DATE_FORMAT(CO.DataInicio, "%H:%i") AS HoraInicio,
				DATE_FORMAT(CO.DataFim, "%Y-%m-%d") AS DataFim,
				DATE_FORMAT(CO.DataFim, "%H:%i") AS HoraFim,
				CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
				CP.*,
				CONCAT(IFNULL(CP.idApp_ClientePet,""), " - " ,IFNULL(CP.NomeClientePet,"")) AS NomeClientePet
            FROM
                App_Consulta AS CO
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CO.idApp_Cliente
					LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = CO.idApp_ClientePet
            WHERE
				' . $date_inicio_orca . '
				' . $date_fim_orca . '
                CO.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				CO.Tipo = 2
				' . $cliente . '
				' . $clientepet . '
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
        ');
		
        $query = $query->result_array();
            /*
			foreach ($query->result() as $row) {
				//$row->HoraInicio = $this->basico->mascara_hora($row->DataInicio, 'hora');
				//$row->DataInicio = $this->basico->mascara_data($row->DataInicio, 'barras');
				//$row->HoraFim = $this->basico->mascara_hora($row->DataFim, 'hora');
				//$row->DataFim = $this->basico->mascara_data($row->DataFim, 'barras');
                //$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
				
				if($row->PeloPet == 1){
					$row->Pelo = "CURTO";
				}elseif($row->PeloPet == 2){
					$row->Pelo = "MÉDIO";
				}elseif($row->PeloPet == 3){
					$row->Pelo = "LONGO";
				}elseif($row->PeloPet == 4){
					$row->Pelo = "CACHEADO";
				}else{
					$row->Pelo = "N.I.";
				}
				
				if($row->PortePet == 1){
					$row->Porte = "MINI";
				}elseif($row->PortePet == 2){
					$row->Porte = "PEQUENO";
				}elseif($row->PortePet == 3){
					$row->Porte = "MÉDIO";
				}elseif($row->PortePet == 4){
					$row->Porte = "GRANDE";
				}elseif($row->PortePet == 5){
					$row->Porte = "GIGANTE";
				}else{
					$row->Porte = "N.I.";
				}
								
				if($row->EspeciePet == 1){
					$row->Especie = "CÃO";
				}elseif($row->EspeciePet == 2){
					$row->Especie = "GATO";
				}elseif($row->EspeciePet == 3){
					$row->Especie = "AVE";
				}else{
					$row->Especie = "N.I.";
				}
								
				if($row->SexoPet == "M"){
					$row->Sexo = "MACHO";
				}elseif($row->SexoPet == "F"){
					$row->Sexo = "FEMEA";
				}elseif($row->SexoPet == "O"){
					$row->Sexo = "OUT";
				}else{
					$row->Sexo = "N.I.";
				}				
				*/
				/*
				$data = DateTime::createFromFormat('d/m/Y H:i:s', $data);
				$data = $data->format('Y-m-d H:i:s');
				format('Y-m-d H:i:s');
				*/
				/*
				  echo $this->db->last_query();
				  echo "<pre>";
				  print_r($somaentrada);          
				  echo "</pre>";
				  exit();
					
		  
            }
			*/
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

}
