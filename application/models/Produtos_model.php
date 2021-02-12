<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_produtos($data) {

        $query = $this->db->insert('Tab_Produtos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produtos_Original($data) {

        $query = $this->db->insert('Tab_Produto', $data);

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
	
    public function set_valor($data) {

        $query = $this->db->insert_batch('Tab_Valor', $data);
		
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_servico($data) {

        $query = $this->db->insert_batch('Tab_Atributo_Select', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
			} else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_opcao_select($data) {

        $query = $this->db->insert_batch('Tab_Opcao_Select', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_produto($data) {

        $query = $this->db->insert_batch('Tab_Opcao_Select', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_procedimento($data) {

        $query = $this->db->insert_batch('Tab_Opcao_Select', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	

    public function set_derivados($data) {

        $query = $this->db->insert_batch('Tab_Produtos', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	
	
    public function set_valor1($data) {

        $query = $this->db->insert('Tab_Valor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	

    public function set_promocao($data) {

        $query = $this->db->insert('Tab_Promocao', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_produto($data) {
		$query = $this->db->query('
			SELECT
				TP.*
			FROM 
				Tab_Produto AS TP
			WHERE 
				idTab_Produto = ' . $data . '
		');
        $query = $query->result_array();

        //return $query;
		return $query[0];
    }
	
    public function get_produtos($data) {
        $query = $this->db->query('
			SELECT  
				TPS.*,
				TCP.*,
				TP.idTab_Produto,
				TP.Produtos,
				TP.VendaSite AS VendaSite_Produto,
				TOP1.idTab_Opcao,
				TOP1.Opcao AS Opcao1,
				TOP2.idTab_Opcao,
				TOP2.Opcao AS Opcao2
			FROM 
				Tab_Produtos AS TPS
					LEFT JOIN Tab_Catprod AS TCP ON TCP.idTab_Catprod = TPS.idTab_Catprod
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_2
			WHERE 
				TPS.idTab_Produtos = ' . $data
		);
        $query = $query->result_array();
		
        return $query[0];
    }

    public function get_produtos_original($data) {
        $query = $this->db->query('
			SELECT  
				TP.*,
				TPRS.Prod_Serv AS TipoProdServ,
				TM.idTab_Modelo,
				TM.Modelo,
				CTP.Catprod
			FROM 
				Tab_Produto AS TP
					LEFT JOIN Tab_Modelo AS TM ON TM.idTab_Modelo = TP.idTab_Modelo
					LEFT JOIN Tab_Catprod AS CTP ON CTP.idTab_Catprod = TP.Prodaux3
					LEFT JOIN Tab_Prod_Serv AS TPRS ON TPRS.Abrev_Prod_Serv = TP.Prod_Serv
			WHERE 
				TP.idTab_Produto = ' . $data
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

    public function get_modelo2($data) {
		$query = $this->db->query('SELECT * FROM Tab_Modelo WHERE idTab_Modelo = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }	

    public function get_modelo($data) {
		$query = $this->db->query('SELECT * FROM Tab_Produto WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_valor($data) {
		$query = $this->db->query('
			SELECT 
				TV.*,
				TPS.Nome_Prod,
				TPS.idTab_Produto,
				TPS.idTab_Catprod,
				TPS.Arquivo,
				TPS.Cod_Prod,
				TPS.Cod_Barra,
				TPS.Estoque
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
			WHERE 
				TV.idTab_Valor = ' . $data . ' 
		');
        $query = $query->result_array();

        return $query[0];
    }
	
    public function get_valor_original($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Valor 
			WHERE 
				idTab_Modelo = ' . $data . ' AND
				Desconto = "1"
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_servico($data) {
		$query = $this->db->query('SELECT * FROM Tab_Atributo_Select WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_atributos($data) {
		$query = $this->db->query('
			SELECT 
				TA.*
			FROM 
				Tab_Atributo AS TA
			WHERE 
				TA.idTab_Catprod = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_atributos2($data) {
		$query = $this->db->query('
			SELECT 
				TAS.*,
				TA.*
			FROM 
				Tab_Atributo_Select AS TAS
					LEFT JOIN Tab_Atributo AS TA ON TA.idTab_Atributo = TAS.idTab_Atributo
			WHERE 
				TAS.idTab_Catprod = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }
	
	public function get_opcao_select($data, $item) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Opcao_Select 
			WHERE 
				idTab_Produto = ' . $data . ' AND
				Item_Atributo = '. $item . '
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_opcao_select1($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Opcao_Select 
			WHERE 
				idTab_Produto = ' . $data . ' AND
				Item_Atributo = "1"
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_opcao_select2($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Opcao_Select 
			WHERE 
				idTab_Produto = ' . $data . ' AND
				Item_Atributo = "2"
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produto_Original($data) {
		$query = $this->db->query('SELECT * FROM Tab_Opcao_Select WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM Tab_Opcao_Select WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }	

    public function get_produtosderivados($data) {
		$query = $this->db->query('
			SELECT
				TPS.idTab_Produtos,
				TPS.idSis_Empresa,
				TPS.Arquivo,
				TPS.Nome_Prod,
				TP.Produtos,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(TP.Produtos,""), " - ",  IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,"")) AS NomeProduto
			FROM 
				Tab_Produtos AS TPS
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2
			WHERE 
				idTab_Produtos = ' . $data . '
		');
        $query = $query->result_array();

        //return $query;
		return $query[0];
    }
	
    public function get_derivados($data) {
		$query = $this->db->query('
			SELECT  
				TPS.idTab_Produtos,
				TPS.idSis_Usuario,
				TPS.idSis_Empresa,
				TPS.Cat_Prod,
				TPS.idTab_Modulo,
				TPS.idTab_Modelo,
				TPS.Mod_Prod,
				TPS.Opcao_Atributo_1,
				TPS.Opcao_Atributo_2,
				TPS.idTab_Produto,
				TPS.Nome_Prod,
				TPS.Cod_Prod,
				TPS.Arquivo,
				TPS.Ativo,
				TPS.VendaSite,
				TPS.Tipo_Valor_Prod,
				TPS.Valor_Produto,
				TPS.Qtd_Prod_Desc,
				TPS.Qtd_Prod_Incr,
				TPS.Comissao,
				TDS.Desconto,
				TCP.Nome_Cor_Prod,
				TTP.Nome_Tam_Prod
			FROM 
				Tab_Produtos AS TPS
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = TPS.Tipo_Valor_Prod
					LEFT JOIN Tab_Cor_Prod AS TCP ON TCP.idTab_Cor_Prod = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Tam_Prod AS TTP ON TTP.idTab_Tam_Prod = TPS.Opcao_Atributo_2
			WHERE 
				TPS.idTab_Produto = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_derivados2($data) {
		$query = $this->db->query('
			SELECT  
				TPS.idTab_Produtos,
				TPS.idSis_Usuario,
				TPS.idSis_Empresa,
				TPS.Cat_Prod,
				TPS.idTab_Modulo,
				TPS.idTab_Modelo,
				TPS.Mod_Prod,
				TPS.Opcao_Atributo_1,
				TPS.Opcao_Atributo_2,
				TPS.idTab_Produto,
				TPS.Nome_Prod,
				TPS.Cod_Prod,
				TPS.Arquivo,
				TPS.Ativo,
				TPS.VendaSite,
				TPS.Tipo_Valor_Prod,
				TPS.Valor_Produto,
				TPS.Qtd_Prod_Desc,
				TPS.Qtd_Prod_Incr,
				TPS.Comissao,
				TDS.Desconto,
				TCP.Nome_Cor_Prod,
				TTP.Nome_Tam_Prod
			FROM 
				Tab_Produtos AS TPS
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = TPS.Tipo_Valor_Prod
					LEFT JOIN Tab_Cor_Prod AS TCP ON TCP.idTab_Cor_Prod = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Tam_Prod AS TTP ON TTP.idTab_Tam_Prod = TPS.Opcao_Atributo_2
			WHERE 
				TPS.idTab_Modelo = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }	
	
	public function get_item($data, $desconto) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Valor 
			WHERE 
				idTab_Produtos = ' . $data . ' AND
				Desconto = ' . $desconto . '
		');
        $query = $query->result_array();

        return $query;
    }

	public function list_categoria($data, $x) {
		
		//$data['idSis_Empresa'] = ($data['idSis_Empresa'] != 0) ? ' AND TPS.idSis_Empresa = ' . $data['idSis_Empresa'] : FALSE;
			
			/*
			echo "<pre>";
			print_r($data['idSis_Empresa']);
			echo "</pre>";
			exit();
			*/
		
		
        $query = $this->db->query('
			SELECT 
				TCT.*,
				TPSA.*
			FROM 
				Tab_Catprod AS TCT
					LEFT JOIN Tab_Prod_Serv AS TPSA ON TPSA.Abrev_Prod_Serv = TCT.TipoCatprod
			WHERE 
                TCT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY  
				TCT.Catprod ASC 
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
    
	public function list_atributo($data, $x) {
		
		$data['idTab_Catprod'] = ($data['idTab_Catprod'] != 0) ? ' AND TA.idTab_Catprod = ' . $data['idTab_Catprod'] : FALSE;

        $query = $this->db->query('
			SELECT 
				TA.*
			FROM 
				Tab_Atributo AS TA
			WHERE 
                TA.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                ' . $data['idTab_Catprod'] . '
			ORDER BY  
				TA.Atributo ASC 
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
    
	public function list_opcao($data, $x) {
		
		$data['idTab_Catprod'] = ($data['idTab_Catprod'] != 0) ? ' AND TOP.idTab_Catprod = ' . $data['idTab_Catprod'] : FALSE;

        $query = $this->db->query('
			SELECT 
				TOP.*,
				TA.*
			FROM 
				Tab_Opcao AS TOP
					LEFT JOIN Tab_Atributo AS TA ON TA.idTab_Atributo = TOP.idTab_Atributo
			WHERE 
                TOP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                ' . $data['idTab_Catprod'] . '
			ORDER BY  
				TA.Atributo ASC, 
				TOP.Opcao ASC 
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
        
	public function list_produto($data, $x) {
		
		$data['idTab_Catprod'] = ($data['idTab_Catprod'] != 0) ? ' AND TP.idTab_Catprod = ' . $data['idTab_Catprod'] : FALSE;

        $query = $this->db->query('
			SELECT 
				TP.*
			FROM 
				Tab_Produto AS TP
			WHERE 
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
                ' . $data['idTab_Catprod'] . '
			ORDER BY  
				TP.Produtos ASC 
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
		
    public function list_produtos1($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idTab_Produto,
                TF.TipoProduto,
                TF.Produtos
            FROM
                Tab_Produto AS TF
            WHERE
                TF.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' 
            ORDER BY
                TF.TipoProduto ASC
				
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

                    $row->TipoProduto = $this->get_tipoproduto($row->TipoProduto);
                }
                return $query;
            }
        }
    }
    
	public function list_produtos($data, $x) {
		
		$data['idTab_Produto'] = ($data['idTab_Produto'] != 0) ? ' AND TPS.idTab_Produto = ' . $data['idTab_Produto'] : FALSE;
			
			/*
			echo "<pre>";
			print_r($data['idTab_Produto']);
			echo "</pre>";
			exit();
			*/
		
		
        $query = $this->db->query('
			SELECT 
				TPS.*,
				TCT.*,
				TP.*,
				TOP1.Opcao AS Atributo1,
				TOP2.Opcao AS Atributo2
			FROM 
				Tab_Produtos AS TPS
					LEFT JOIN Tab_Catprod AS TCT ON TCT.idTab_Catprod = TPS.idTab_Catprod
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TPS.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_2
			WHERE 
                TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Catprod = ' . $data['idTab_Catprod'] . '
				' . $data['idTab_Produto'] . '
			ORDER BY  
				TPS.Nome_Prod ASC 
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
    
	public function list_precos($data, $x) {
		
		$data['idTab_Produtos'] = ($data['idTab_Produtos'] != 0) ? ' AND TV.idTab_Produtos = ' . $data['idTab_Produtos'] : FALSE;
			
			/*
			echo "<pre>";
			print_r($data['Metodo']);
			echo "</pre>";
			exit();
			*/
		
		
        $query = $this->db->query('
			SELECT 
				TV.*,
				TDS.*,
				TPM.DataInicioProm,
				TPM.DataFimProm,
				TPM.Promocao,
				TPM.Descricao,
				TPS.Nome_Prod
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = TV.Desconto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = TV.idTab_Promocao
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_produtos
			WHERE 
                TV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TV.Desconto = "1" 
				' . $data['idTab_Produtos'] . '
			ORDER BY  
				TDS.Desconto ASC,
				TPM.Promocao ASC 
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
                
				foreach ($query->result() as $row) {
					$row->AtivoPreco = $this->basico->mascara_palavra_completa($row->AtivoPreco, 'NS');
					$row->VendaSitePreco = $this->basico->mascara_palavra_completa($row->VendaSitePreco, 'NS');
					$row->VendaBalcaoPreco = $this->basico->mascara_palavra_completa($row->VendaBalcaoPreco, 'NS');
					$row->ValorProduto = number_format($row->ValorProduto, 2, ',', '.');
					$row->ComissaoVenda = number_format($row->ComissaoVenda, 2, ',', '.');
					if($row->TempoDeEntrega == 0){
						$row->TempoDeEntrega = "Pronta Entrega";
					}else{
						$row->TempoDeEntrega = $row->TempoDeEntrega . " Dia(s)";
					}
                }
				
                $query = $query->result_array();
                return $query;
            }
        }
    }
    
	public function list_precos_promocoes($data, $x) {
		
		$data['idTab_Produtos'] = ($data['idTab_Produtos'] != 0) ? ' AND TV.idTab_Produtos = ' . $data['idTab_Produtos'] : FALSE;
			
			/*
			echo "<pre>";
			print_r($data['Metodo']);
			echo "</pre>";
			exit();
			*/
		
		
        $query = $this->db->query('
			SELECT 
				TV.*,
				TDS.*,
				TPM.DataInicioProm,
				TPM.DataFimProm,
				TPM.Promocao,
				TPM.Descricao
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = TV.Desconto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = TV.idTab_Promocao
			WHERE 
                TV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TV.Desconto = "2"
				' . $data['idTab_Produtos'] . '
			ORDER BY  
				TDS.Desconto ASC,
				TPM.Promocao ASC 
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
                foreach ($query->result() as $row) {
					$row->DataInicioProm = $this->basico->mascara_data($row->DataInicioProm, 'barras');
					$row->DataFimProm = $this->basico->mascara_data($row->DataFimProm, 'barras');
                }
                $query = $query->result_array();
                return $query;
            }
        }
    }
    
	public function list_promocoes($data, $x) {
		
		$data['idTab_Produtos'] = ($data['idTab_Produtos'] != 0) ? ' AND TV.idTab_Produtos = ' . $data['idTab_Produtos'] : FALSE;
			/*
			echo "<pre>";
			print_r($data['Metodo']);
			echo "</pre>";
			exit();
			*/
        $query = $this->db->query('
			SELECT 
				TPM.*,
				TCT.*
			FROM 
				Tab_Promocao AS TPM
					LEFT JOIN Tab_Catprom AS TCT ON TCT.idTab_Catprom = TPM.idTab_Catprom
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPM.idTab_Promocao
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
			WHERE 
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TV.Desconto = "2"
				' . $data['idTab_Produtos'] . '
			ORDER BY
				TPM.Promocao ASC 
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
                foreach ($query->result() as $row) {
					$row->DataInicioProm = $this->basico->mascara_data($row->DataInicioProm, 'barras');
					$row->DataFimProm = $this->basico->mascara_data($row->DataFimProm, 'barras');
					$row->VendaBalcao = $this->basico->mascara_palavra_completa($row->VendaBalcao, 'NS');
					$row->VendaSite = $this->basico->mascara_palavra_completa($row->VendaSite, 'NS');
                }
                $query = $query->result_array();
                return $query;
            }
        }
    }

	public function lista_produtos($x) {

		#$data['Produtos'] = ($data['Produtos']) ? ' AND TP.idTab_Produto = ' . $data['Produtos'] : FALSE;
		
        $query = $this->db->query('
			SELECT 
				TP.idTab_Produto,
				TP.Produtos,
				T3.Prodaux3,
				TV.ValorProduto
			FROM 
				Tab_Produto AS TP
				 LEFT JOIN Tab_Prodaux3 AS T3 ON T3.idTab_Prodaux3 = TP.Prodaux3
				 LEFT JOIN Tab_Valor AS TV ON TV.idTab_Produto = TP.idTab_Produto
				 
			WHERE 
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TV.idTab_Produto = TP.idTab_Produto
			ORDER BY 
				T3.Prodaux3 ASC, 
				TP.Produtos ASC 
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
	
    public function update_produto($data, $id) {

        unset($data['idTab_Produto']);
        $query = $this->db->update('Tab_Produto', $data, array('idTab_Produto' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
		
    public function update_produtos($data, $id) {

        unset($data['idTab_Produtos']);
        $query = $this->db->update('Tab_Produtos', $data, array('idTab_Produtos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_produtos_Original($data, $id) {

        unset($data['idTab_Produto']);
        $query = $this->db->update('Tab_Produto', $data, array('idTab_Produto' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produtosderivados($data, $id) {

        unset($data['idTab_Produtos']);
        $query = $this->db->update('Tab_Produtos', $data, array('idTab_Produtos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_valor($data) {

        $query = $this->db->update_batch('Tab_Valor', $data, 'idTab_Valor');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_valor1($data, $id) {

        unset($data['idTab_Valor']);
        $query = $this->db->update('Tab_Valor', $data, array('idTab_Valor' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_servico($data) {
		
        $query = $this->db->update_batch('Tab_Atributo_Select', $data, 'idTab_Atributo_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_opcao_select($data) {
		
        $query = $this->db->update_batch('Tab_Opcao_Select', $data, 'idTab_Opcao_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function update_produto_original($data) {
		
        $query = $this->db->update_batch('Tab_Opcao_Select', $data, 'idTab_Opcao_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_procedimento($data) {
		
        $query = $this->db->update_batch('Tab_Opcao_Select', $data, 'idTab_Opcao_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_derivados($data) {
		
        $query = $this->db->update_batch('Tab_Produtos', $data, 'idTab_Produtos');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function delete_valor($data) {

        $this->db->where_in('idTab_Valor', $data);
        $this->db->delete('Tab_Valor');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_servico($data) {

        $this->db->where_in('idTab_Atributo_Select', $data);
        $this->db->delete('Tab_Atributo_Select');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_opcao_select($data) {
		
        $this->db->where_in('idTab_Opcao_Select', $data);
        $this->db->delete('Tab_Opcao_Select');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }	
	
    public function delete_produto($data) {

        $this->db->where_in('idTab_Opcao_Select', $data);
        $this->db->delete('Tab_Opcao_Select');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_procedimento($data) {

        $this->db->where_in('idTab_Opcao_Select', $data);
        $this->db->delete('Tab_Opcao_Select');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }	

    public function delete_derivados($data) {

        $this->db->where_in('idTab_Produtos', $data);
        $this->db->delete('Tab_Produtos');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }	
	
    public function delete_produtos($id) {

		$query = $this->db->delete('Tab_Produtos', array('idTab_Produtos' => $id));
        $query = $this->db->delete('Tab_Valor', array('idTab_Produtos' => $id));
		
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produtos_original($id) {

        $query = $this->db->delete('Tab_Atributo_Select', array('idTab_Produto' => $id));
		$query = $this->db->delete('Tab_Opcao_Select', array('idTab_Produto' => $id));
		$query = $this->db->delete('Tab_Produto', array('idTab_Produto' => $id));
        $query = $this->db->delete('Tab_Valor', array('idTab_Modelo' => $id));
        #$query = $this->db->delete('Tab_Cat_Prod', array('idTab_Produto' => $id));
        $query = $this->db->delete('Tab_Cor_Prod', array('idTab_Produto' => $id));
        $query = $this->db->delete('Tab_Tam_Prod', array('idTab_Produto' => $id));
		$query = $this->db->delete('Tab_Produtos', array('idTab_Produto' => $id));
		
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_tipoproduto($data) {
		$query = $this->db->query('SELECT TipoProduto FROM Tab_TipoProduto WHERE idTab_TipoProduto = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['TipoProduto'])) ? $query[0]['TipoProduto'] : FALSE;
    }
	
	public function select_produtos($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
            'SELECT
                TPV.idTab_Produto,
				CONCAT(IFNULL(TPV.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(TPV.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TPV.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
				TPV.ValorCompraProduto,
				TPV.Categoria
            FROM
                Tab_Produto AS TPV
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = TPV.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TPV.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TPV.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TPV.Prodaux1
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TPV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY  
				TPV.CodProd ASC,
				TPV.Categoria ASC,
				TP3.Prodaux3,				
				TPV.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2 
    ');
        } else {
            $query = $this->db->query(
            'SELECT
                TPV.idTab_Produto,
				CONCAT(IFNULL(TPV.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(TPV.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TPV.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
				TPV.ValorCompraProduto,
				TPV.Categoria
            FROM
                Tab_Produto AS TPV
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = TPV.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TPV.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TPV.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TPV.Prodaux1
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TPV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY  
				TPV.CodProd ASC,
				TPV.Categoria ASC,
				TP3.Prodaux3,				
				TPV.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2 
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->NomeProduto;
            }
        }

        return $array;
    }	

	public function select_prodaux33() {

        $query = $this->db->query('
            SELECT
                P.idTab_Prodaux3,
                P.Prodaux3
            FROM
                Tab_Prodaux3 AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Prodaux3 ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Prodaux3] = $row->Prodaux3;
        }

        return $array;
    }
}
