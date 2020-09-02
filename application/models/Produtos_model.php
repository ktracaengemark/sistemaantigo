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

    public function get_produtos($data) {
        $query = $this->db->query('
			SELECT  
				TP.idTab_Produto,
				TP.Produtos,
				TP.idSis_Usuario,
				TP.idSis_Empresa,
				TP.idTab_Modulo,
				TP.UnidadeProduto,
				TP.TipoProduto,
				TP.CodProd,
				TP.CodBarra,
				TP.Prodaux1,
				TP.Prodaux2,
				TP.Prodaux3,
				TP.Prodaux4,
				TP.Fornecedor,
				TP.ValorCompraProduto,
				TP.ValorProduto,
				TP.ValorProdutoSite,
				TP.Categoria,
				TP.Prod_Serv,
				TPRS.Prod_Serv AS TipoProdServ,
				TP.ProdutoProprio,
				TP.Aprovado,
				TP.Arquivo,
				TP.Ativo,
				TP.VendaBalcao,
				TP.VendaSite,
				TP.PesoProduto,
				TP.Comissao,
				TP.Desconto,
				TP.Atributo_1,
				TP.Atributo_2,
				TP.Atributo_3,
				CTP.Catprod
			FROM 
				Tab_Produto AS TP
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

    public function get_modelo($data) {
		$query = $this->db->query('SELECT * FROM Tab_Produto WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_valor($data) {
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
				TAS.idTab_Atributo_Select,
				TAS.idTab_Catprod,
				TAS.idTab_Atributo
			FROM 
				Tab_Atributo_Select AS TAS
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
	
    public function get_produto($data) {
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
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ",  IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,"")) AS NomeProduto
			FROM 
				Tab_Produtos AS TPS
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
	
    public function update_produtos($data, $id) {

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

    public function update_servico($data) {
		
        $query = $this->db->update_batch('Tab_Atributo_Select', $data, 'idTab_Atributo_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_opcao_select($data) {
		
        $query = $this->db->update_batch('Tab_Opcao_Select', $data, 'idTab_Opcao_Select');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function update_produto($data) {
		
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
