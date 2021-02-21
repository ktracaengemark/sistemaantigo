<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }


    ##############
    #RESPONS�VEL
    ##############

    public function set_cliente($data) {

        $query = $this->db->insert('App_Cliente', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_arquivo($data) {

        $query = $this->db->insert('Sis_Arquivo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function set_usuario($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('Sis_Usuario', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function set_agenda($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('App_Agenda', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function get_cliente($data) {
        $query = $this->db->query('SELECT * FROM App_Cliente WHERE idApp_Cliente = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_usuario($data) {
        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE idSis_Usuario = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function get_arquivo($data) {
        $query = $this->db->query('SELECT * FROM Sis_Arquivo WHERE idSis_Arquivo = ' . $data);
        $query = $query->result_array();

        return $query[0];

    }    

    public function get_empresa5($data) {
        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE idSis_Empresa = "5" AND CelularUsuario = ' . $data);
        $query = $query->result_array();

        return $query[0];

    }
	
    public function update_cliente($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Cliente', $data, array('idApp_Cliente' => $id));
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
	
    public function update_usuario($data, $id) {

        unset($data['idSis_Usuario']);
        $query = $this->db->update('Sis_Usuario', $data, array('idSis_Usuario' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_cliente($data) {

        $query = $this->db->query('SELECT idApp_OrcaTrata FROM App_OrcaTrata WHERE idApp_Cliente = ' . $data);
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

        $this->db->delete('App_Consulta', array('idApp_Cliente' => $data));
        $this->db->delete('App_ContatoCliente', array('idApp_Cliente' => $data));

        foreach ($query as $key) {
            $query = $this->db->delete('App_ProdutoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ServicoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ParcelasRecebiveis', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_Procedimento', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
        }

        $this->db->delete('App_OrcaTrata', array('idApp_Cliente' => $data));
        $this->db->delete('App_Cliente', array('idApp_Cliente' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_arquivo($data) {
        $query = $this->db->delete('Sis_Arquivo', array('idSis_Arquivo' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            return TRUE;
        }

    }    

    public function lista_cliente_ORIG($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Cliente WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
				#. '(NomeCliente like "%' . $data . '%" ) '
                . '(NomeCliente like "%' . $data . '%" OR '
				. ' RegistroFicha like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomeCliente like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'CelularCliente like "%' . $data . '%" OR Telefone like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY NomeCliente ASC '
				. 'limit 10 ');
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
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                }

                return $query;
            }
        }
    }
	
    public function lista_cliente_2($data, $data2, $data3, $x, $qtde=0, $page=0) {
			/*
			echo "<pre>";
			print_r($data);
			echo "<br>";
			print_r($data2);
			echo "<br>";
			print_r($data3);
			echo "<br>";
			print_r($x);
			echo "<br>";
			print_r($qtde);
			echo "<br>";
			print_r($page);
			echo "<br>";
			echo "</pre>";
			exit();
			*/	
		$ficha = ($data) ? ' AND RegistroFicha like "%' . $data . '%" ' : '';
		$nomedocliente = ($data2) ? ' AND NomeCliente like "%' . $data2 . '%" ' : '';
		$telefonedocliente = ($data3) ? ' AND (CelularCliente like "%' . $data3 . '%" OR Telefone like "%' . $data3 . '%" OR Telefone2 like "%' . $data3 . '%" OR Telefone3 like "%' . $data3 . '%") ' : '';
		$querylimit = ($qtde)? 'LIMIT ' . $page . ', ' . $qtde : '';
        $query = $this->db->query('SELECT * '
                . 'FROM App_Cliente WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ''
				. $nomedocliente
				. $ficha
				. $telefonedocliente
                . 'ORDER BY NomeCliente ASC '
				. $querylimit
				);
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
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                }
                return $query;
            }
        }
    }	

    public function lista_cliente_total() {
	
        $query = $this->db->query('SELECT * '
                . 'FROM App_Cliente WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' ');
		/*
          echo "<pre>";
          print_r($query->num_rows());
          echo "</pre>";
          exit();
		  */
		
		if ($query->num_rows() === 0) {
            return FALSE;
        } else {
			return $query->num_rows();
        }
    }
	
    public function lista_cliente($data, $existe = FALSE, $total = FALSE, $limit = FALSE, $start = FALSE, $date = FALSE) {

        if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $data)) {
            $query = 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                    . 'DataCadastroCliente = "' . $this->basico->mascara_data($data, 'mysql') . '" ';
        }elseif (is_numeric($data)) {
            if($date === TRUE) {
                $query = 'DataNascimento = "' . substr($data, 4, 4).'-'.substr($data, 2, 2).'-'.substr($data, 0, 2) . '" OR '
                        . 'DataCadastroCliente = "' . substr($data, 4, 4).'-'.substr($data, 2, 2).'-'.substr($data, 0, 2) . '" ';
            }else{
				if((strlen($data)) <= 7){
					$query = 'idApp_Cliente like "' . $data . '" OR '
							. 'RegistroFicha like "' . $data . '" ';
				}else{
					$query = 'CelularCliente like "%' . $data . '%" OR '
							. 'Telefone like "%' . $data . '%" OR '
							. 'Telefone2 like "%' . $data . '%" OR '
							. 'Telefone3 like "%' . $data . '%" ';
				}
			}			
        }else{
			$query = 'NomeCliente like "' . $data . '%" ';
		}
            

        $querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

        if ($existe === TRUE) {

            $query = $this->db->query('SELECT * '
                    . 'FROM App_Cliente WHERE '
					. 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                    . $query
                    . 'ORDER BY NomeCliente ASC');

            if ($query->num_rows() == 0)
                return FALSE;
            else
                return TRUE;
        }else {

            if ($total === TRUE) {

                $query = $this->db->query('SELECT * '
                        . 'FROM App_Cliente WHERE '
						. 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                        . $query
                        . 'ORDER BY NomeCliente ASC');

                return $query->num_rows();
            }else {

                $query = $this->db->query('SELECT * '
                        . 'FROM App_Cliente WHERE '
						. 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                        . $query
                        . 'ORDER BY NomeCliente ASC '
                        . $querylimit);

                /*
                echo $this->db->last_query();
                echo "<pre>";
                print_r($query);
                echo "</pre>";
                exit();
                */

                foreach ($query->result() as $row) {
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                    $row->DataCadastroCliente = $this->basico->mascara_data($row->DataCadastroCliente, 'barras');
                }

                return $query;
            }
        }

    }	
    
	public function list_motivo($data, $x) {
		
		$data['idSis_Empresa'] = ($data['idSis_Empresa'] != 0) ? ' AND TA.idSis_Empresa = ' . $data['idSis_Empresa'] : FALSE;

        $query = $this->db->query('
			SELECT 
				TA.*
			FROM 
				Tab_Motivo AS TA
			WHERE 
                TA.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                
			ORDER BY  
				TA.Motivo ASC 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
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
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }
	
	public function select_cliente($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Cliente,
				CelularCliente,
				RegistroFicha,
				CONCAT(IFNULL(idApp_Cliente,""), " - ", IFNULL(NomeCliente,""), " - ", IFNULL(CelularCliente,""), " - ", IFNULL(Telefone,""), " - ", IFNULL(Telefone2,""), " - FCH:", IFNULL(RegistroFicha,"")) AS NomeCliente
            FROM
                App_Cliente					
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				idApp_Cliente DESC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Cliente,
				CelularCliente,
				RegistroFicha,
				CONCAT(IFNULL(idApp_Cliente,""), " - ", IFNULL(NomeCliente,""), " - ", IFNULL(CelularCliente,""), " - ", IFNULL(Telefone,""), " - ", IFNULL(Telefone2,""), " - FCH:", IFNULL(RegistroFicha,"")) AS NomeCliente		
            FROM
                App_Cliente					
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				idApp_Cliente DESC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Cliente] = $row->NomeCliente;
            }
        }

        return $array;
    }
	
	public function select_clienteonline($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Cliente,
				CONCAT(NomeCliente) As NomeCliente				
            FROM
                App_Cliente					
            WHERE
                idSis_Empresa = "5"
			ORDER BY 
				NomeCliente ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Cliente,
				CONCAT(NomeCliente) As NomeCliente			
            FROM
                App_Cliente					
            WHERE
                idSis_Empresa = "5"
			ORDER BY 
				NomeCliente ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Cliente] = $row->NomeCliente;
            }
        }

        return $array;
    }	

	public function select_relacao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT 
                    TR.idTab_Relacao,
					TR.Tipo,
                    CONCAT(IFNULL(TR.Relacao,"")) AS Relacao
				FROM
                    Tab_Relacao AS TR
				WHERE
					TR.Tipo = "PESSOAL"
				ORDER BY 
					TR.Relacao ASC
			');

        } else {
            #$query = $this->db->query('SELECT  idTab_Relacao, Relacao FROM Tab_Relacao  WHERE idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario']);
            $query = $this->db->query('
                SELECT 
                    TR.idTab_Relacao,
					TR.Tipo,
                    CONCAT(IFNULL(TR.Relacao,"")) AS Relacao
				FROM
                    Tab_Relacao AS TR
				WHERE
					TR.Tipo = "PESSOAL"
				ORDER BY 
					TR.Relacao ASC
			');
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Relacao] = $row->Relacao;
				#$array[$row->Relacao] = $row->Relacao;
            }
        }

        return $array;
    }

}
