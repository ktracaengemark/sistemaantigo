// JavaScript Document

var date = new Date();
var d = date.getDate();
var m = date.getMonth() + 1;
var y = date.getFullYear();
var n = date.toISOString();
var tam = n.length - 5;
var agora = n.substring(0, tam);

//sequencia de comandos necessária para estrair a pasta raiz do endereço,
//ou seja, qual módulo está sendo utilizado (ex: salao, odonto, etc)
app = window.location.pathname;
app = app.substring(1);
pos = app.indexOf('/');
app = app.substring(0, pos);

//Captura a data do dia e carrega no campo correspondente
var currentDate = moment();

camposDisponiveis();

exibirentrega();

exibir();
exibir_confirmar();	
Aguardar();

function codigo(id, tabela){
	//alert('ok codigo');
	var categoria = $('#idTab_Catprod').val();
	var produto = $('#idTab_Produto').val();
	if(produto != 0){
		var nomeproduto = $('#Produtos').val();
	}else{
		var nomeproduto = "";
	}
	var variacao1 = $('#Opcao_Atributo_1').val();
	if(variacao1 != 0){
		var opcao1 = $('#Opcao1').val();
	}else{
		var opcao1 = "";
	}
	var variacao2 = $('#Opcao_Atributo_2').val();
	if(variacao2 != 0){
		var opcao2 = $('#Opcao2').val();
	}else{
		var opcao2 = "";
	}
	
	$('#Cod_Prod').val(categoria + ':' + produto + ':' + variacao1 + ':' + variacao2);
	$('#Nome_Prod').val(nomeproduto + ' ' + opcao1 + ' ' + opcao2);

    $.ajax({
		url: window.location.origin+ '/' + app + '/pesquisas/Pesquisa.php?q='+ tabela +'&id=' + id,
        dataType: "json",
        success: function (data) {
			if(tabela == "idTab_Produto"){
				nomeproduto = data[0]['nome'];
				$('#Produtos').val(nomeproduto);
			}else if(tabela == "Opcao_Atributo_1"){
				opcao1 = data[0]['nome'];
				$('#Opcao1').val(opcao1);
			}else if(tabela == "Opcao_Atributo_2"){
				opcao2 = data[0]['nome'];
				$('#Opcao2').val(opcao2);
			}
			$('#Nome_Prod').val(nomeproduto + ' ' + opcao1 + ' ' + opcao2);
			
		}
		
    });
	
	//$('#Nome_Prod').val(nomeproduto + ' ' + opcao1 + ' ' + opcao2);

}

//Função que desabilita a Mensagem de Aguardar.
function Aguardar () {
	$('.aguardar').hide();
	$('.aguardar1').hide();
	$('.aguardar2').hide();
	$('.aguardarsalvar').hide();
	$('.aguardarCatprom').hide();
	$('.aguardarCatprod').hide();
	$('.aguardarAtributo').hide();
	$('.aguardarOpcao').hide();
	$('.aguardarAlterarCatprom').hide();
	$('.aguardarAlterarCatprod').hide();
	$('.aguardarAlterarProduto').hide();
	$('.aguardarAlterarAtributo').hide();
	$('.aguardarAlterarOpcao').hide();
	$('.exibir').show();
	$('#botaoFechar2').show();
	$('#botaoSalvar').show();
}

function exibir(){
	
	$('.Mostrar').show();
	$('.NMostrar').hide();
	
}

function exibir_confirmar(){
	$('.Open').show();
	$('.Close').hide();
}

// Funções de cadastros auxiliares
$(document).ready(function(){
	
	$('#insert_motivo_form').on('submit', function(event){
		//alert('ok');
		event.preventDefault();
		if($('#Novo_Motivo').val() == "" || $('#Desc_Motivo').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-motivo").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			//Fechar o botão cadastrar
			$('#botaoCad').hide();
								
			//Fechar o botão fechar
			$('#botaoFechar').hide();
			
			//Abre o Aguardar
			$('.aguardar1').show();	
			
			//Receber os dados do formulário
			var dados = $("#insert_motivo_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/Motivo.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 1){
				
					//Limpar os campo
					$('#insert_motivo_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addMotivoModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadMotivoSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-motivo").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-motivo").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Motivo!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}	
	});
	
	$('#insert_categoria_form').on('submit', function(event){
		//alert('ok');
		event.preventDefault();
		if($('#Novo_Categoria').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-categoria").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			//Fechar o botão cadastrar
			$('#botaoCad').hide();
								
			//Fechar o botão fechar
			$('#botaoFechar').hide();
			
			//Abre o Aguardar
			$('.aguardar1').show();
			
			//Receber os dados do formulário
			var dados = $("#insert_categoria_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/Categoria.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 1){
				
					//Limpar os campo
					$('#insert_categoria_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addCategoriaModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadCategoriaSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-categoria").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-categoria").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Categoria!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}	
	});
	
	$('#insert_atividade_form').on('submit', function(event){
		//alert('ok');
		event.preventDefault();
		if($('#Novo_Atividade').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-atividade").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			//Fechar o botão cadastrar
			$('#botaoCad').hide();
								
			//Fechar o botão fechar
			$('#botaoFechar').hide();
			
			//Abre o Aguardar
			$('.aguardar1').show();	
					
			//Receber os dados do formulário
			var dados = $("#insert_atividade_form").serialize();
			//console.log(dados);

			$.post(window.location.origin+ '/' + app + '/cadastros/Atividade.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 1){
				
					//Limpar os campo
					$('#insert_atividade_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addAtividadeModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadAtividadeSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-atividade").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-atividade").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Atividade!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}
		
	});
	
	$('#insert_cliente_form').on('submit', function(event){
		//alert('ok');
		event.preventDefault();
		if($('#NomeCliente').val() == "" || $('#CelularCliente').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-cliente").html('<div class="alert alert-danger" role="alert">Necessário prencher Nome e Celular do Cliente!</div>');						
		}else{		
			
			var celular = $('#CelularCliente').val();
			var tamanho = celular.toString().length;
			//console.log(tamanho);
			
			if( tamanho == 11 ) {
				//Fechar o botão cadastrar
				$('#botaoCad').hide();
									
				//Fechar o botão fechar
				$('#botaoFechar').hide();
				
				//Abre o Aguardar
				$('.aguardar1').show();	
				
				//Receber os dados do formulário
				var dados = $("#insert_cliente_form").serialize();
				//console.log(dados);
				
				$.post(window.location.origin+ '/' + app + '/cadastros/Cliente.php?', dados, function (retorna){
				 //console.log(retorna);
					if(retorna == 5){
						//Limpar os campo
						$('#insert_cliente_form')[0].reset();
						
						//Fechar a janela modal cadastrar
						$('#addClienteModal').modal('hide');
									
						//Alerta de cadastro realizado com sucesso
						//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
						$('#msgClienteExiste').modal('show');
						
						//Limpar mensagem de erro
						$("#msg-error-cliente").html('');
						
						//listar_usuario(1, 50);
					}else if(retorna == 1){
						//Limpar os campo
						$('#insert_cliente_form')[0].reset();
						
						//Fechar a janela modal cadastrar
						$('#addClienteModal').modal('hide');
									
						//Alerta de cadastro realizado com sucesso
						//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
						$('#msgCadClienteSucesso').modal('show');
						
						//Limpar mensagem de erro
						$("#msg-error-cliente").html('');
						
						//listar_usuario(1, 50);
					}else{
						$("#msg-error-cliente").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Cliente!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
					}
					
				});
			}else{
				$("#msg-error-cliente").html('<div class="alert alert-danger" role="alert">O Celular deve conter 11 números!</div>');
			}
		}	
	});	
	
	$('#insert_fornecedor_form').on('submit', function(event){
		//alert('ok');
		event.preventDefault();
		if($('#NomeFornecedor').val() == "" || $('#CelularFornecedor').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-fornecedor").html('<div class="alert alert-danger" role="alert">Necessário prencher Nome e Celular do Fornecedor!</div>');						
		}else{		
			
			var celular = $('#CelularFornecedor').val();
			var tamanho = celular.toString().length;
			//console.log(tamanho);
			
			if( tamanho == 11 ) {
				//Fechar o botão cadastrar
				$('#botaoCad').hide();
									
				//Fechar o botão fechar
				$('#botaoFechar').hide();
				
				//Abre o Aguardar
				$('.aguardar1').show();	
				
				//Receber os dados do formulário
				var dados = $("#insert_fornecedor_form").serialize();
				//console.log(dados);
				
				$.post(window.location.origin+ '/' + app + '/cadastros/Fornecedor.php?', dados, function (retorna){
				 //console.log(retorna);
					if(retorna == 1){
						//Limpar os campo
						$('#insert_fornecedor_form')[0].reset();
						
						//Fechar a janela modal cadastrar
						$('#addFornecedorModal').modal('hide');
									
						//Alerta de cadastro realizado com sucesso
						//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
						$('#msgCadFornecedorSucesso').modal('show');
						
						//Limpar mensagem de erro
						$("#msg-error-fornecedor").html('');
						
						//listar_usuario(1, 50);
					}else{
						$("#msg-error-fornecedor").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Fornecedor!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
					}
					
				});
			}else{
				$("#msg-error-fornecedor").html('<div class="alert alert-danger" role="alert">O Celular deve conter 11 números!</div>');
			}
		}
		
	});	
	
	$('#insert_catprom_form').on('submit', function(event){
		//alert('ok');
		event.preventDefault();
		if($('#Novo_Catprom').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-catprom").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			//Fechar o botão cadastrar
			$('#botaoCadCatprom').hide();
								
			//Fechar o botão fechar
			$('#botaoFecharCatprom').hide();
			
			//Abre o Aguardar
			$('.aguardarCatprom').show();	
			
			//Receber os dados do formulário
			var dados = $("#insert_catprom_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/Catprom.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 1){
				
					//Limpar os campo
					$('#insert_catprom_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addCatpromModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-catprom").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-catprom").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar Categoria!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}	
	});
	
	$('#insert_catprod_form').on('submit', function(event){
		//alert('ok');
		event.preventDefault();
		if($('#Novo_Catprod').val() == "" || $('#TipoCatprod').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-catprod").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			//Fechar o botão cadastrar
			$('#botaoCadCatprod').hide();
								
			//Fechar o botão fechar
			$('#botaoFecharCatprod').hide();
			
			//Abre o Aguardar
			$('.aguardarCatprod').show();	
			
			//Receber os dados do formulário
			var dados = $("#insert_catprod_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/Catprod.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 1){
				
					//Limpar os campo
					$('#insert_catprod_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addCatprodModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-catprod").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-catprod").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar Categoria!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}	
	});
	
	$('#insert_produto_form').on('submit', function(event){
		//alert('ok');
		event.preventDefault();
		if($('#Novo_Produto').val() == "" || $('#idCat_Produto').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-produto").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			//Fechar o botão cadastrar
			$('#botaoCad').hide();
								
			//Fechar o botão fechar
			$('#botaoFechar').hide();
			
			//Abre o Aguardar
			$('.aguardar1').show();	
			
			//Receber os dados do formulário
			var dados = $("#insert_produto_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/Produto.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 1){
				
					//Limpar os campo
					$('#insert_produto_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addProdutoModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-produto").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-produto").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Produto!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}	
	});
	
	$('#insert_atributo_form').on('submit', function(event){
		//alert('ok');
		event.preventDefault();
		if($('#Novo_Atributo').val() == "" || $('#idCat_Atributo').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-atributo").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			//Fechar o botão cadastrar
			$('#botaoCadAtributo').hide();
								
			//Fechar o botão fechar
			$('#botaoFecharAtributo').hide();
			
			//Abre o Aguardar
			$('.aguardarAtributo').show();	
			
			//Receber os dados do formulário
			var dados = $("#insert_atributo_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/Atributo.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 1){
				
					//Limpar os campo
					$('#insert_atributo_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addAtributoModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-atributo").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-atributo").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar Atributo!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}	
	});
	
	$('#insert_opcao_form').on('submit', function(event){
		//alert('ok - Opcao');
		event.preventDefault();
		if($('#Novo_Opcao').val() == "" || $('#idAtributo_Opcao').val() == "" || $('#idCat_Opcao').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-opcao").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			//Fechar o botão cadastrar
			$('#botaoCadOpcao').hide();
								
			//Fechar o botão fechar
			$('#botaoFecharOpcao').hide();
			
			//Abre o Aguardar
			$('.aguardarOpcao').show();	
			
			//Receber os dados do formulário
			var dados = $("#insert_opcao_form").serialize();
			console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/Opcao.php?', dados, function (retorna){
			 console.log(retorna);
				if(retorna == 1){
				
					//Limpar os campo
					$('#insert_opcao_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addOpcaoModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-opcao").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-opcao").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar Opção!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}	
	});

	$('#alterarCatprom').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var recipientidcatprom = button.data('whateveridcatprom')
		var recipientcatprom = button.data('whatevercatprom')
		//console.log(recipientcatprom);
		var modal = $(this)
		modal.find('.modal-title').text('id da Categoria: ' + recipientidcatprom)
		modal.find('#id_Categoria').val(recipientidcatprom)
		modal.find('#Catprom').val(recipientcatprom)
	})
	
	$('#alterar_catprom_form').on('submit', function(event){
		//alert('ok - Alterar Categoria do Produto');
		
		event.preventDefault();
		var catprom = $('#Catprom').val();
		//console.log(catprom);
		//exit();
		
		if($('#Catprom').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-alterar-catprom").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			
			//Fechar a mensagem de erro
			$('#msg-error-alterar-catprom').hide();
			//Fechar o botão Alterar
			$('#AlterarCatprom').hide();
			//Fechar o botão Cancelar
			$('#CancelarCatprom').hide();
			//Abre o Aguardar
			$('.aguardarAlterarCatprom').show();
			//Fechar a janela modal alterar
			$('#addCatpromModal').modal('hide');
			
			//Receber os dados do formulário
			var dados = $("#alterar_catprom_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/edicoes/Catprom.php?', dados, function (retorna){
			 
				//console.log(retorna);
				
				if(retorna == 1){
				
					//Limpar os campo
					$('#alterar_catprom_form')[0].reset();
					
					//Fechar a janela modal alterar
					$('#alterarCatprom').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-alterar-catprom").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-alterar-catprom").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Categoria!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}
		
	});	

	$('#alterarCatprod').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var recipientidcatprod = button.data('whateveridcatprod')
		var recipientcatprod = button.data('whatevercatprod')
		//console.log(recipientcatprod);
		var modal = $(this)
		modal.find('.modal-title').text('id da Categoria: ' + recipientidcatprod)
		modal.find('#id_Categoria').val(recipientidcatprod)
		modal.find('#Catprod').val(recipientcatprod)
	})
	
	$('#alterar_catprod_form').on('submit', function(event){
		//alert('ok - Alterar Categoria do Produto');
		
		event.preventDefault();
		var catprod = $('#Catprod').val();
		//console.log(catprod);
		//exit();
		
		if($('#Catprod').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-alterar-catprod").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			
			//Fechar a mensagem de erro
			$('#msg-error-alterar-catprod').hide();
			//Fechar o botão Alterar
			$('#AlterarCatprod').hide();
			//Fechar o botão Cancelar
			$('#CancelarCatprod').hide();
			//Abre o Aguardar
			$('.aguardarAlterarCatprod').show();
			//Fechar a janela modal alterar
			$('#addCatprodModal').modal('hide');
			
			//Receber os dados do formulário
			var dados = $("#alterar_catprod_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/edicoes/Catprod.php?', dados, function (retorna){
			 
				//console.log(retorna);
				
				if(retorna == 1){
				
					//Limpar os campo
					$('#alterar_catprod_form')[0].reset();
					
					//Fechar a janela modal alterar
					$('#alterarCatprod').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-alterar-catprod").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-alterar-catprod").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Categoria!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}
		
	});	

	$('#alterarProduto').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var recipientidproduto = button.data('whateveridproduto')
		var recipientproduto = button.data('whateverproduto')
		var recipientvendasite = button.data('whatevervendasite')
		var recipientvendabalcao = button.data('whatevervendabalcao')
		//console.log(recipientvendasite);
		var modal = $(this)
		modal.find('.modal-title').text('id do Produto: ' + recipientidproduto)
		modal.find('#id_Produto').val(recipientidproduto)
		modal.find('#Produtos').val(recipientproduto)
		if(recipientvendasite == 'S'){
			//$("#VendaSite_Alterar_Sim").prop('checked', true);
			modal.find('#VendaSite_Alterar_Sim').prop('checked', true);
		}else if(recipientvendasite == 'N'){
			//$("#VendaSite_Alterar_Nao").prop('checked', true);
			modal.find('#VendaSite_Alterar_Nao').prop('checked', true);
		}
		if(recipientvendabalcao == 'S'){
			//$("#VendaBalcao_Alterar_Sim").prop('checked', true);
			modal.find('#VendaBalcao_Alterar_Sim').prop('checked', true);
		}else if(recipientvendabalcao == 'N'){
			//$("#VendaBalcao_Alterar_Nao").prop('checked', true);
			modal.find('#VendaBalcao_Alterar_Nao').prop('checked', true);
		}
	})
	
	$('#alterar_produto_form').on('submit', function(event){
		//alert('ok - Alterar o Produto');
		
		event.preventDefault();
		var produto = $('#Produtos').val();
		//var vendasite = $('#VendaSite').val();
		//console.log(vendasite);
		if($('#Produtos').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-alterar-produto").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			
			//Fechar a mensagem de erro
			$('#msg-error-alterar-produto').hide();
			//Fechar o botão Alterar
			$('#AlterarProduto').hide();
			//Fechar o botão Cancelar
			$('#CancelarProduto').hide();
			//Abre o Aguardar
			$('.aguardarAlterarProduto').show();
			//Fechar a janela modal alterar
			$('#addProdutoModal').modal('hide');
			
			//Receber os dados do formulário
			var dados = $("#alterar_produto_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/edicoes/Produto.php?', dados, function (retorna){
			 
				//console.log(retorna);
				
				if(retorna == 1){
				
					//Limpar os campo
					$('#alterar_produto_form')[0].reset();
					
					//Fechar a janela modal alterar
					$('#alterarProduto').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-alterar-produto").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-alterar-produto").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Produto!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}
		
	});	

	$('#alterarAtributo').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var recipientidatributo = button.data('whateveridatributo')
		var recipientatributo = button.data('whateveratributo')
		//console.log(recipientatributo);
		var modal = $(this)
		modal.find('.modal-title').text('id do Atributo: ' + recipientidatributo)
		modal.find('#id_Atributo').val(recipientidatributo)
		modal.find('#Atributo').val(recipientatributo)
	})
	
	$('#alterar_atributo_form').on('submit', function(event){
		//alert('ok - Alterar o Atributo');
		
		event.preventDefault();
		var atributo = $('#Atributo').val();
		//console.log(atributo);
		//exit();
		
		if($('#Atributo').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-alterar-atributo").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			
			//Fechar a mensagem de erro
			$('#msg-error-alterar-atributo').hide();
			//Fechar o botão Alterar
			$('#AlterarAtributo').hide();
			//Fechar o botão Cancelar
			$('#CancelarAtributo').hide();
			//Abre o Aguardar
			$('.aguardarAlterarAtributo').show();
			//Fechar a janela modal alterar
			$('#addAtributoModal').modal('hide');
			
			//Receber os dados do formulário
			var dados = $("#alterar_atributo_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/edicoes/Atributo.php?', dados, function (retorna){
			 
				//console.log(retorna);
				
				if(retorna == 1){
				
					//Limpar os campo
					$('#alterar_atributo_form')[0].reset();
					
					//Fechar a janela modal alterar
					$('#alterarAtributo').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-alterar-atributo").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-alterar-atributo").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Atributo!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}
		
	});	

	$('#alterarOpcao').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var recipientidopcao = button.data('whateveridopcao')
		var recipientopcao = button.data('whateveropcao')
		//console.log(recipientopcao);
		var modal = $(this)
		modal.find('.modal-title').text('id da Opcao: ' + recipientidopcao)
		modal.find('#id_Opcao').val(recipientidopcao)
		modal.find('#Opcao').val(recipientopcao)
	})
	
	$('#alterar_opcao_form').on('submit', function(event){
		//alert('ok - Alterar a Opcao');
		
		event.preventDefault();
		var opcao = $('#Opcao').val();
		//console.log(opcao);
		//exit();
		
		if($('#Opcao').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-alterar-opcao").html('<div class="alert alert-danger" role="alert">Necessário prencher todos os campos!</div>');						
		}else{
			
			//Fechar a mensagem de erro
			$('#msg-error-alterar-opcao').hide();
			//Fechar o botão Alterar
			$('#AlterarOpcao').hide();
			//Fechar o botão Cancelar
			$('#CancelarOpcao').hide();
			//Abre o Aguardar
			$('.aguardarAlterarOpcao').show();
			//Fechar a janela modal alterar
			$('#addOpcaoModal').modal('hide');
			
			//Receber os dados do formulário
			var dados = $("#alterar_opcao_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/edicoes/Opcao.php?', dados, function (retorna){
			 
				console.log(retorna);
				
				if(retorna == 1){
				
					//Limpar os campo
					$('#alterar_opcao_form')[0].reset();
					
					//Fechar a janela modal alterar
					$('#alterarOpcao').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-alterar-opcao").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-alterar-opcao").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Opcao!<br>Entre em contato com o Suporte Técnico do Sistema.</div>');
				}
				
			});
			
		}
		
	});	
	
});

//Função que desabilita o botão fechar após 1 click, evitando mais de um envio de formulário.
function DesabilitaBotaoSalvar () {	
	$('#botaoSalvar').hide();
	$('.aguardarsalvar').show();
}

//Função que desabilita o botão fechar após 1 click, evitando mais de um envio de formulário.
function DesabilitaBotaoFechar () {	
	$('#botaoFechar2').hide();
	$('.aguardar2').show();
}

function dateDiff() {
	
	var dataorca = $('#DataOrca').val();
	var dataentregaorca = $('#DataEntregaOrca').val();
	
	// Digamos que este é o formato das suas datas
	// data = '30/03/2019';
	// Precisamos quebrar a string para retornar cada parte
	const dataorcaSplit = dataorca.split('/');

	const day = dataorcaSplit[0]; 
	const month = dataorcaSplit[1];
	const year = dataorcaSplit[2];
	
	const dataentregaorcaSplit = dataentregaorca.split('/');

	const day2 = dataentregaorcaSplit[0]; 
	const month2 = dataentregaorcaSplit[1]; 
	const year2 = dataentregaorcaSplit[2]; 

// Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
	dataorca = new Date(year, month - 1, day);
	dataentregaorca = new Date(year2, month2 - 1, day2);
	
	const now = new Date(); // Data de hoje
	const past = dataorca; // Outra data no passado
	const past2 = dataentregaorca; // Outra data no passado
	const diff = Math.abs(past2.getTime() - past.getTime()); // Subtrai uma data pela outra
	const days = Math.ceil(diff / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).

	// Mostra a diferença em dias
	//console.log('Prazo de entrega: ' + days + ' dias');	
	$('#PrazoEntrega').val(days);
}

function parseDate(texto) {
  let dataDigitadaSplit = texto.split("/");

  let dia = dataDigitadaSplit[0];
  let mes = dataDigitadaSplit[1];
  let ano = dataDigitadaSplit[2];


  if (ano.length < 4 && parseInt(ano) < 50) {
    ano = "20" + ano;
  } else if (ano.length < 4 && parseInt(ano) >= 50) {
    ano = "19" + ano;
  }
  ano = parseInt(ano);
  mes = mes - 1;

  return new Date(ano, mes, dia);
}

//Funcao das datas
function addData() {
	var dataDigitada = $('#Data').val();
  //var dataDigitada = document.getElementById('Data').value;
	console.log('Data teste: ' + dataDigitada);
  //Pegar data Atual para somar
  var currentDate = parseDate(dataDigitada);

  //pegar data atual para exibir
  var currentDate1 = new Date();

  //Capturar Quantidade de meses
  var meses = "1";
  //Parse Int dos meses
  var a = parseInt(meses);


  //Adicionar meses 
  currentDate.setMonth(currentDate.getMonth() + a);

  //Trazer data Atual
  currentDate1.setDate(currentDate1.getDate());



  //Exibir data Atual
  document.getElementById('data').value = currentDate1.toLocaleDateString();


  //Exibir a data ja atualizada
  document.getElementById('dataAtualizada').value = currentDate.toLocaleDateString();

}

function dateTermina() {
	
	var dataorca = $('#Data').val();
	// Digamos que este é o formato das suas datas
	// data = '30/03/2019';
	// Precisamos quebrar a string para retornar cada parte
	const dataorcaSplit = dataorca.split('/');
	const day = dataorcaSplit[0]; 
	const month = dataorcaSplit[1];
	const year = dataorcaSplit[2];
	// Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
	dataorca = new Date(year, month - 1, day);
	
	var primeira = new Date(year, month - 1, day);
	var ultima = new Date(year, month - 1, day);
	//console.log('Data Inicial: ' + datainicial);

	var intervalo = $('#Intervalo').val();
	var inter_int = parseInt(intervalo);
	var escala1 = $('#Tempo').val();	
	
	var periodo = $('#Periodo').val();
	var peri_int = parseInt(periodo);
	var escala2 = $('#Tempo2').val();
	
	if(escala1 == 1){
		primeira.setDate(primeira.getDate()+inter_int);
	}else if(escala1 == 2){
		primeira.setDate(primeira.getDate()+(inter_int*7));
	}else if(escala1 == 3){
		primeira.setMonth(primeira.getMonth()+inter_int);
	}else if(escala1 == 4){
		primeira.setFullYear(primeira.getFullYear()+inter_int);
	}
	
	if(escala2 == 1){
		ultima.setDate(ultima.getDate()+peri_int);
	}else if(escala2 == 2){
		ultima.setDate(ultima.getDate()+(peri_int*7));
	}else if(escala2 == 3){
		ultima.setMonth(ultima.getMonth()+peri_int);
	}else if(escala2 == 4){
		ultima.setFullYear(ultima.getFullYear()+peri_int);
	}
	
	var primeiraedit = primeira.toLocaleDateString();
	//console.log('Primeira Editada: ' + primeiraedit);
	$('#DataMinima').val(primeiraedit);		
	
	var ultimaedit = ultima.toLocaleDateString();
	//console.log('Ultima Editada: ' + ultimaedit);
	$('#DataTermino').val(ultimaedit);
	
	const primeiraeditSplit = primeiraedit.split('/');
	const dayP = primeiraeditSplit[0]; 
	const monthP = primeiraeditSplit[1]; 
	const yearP = primeiraeditSplit[2]; 

	// Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
	primeiraedit = new Date(yearP, monthP - 1, dayP);	
	//console.log('Primeira Y-m-d: ' + primeiraedit);
	
	const ultimaeditSplit = ultimaedit.split('/');
	const dayU = ultimaeditSplit[0]; 
	const monthU = ultimaeditSplit[1]; 
	const yearU = ultimaeditSplit[2]; 

	// Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
	ultimaedit = new Date(yearU, monthU - 1, dayU);	
	//console.log('Ultimo Y-m-d: ' + ultimaedit);	
	
	
	const pastI = dataorca; // Outra data no passado
	
	const pastP = primeiraedit; // Outra data no passado
	const diffP = Math.abs(pastP.getTime() - pastI.getTime()); // Subtrai uma data pela outra
	const daysP = Math.ceil(diffP / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).	
	//console.log('Tempo Primeira: ' + daysP + ' dias');
	

	const pastU = ultimaedit; // Outra data no passado
	const diffU = Math.abs(pastU.getTime() - pastI.getTime()); // Subtrai uma data pela outra
	const daysU = Math.ceil(diffU / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).	
	//console.log('Tempo Ultimo: ' + daysU + ' dias');	
	
	var ocorrencias = Math.ceil(daysU/daysP);
	//console.log('Ocorrências: ' + ocorrencias + ' Vez(es)');
	$('#Recorrencias').val(ocorrencias);

}

function exibirentrega() {
		$('.Exibir').hide();
		$('.QtdSoma').hide();
		$('.FormaPag').hide();
		$('.Liga').show();
		$('.Desliga').hide();
		$('.Correios').hide();
		$('.Combinar').hide();
		$('.Retirada').show();
		$('.Calcular').show();
		$('.Recalcular').hide();		
}

function formaPag(formapag){
	//alert('teste FormaPag');
	//console.log(formapag);
	if(formapag == "P"){
		$('.FormaPag').show();
	}else{
		$('.FormaPag').hide();
	}
}

function exibirTroco(pagocom){
	//alert('teste');
	//console.log(pagocom);
	if(pagocom == "7"){
		$('.Exibir').show();
	}else{
		$('.Exibir').hide();
	}
}

function tipoFrete(tipofrete){
	var RecarregaCepDestino = $('#RecarregaCepDestino').val();
	var RecarregaLogradouro = $('#RecarregaLogradouro').val();
	var RecarregaNumero = $('#RecarregaNumero').val();
	var RecarregaComplemento = $('#RecarregaComplemento').val();
	var RecarregaBairro = $('#RecarregaBairro').val();
	var RecarregaCidade = $('#RecarregaCidade').val();
	var RecarregaEstado = $('#RecarregaEstado').val();

	if(tipofrete == "1"){
		$('.Liga').show();
		$('.Desliga').hide();
		$('.Correios').hide();
		$('.Combinar').hide();
		$('.Retirada').show();
		$('.finalizar').show();			
		$('#Cep').val('00000000');
		$('#CepDestino').val(RecarregaCepDestino);
		$('#Logradouro').val(RecarregaLogradouro);
		$('#Numero').val(RecarregaNumero);
		$('#Complemento').val(RecarregaComplemento);
		$('#Bairro').val(RecarregaBairro);
		$('#Cidade').val(RecarregaCidade);
		$('#Estado').val(RecarregaEstado);
		$('#valorfrete').val('0.00');
		$('#prazoentrega').val('0');
		
	}		

	if(tipofrete == "2"){
		$('.Liga').hide();
		$('.Desliga').show();
		$('.Correios').hide();
		$('.Combinar').show();
		$('.Retirada').hide();
		$('.finalizar').show();			
		$('#Cep').val('00000000');
		$('#CepDestino').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');
		$('#valorfrete').val('0.00');
		$('#prazoentrega').val('0');			
	}
	
	if(tipofrete == "3"){
		$('.Liga').hide();
		$('.Desliga').show();
		$('.Correios').show();
		$('.Combinar').hide();
		$('.Retirada').hide();
		$('.Calcular').show();
		$('.Recalcular').hide();			
		$('.finalizar').hide();
		$('#Cep').val('');
		$('#CepDestino').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');
		$('#valorfrete').val('');
		$('#prazoentrega').val('');
		$('#valor_total').val('');
		$('#msg').html('');
	}		

}

function buscaEnderecoCliente(id) {
	//console.log(id);
	//exit();
    $.ajax({

		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=100&idCliente=' + id,
        //url: window.location.origin+ '/' + app + '/EnderecoCliente_json.php?q=100&idCliente=' + id,
		// dataType json
        dataType: "json",
		//method:'get',
        // função para de sucesso
        success: function (data) {
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {
					//console.log( data[i].enderecocliente);
					$('#Cep').val(data[i].cepcliente);
                    $('#Logradouro').val(data[i].enderecocliente);
					$('#Numero').val(data[i].numerocliente);
					$('#Complemento').val(data[i].complementocliente);
					$('#Bairro').val(data[i].bairrocliente);
					$('#Cidade').val(data[i].municipiocliente);
					$('#Estado').val(data[i].estadocliente);
					$('#Referencia').val(data[i].referenciacliente);
                    break;
                }

            }//fim do laço
		}
		
    });//termina o ajax
	
}

function buscaEnderecoFornecedor(id) {
	//console.log(id);
	//exit();
    $.ajax({

		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=110&idFornecedor=' + id,
		// dataType json
        dataType: "json",
		//method:'get',
        // função para de sucesso
        success: function (data) {
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {
					//console.log( data[i].enderecofornecedor);
					$('#Cep').val(data[i].cepfornecedor);
                    $('#Logradouro').val(data[i].enderecofornecedor);
					$('#Numero').val(data[i].numerofornecedor);
					$('#Complemento').val(data[i].complementofornecedor);
					$('#Bairro').val(data[i].bairrofornecedor);
					$('#Cidade').val(data[i].municipiofornecedor);
					$('#Estado').val(data[i].estadofornecedor);
					$('#Referencia').val(data[i].referenciafornecedor);
                    break;
                }

            }//fim do laço
		}
		
    });//termina o ajax
	
}

function Procuraendereco() {
	//alert('Procuraendereco - funcionando');
	var Dados=$(this).serialize();
	var CepDestino=$('#Cep').val();
	var CepOrigem=$('#CepOrigem').val();
	//console.log(CepOrigem);
	$.ajax({
		url: 'https://viacep.com.br/ws/'+CepDestino+'/json/',
		method:'get',
		dataType:'json',
		data: Dados,
		success:function(Dados){
			//console.log(Dados);
			$('.ResultCep').html('').append('<div>'+Dados.logradouro+','+Dados.bairro+'-'+Dados.localidade+'-'+Dados.uf+'</div>');			
			//$('#Cep').val(CepDestino);
			$('#Logradouro').val(Dados.logradouro);
			$('#Numero').val('');
			$('#Complemento').val('');
			$('#Bairro').val(Dados.bairro);
			$('#Cidade').val(Dados.localidade);
			$('#Estado').val(Dados.uf);
			$('#Referencia').val('');
		},
		error:function(Dados){
			alert('Cep não encontrado. Tente Novamente');
			$('#Cep').val('');
		}
	});
}

function LoadFrete() {
	var dataorca = $('#DataOrca').val();
		const dataorcaSplit = dataorca.split('/');
		const day = dataorcaSplit[0]; 
		const month = dataorcaSplit[1];
		const year = dataorcaSplit[2];
	var datapedido = new Date(year, month - 1, day);
	var TotalOrca = $('#ValorRestanteOrca').val();
	var CepDestino = $('#Cep').val();
	var CepOrigem = $('#CepOrigem').val();
	var Peso = $('#Peso').val();
	var Formato = $('#Formato').val();
	var Comprimento = $('#Comprimento').val();
	var Altura = $('#Altura').val();
	var Largura = $('#Largura').val();
	var MaoPropria = $('#MaoPropria').val();
	var ValorDeclarado = $('#ValorDeclarado').val();
	var AvisoRecebimento = $('#AvisoRecebimento').val();
	var Codigo = $('#Codigo').val();
	var Diametro = $('#Diametro').val();

	$.ajax({
		url: '../calcula-frete_model.php',
		type:'POST',
		dataType:'html',
		cache: false,
		data: {CepDestino: CepDestino, 
				CepOrigem: CepOrigem, 
				Peso: Peso, 
				Formato: Formato,
				Comprimento: Comprimento,
				Altura: Altura,
				Largura: Largura,
				MaoPropria: MaoPropria,
				ValorDeclarado: ValorDeclarado,
				AvisoRecebimento: AvisoRecebimento,
				Codigo: Codigo,
				Diametro: Diametro},
		success:function(data){
			//console.log(data);
			$('.ResultadoPrecoPrazo').html(data);
			
			var prazo_entrega = $('#prazo_entrega').val();
			$('#PrazoEntrega').val(prazo_entrega);
			
			var valor_frete2 = $('#valor_frete').val();
			$('#ValorFrete').val(valor_frete2);
			
			var valor_orca3 	= TotalOrca.replace(',','.');
			
			var valor_frete3 	= valor_frete2.replace(',','.');
			
			var totalpedido	= parseFloat(valor_frete3) + parseFloat(valor_orca3);
			
			var totalpedido2	= totalpedido.toFixed(2);
			
			var totalpedido3 = totalpedido2.replace('.',',');
			$('#ValorTotalOrca').val(totalpedido3);
			
			//var d = new Date();
			var d = new Date(datapedido);
			var data_entrega    = new Date(d.getTime() + (prazo_entrega * 24 * 60 * 60 * 1000));
			
			var mes = (data_entrega.getMonth() + 1);
			if(mes < 10){
				var novo_mes = "0" + mes;
			}else{
				var novo_mes = mes;
			}
			
			var dia = (data_entrega.getDate());
			if(dia < 10){
				var novo_dia = "0" + dia;
			}else{
				var novo_dia = dia;
			}
			
			var data_aparente = novo_dia + "/" + novo_mes + "/" + data_entrega.getFullYear();
			$('#DataEntregaOrca').val(data_aparente);

			if(valor_frete > "0.00"){
				$('#msg').html('<p style="color: green">Cálculo realizada com Sucesso!!</p>');
				$('.finalizar').show();
			}else{
				$('#msg').html('<p style="color: #FF0000">Erro ao realizar o Cálculo!!</p>');
				$('.finalizar').hide();
				//window.location = 'entrega.php';
			}
			
			$('#Cep').val(CepDestino);
			
		}, beforeSend: function(){
		
		}, error: function(jqXHR, textStatus, errorThrown){
			//console.log('Erro');
			$('#msg').html('<p style="color: #FF0000">Erro ao realizar o Cálculo!!</p>');
			//window.location = 'entrega.php';
			alert('Erro ao calcular. Tente Novamente');
			$('#Cep').val('');
		}
	});
	
}

//Função que desabilita os campos não disponiveis.
function camposDisponiveis () {
	$('.campos').hide();
	//document.getElementById('campos').style.display = "none";
	
}

//variável de opções necessária para o funcionamento do datepiker em divs
//geradas dinamicamente
var dateTimePickerOptions = {
    tooltips: {
        today: 'Hoje',
        clear: 'Limpar seleção',
        close: 'Fechar este menu',
        selectMonth: 'Selecione um mês',
        prevMonth: 'Mês anterior',
        nextMonth: 'Próximo mês',
        selectYear: 'Selecione um ano',
        prevYear: 'Ano anterior',
        nextYear: 'Próximo ano',
        selectDecade: 'Selecione uma década',
        prevDecade: 'Década anterior',
        nextDecade: 'Próxima década',
        prevCentury: 'Centenário anterior',
        nextCentury: 'Próximo centenário',
        incrementHour: 'Aumentar hora',
        decrementHour: 'Diminuir hora',
        incrementMinute: 'Aumentar minutos',
        decrementMinute: 'Diminuir minutos',
        incrementSecond: 'Aumentar segundos',
        decrementSecond: 'Diminuir segundos'
    },
    showTodayButton: true,
    showClose: true,
    format: 'DD/MM/YYYY',
    //minDate: moment(m + '/' + d + '/' + y),
    locale: 'pt-br'
}


//Função que desabilita o botão submit após 1 click, evitando mais de um envio de formulário.
function DesabilitaBotao (valor) {
	$('.aguardar').show();
	$('.exibir').hide();
	//document.getElementById('aguardar').style.display = "";
    if (valor) {
        document.getElementById('submeter').style.display = "none";
		document.getElementById('submeter2').style.display = "none";
		document.getElementById('submeter5').style.display = "none";
		document.getElementById('submeter6').style.display = "none";
		document.getElementById('submeter7').style.display = "none";
		document.getElementById('submeter8').style.display = "none";
        document.getElementById('aguardar').style.display = "";		
    }
    else {
        document.getElementById('submeter').style.display = "";
		document.getElementById('submeter2').style.display = "";
		document.getElementById('submeter5').style.display = "";
		document.getElementById('submeter6').style.display = "";
		document.getElementById('submeter7').style.display = "";
		document.getElementById('submeter8').style.display = "";
        document.getElementById('aguardar').style.display = "none";
    }
}

function DesabilitaBotaoExcluir (valor) {
    $('.aguardar').hide();
	$('.exibir').show();
    if (valor) {
        document.getElementById('submeter').style.display = "none";
		document.getElementById('submeter2').style.display = "none";
		document.getElementById('submeter3').style.display = "none";
		document.getElementById('submeter4').style.display = "none";
		document.getElementById('submeter5').style.display = "none";
		document.getElementById('submeter6').style.display = "none";
		document.getElementById('submeter7').style.display = "none";
		document.getElementById('submeter8').style.display = "none";
        document.getElementById('aguardar').style.display = "";
    }
    else {
        document.getElementById('submeter').style.display = "";
		document.getElementById('submeter2').style.display = "";
		document.getElementById('submeter3').style.display = "";
		document.getElementById('submeter4').style.display = "";
		document.getElementById('submeter5').style.display = "";
		document.getElementById('submeter6').style.display = "";
		document.getElementById('submeter7').style.display = "";
		document.getElementById('submeter8').style.display = "";
        document.getElementById('aguardar').style.display = "none";
    }
}

/*Atualiza o somatório do Qtd no Orcatrata*/
function calculaQtdSoma(campo, soma, somaproduto, excluir, produtonum, countmax, adicionar, hidden) {

    qtdsoma = 0;
    i = j = 1;

    if(excluir == 1){
        for(k=0; k<$("#"+countmax).val(); k++) {
            /*
            if(($("#"+hidden+i).val()))
                console.log('>> existe '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            else
                console.log('>> não '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            */
            if(i != produtonum && ($("#"+campo+i).val())) {
                qtdsoma += parseInt($("#"+campo+i).val());
                j++;
            }
            i++;
        }
    }
    else {
        if(adicionar)
            $("#"+countmax).val((parseInt($("#"+countmax).val())+1));

        for(k=1; k<=$("#"+countmax).val(); k++) {
            if($("#"+campo+k).val()) {
                qtdsoma += parseInt($("#"+campo+k).val());
                j++;
            }
            //j++;
        }
    }

	$("#"+soma).html(qtdsoma);
    $("#"+somaproduto).html(j-1);
    //console.log('>> ' + qtdsoma);
	
	if(qtdsoma >= 1){
		$('.QtdSoma').show();
	}else{
		$('.QtdSoma').hide();
	}
}

/*Atualiza o somatório do Qtd Devolvido no Orcatrata*/
function calculaQtdSomaDev(campo, soma, somaproduto, excluir, produtonum, countmax, adicionar, hidden) {

    qtdsoma = 0;
    i = j = 1;

    if(excluir == 1){
        for(k=0; k<$("#"+countmax).val(); k++) {
            /*
            if(($("#"+hidden+i).val()))
                console.log('>> existe '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            else
                console.log('>> não '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            */
            if(i != produtonum && ($("#"+campo+i).val())) {
                qtdsoma += parseInt($("#"+campo+i).val());
                j++;
            }
            i++;
        }
    }
    else {
        if(adicionar)
            $("#"+countmax).val((parseInt($("#"+countmax).val())+1));

        for(k=1; k<=$("#"+countmax).val(); k++) {
            if($("#"+campo+k).val()) {
                qtdsoma += parseInt($("#"+campo+k).val());
                j++;
            }
            //j++;
        }
    }

    $("#"+soma).html(qtdsoma);
    $("#"+somaproduto).html(j-1);
    //console.log('>> ' + qtdsoma);

}

/*
 * Função responsável por carregar valores nos respectivos campos do orcatrata
 * caso o botão Quitado seja alterado para SIM
 *
 * @param {int} quant
 * @param {string} campo
 * @param {int} num
 * @returns {decimal}
 */

 /*Carrega a Data do Dia do lançamento*/
 function carregaQuitado3(value, name, i, cadastrar = 0) {

    if (value == "S") {


        if (!$("#DataProcedimento"+i).val()) {
            if (cadastrar == 1)
                $("#DataProcedimento"+i).val($("#DataProcedimentoCli"+i).val())
            else
                $("#DataProcedimento"+i).val(currentDate.format('DD/MM/YYYY'))
        }


    }
    else {

        $("#DataProcedimento"+i).val("")

    }

}

 /*Carrega a Data do Dia do lançamento*/
 function carregaQuitado2(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#ValorPago"+i).val() || $("#ValorPago"+i).val() == "0,00")
            $("#ValorPago"+i).val($("#ValorParcela"+i).val())

        if (!$("#DataPago"+i).val()) {
            if (cadastrar == 1){
				$("#DataPago"+i).val($("#DataVencimento"+i).val());
			}else if(cadastrar == 2){
				$("#DataPago"+i).val("");
			}else{
				$("#DataPago"+i).val(currentDate.format('DD/MM/YYYY'));
			}
                
        }


    }
    else {

        $("#ValorPago"+i).val("")
        $("#DataPago"+i).val("")

    }

}

/*Carrega a Data do Dia do Vencimento*/
function carregaQuitado(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#ValorPago"+i).val() || $("#ValorPago"+i).val() == "0,00")
            $("#ValorPago"+i).val($("#ValorParcela"+i).val())

		if (!$("#DataPago"+i).val()) {
            if (cadastrar == 1)
                $("#DataPago"+i).val($("#DataVencimento"+i).val())
            else
                $("#DataPago"+i).val($("#DataVencimento"+i).val())
        }

    }
    else {

        $("#ValorPago"+i).val("")
        $("#DataPago"+i).val("")

    }

}

 /*Carrega a Data e Hora da Entrega do Produto*/
 function carregaEntreguePrd(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#DataConcluidoProduto"+i).val() || !$("#HoraConcluidoProduto"+i).val()) {
            if (cadastrar == 1){
				$("#DataConcluidoProduto"+i).val("");
				$("#HoraConcluidoProduto"+i).val("");
			}else{
				$("#DataConcluidoProduto"+i).val(currentDate.format('DD/MM/YYYY'));
				$("#HoraConcluidoProduto"+i).val(currentDate.format('HH:mm'));
			}  
        }
    }else{
        $("#DataConcluidoProduto"+i).val("");
        $("#HoraConcluidoProduto"+i).val("");
    }
	
}

 /*Carrega a Data e Hora da Entrega do Serviço*/
 function carregaEntregueSrv(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#DataConcluidoServico"+i).val() || !$("#HoraConcluidoServico"+i).val()) {
            if (cadastrar == 1){
				$("#DataConcluidoServico"+i).val("");
				$("#HoraConcluidoServico"+i).val("");
			}else{
				$("#DataConcluidoServico"+i).val(currentDate.format('DD/MM/YYYY'));
				$("#HoraConcluidoServico"+i).val(currentDate.format('HH:mm'));
			}    
        }
    }else {
        $("#DataConcluidoServico"+i).val("");
        $("#HoraConcluidoServico"+i).val("");
    }

}

 /*Carrega a Data e Hora da Conclusão da Tarefa*/
 function carregaConcluido(value, name, cadastrar = 0) {
    if (value == "S") {
		if (cadastrar == 1){
			$("#DataConcluidoProcedimento").val($("#DataProcedimento").val());
			$("#HoraConcluidoProcedimento").val($("#HoraProcedimento").val());
		}else{
			$("#DataConcluidoProcedimento").val(currentDate.format('DD/MM/YYYY'));
			$("#HoraConcluidoProcedimento").val(currentDate.format('HH:mm'));
		}
    }else{
        $("#DataConcluidoProcedimento").val("");
        $("#HoraConcluidoProcedimento").val("");
    }
	
}

 /*Carrega a Data e Hora da Conclusão do procedimento*/
 function carregaConclProc(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#DataConcluidoProcedimento"+i).val()) {
            if (cadastrar == 1){
				$("#DataConcluidoProcedimento"+i).val($("#DataProcedimento"+i).val());
				$("#HoraConcluidoProcedimento"+i).val($("#HoraProcedimento"+i).val());
			}else{
				$("#DataConcluidoProcedimento"+i).val(currentDate.format('DD/MM/YYYY'));
				$("#HoraConcluidoProcedimento"+i).val(currentDate.format('HH:mm'));
			}  
        }
    }else{
        $("#DataConcluidoProcedimento"+i).val("");
        $("#HoraConcluidoProcedimento"+i).val("");
    }
	
}

 /*Carrega a Data e Hora da Entrega do Produto*/
 function carregaConclSubProc(value, name, i, cadastrar = 0) {

    if (value == "S") {
		if (cadastrar == 1){
			$("#DataConcluidoSubProcedimento"+i).val($("#DataSubProcedimento"+i).val());
			$("#HoraConcluidoSubProcedimento"+i).val($("#HoraSubProcedimento"+i).val());
		}else{
			$("#DataConcluidoSubProcedimento"+i).val(currentDate.format('DD/MM/YYYY'));
			$("#HoraConcluidoSubProcedimento"+i).val(currentDate.format('HH:mm'));
		}
    }else{
        $("#DataConcluidoSubProcedimento"+i).val("");
        $("#HoraConcluidoSubProcedimento"+i).val("");
    }
	
}

 /*Carrega a Data e Hora da Entrega do Produto*/
 function carregaDataPagoComissaoOrca(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#DataPagoComissaoOrca"+i).val()) {
            if (cadastrar == 1){
				$("#DataPagoComissaoOrca"+i).val("")
			}else{
				$("#DataPagoComissaoOrca"+i).val(currentDate.format('DD/MM/YYYY'));
			}  
        }
    }else{
        $("#DataPagoComissaoOrca"+i).val("");
    }
	
}
/*
 * Função responsável por aplicar a máscara de valor real com separação de
 * decimais e milhares.
 *
 * @param {float} value
 * @returns {decimal}
 */
function mascaraValorReal(value) {

    var r;

    r = value.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    r = r.replace(/[,.]/g, function (m) {
        // m is the match found in the string
        // If `,` is matched return `.`, if `.` matched return `,`
        return m === ',' ? '.' : ',';
    });

    return r;

}

/*
 * Função responsável por calcular o subtotal dos campos de produto
 *
 * @param {int} quant
 * @param {string} campo
 * @param {int} num
 * @returns {decimal}
 */
function calculaResta(entrada) {

    //recebe o valor do orçamento
    var orcamento = $("#ValorOrca").val();
	var devolucao = $("#ValorDev").val();
    var resta = -(-orcamento.replace(".","").replace(",",".") - devolucao.replace(".","").replace(",","."));

    resta = mascaraValorReal(resta);

    //o valor é escrito no seu campo no formulário
    $('#ValorRestanteOrca').val(resta);
	calculaParcelas();
	calculaTotal();
}

function calculaTotal(entrada) {
	//recebe o Nivel da Empresa
	var nivelempresa = $("#NivelEmpresa").val();
	//console.log(nivelempresa +' - Nível da Empresa');
    
	//recebe o valor do orçamento
    var valorextraorca = $("#ValorExtraOrca").val();
	//console.log(valorextraorca +' - Valor extra');
    var orcamento = $("#ValorRestanteOrca").val();
	//console.log(orcamento +' - Valor Prd+Srv');
	var devolucao = $("#ValorFrete").val();
	if(nivelempresa >= 4){
		var restaT = -(- devolucao.replace(".","").replace(",",".") - orcamento.replace(".","").replace(",",".") - valorextraorca.replace(".","").replace(",","."));
		var valorsomaorca = -(- valorextraorca.replace(".","").replace(",",".") - orcamento.replace(".","").replace(",","."));
	}else{
		var restaT = -(- valorextraorca.replace(".","").replace(",","."));
		var valorsomaorca = -(- valorextraorca.replace(".","").replace(",","."));
	}
    restaT = mascaraValorReal(restaT);
	//console.log(restaT +' - Valor Total');
	
	valorsomaorca = mascaraValorReal(valorsomaorca);
	//console.log(valorsomaorca +' - Valor soma');

    //o valor é escrito no seu campo no formulário
    $('#ValorSomaOrca').val(valorsomaorca);
	$('#ValorTotalOrca').val(restaT);
	
	calculaParcelas();
}

function calculaTroco(entrada) {

    //recebe o valor do orçamento
    //var orcamento = $("#ValorRestanteOrca").val();
	var orcamento = $("#ValorTotalOrca").val();
	var devolucao = $("#ValorDinheiro").val();
    var resta = (devolucao.replace(".","").replace(",",".") - orcamento.replace(".","").replace(",","."));

    resta = mascaraValorReal(resta);

    //o valor é escrito no seu campo no formulário
    $('#ValorTroco').val(resta);

}


/*
 * Função responsável por calcular as parcelas do orçamento em função do dados
 * informados no formulário (valor restante / parcelas e datas do vencimento)
 */
 
function adicionaDias(mod) {
    //alert();
	
	$(".input_fields_dias").empty();

    //gera os campos de parcelas
    for (i=1; i<=7; i++) {
		
		//var dia = i;
		if (i == 1){
			var dia_semana = 'SEGUNDA';
		}else if(i == 2){
			var dia_semana = 'TERCA';
		}else if(i == 3){
			var dia_semana = 'QUARTA';
		}else if(i == 4){
			var dia_semana = 'QUINTA';
		}else if(i == 5){
			var dia_semana = 'SEXTA';
		}else if(i == 6){
			var dia_semana = 'SABADO';
		}else if(i == 7){
			var dia_semana = 'DOMINGO';
		}

        $(".input_fields_dias").append('\
            <div class="col-md-2">\
				<div class="panel panel-warning">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-12">\
								<label for="Aberto_Prom">'+dia_semana+'</label><br>\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_Aberto_Prom'+i+'" id="radio_Aberto_Prom'+i+'N">\
									<input type="radio" name="Aberto_Prom'+i+'" id="rdgrldnmc_add_dias"\
										 autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_Aberto_Prom'+i+'" id="radio_Aberto_Prom'+i+'S">\
									<input type="radio" name="Aberto_Prom'+i+'" id="rdgrldnmc_add_dias"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>'
        );

    }
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="rdgrldnmc_add_dias"]').change(function() {

        var value_add_dias = $(this).val();
        var name_add_dias = $(this).attr("name");

        //console.log(value_add_dias + ' <<>> ' + name);

        $('label[name="radio_' + name_add_dias + '"]').removeClass();
        $('label[name="radio_' + name_add_dias + '"]').addClass("btn btn-default");
        $('#radio_' + name_add_dias + value_add_dias).addClass("btn btn-warning active");
        //$('#radiogeral'+ value_add_dias).addClass("btn btn-warning active");
		
		if(value_add_dias == "S"){
			$("#"+name_add_dias).css("display","");
		}else{
			$("#"+name_add_dias).css("display","none");
		}

    });
	
	
}




/*
$(document).on('focus',".input_fields_parcelas", function(){
    $(this).datepicker();
});
*/
/*
 * Função responsável por calcular as parcelas do orçamento em função do dados
 * informados no formulário (valor restante / parcelas e datas do vencimento)
 */
 
function calculaParcelas(mod) {
    //alert();
	//captura os valores dos campos indicados
    //var resta = $("#ValorRestanteOrca").val();
	//console.log(mod + ' - mod');
	var resta = $("#ValorTotalOrca").val();
    var parcelas = $("#QtdParcelasOrca").val();
    if(parcelas == 0){
		parcelas = 1;
	}
	//$("#QtdParcelasOrca").val(parcelas);
	var vencimento = $("#DataVencimentoOrca").val();

    //valor de cada parcela
	if(mod){
		if(mod == "P"){
			var parcorca = (resta.replace(".","").replace(",",".") / parcelas);
		}else{
			var parcorca = (resta.replace(".","").replace(",",".") / 1);
		}	
	}else{
		var parcorca = (resta.replace(".","").replace(",",".") / parcelas);
	}	
	parcorca = mascaraValorReal(parcorca);
	
    //pega a data do primeiro vencimento e separa em dia, mês e ano
    var split = vencimento.split("/");

    //define a data do primeiro vencimento no formato do momentjs
    var currentDate = moment(split[2]+'-'+split[1]+'-'+split[0]);

    //console.log(currentDate.format('DD-MM-YYYY'));
    //console.log(futureMonth.format('DD-MM-YYYY'));
    //alert('>>v '+vencimento+'::d1 '+currentDate.format('DD/MM/YYYY')+'::d2 '+futureMonth.format('DD/MM/YYYY')+'::d3 '+futureMonthEnd.format('DD/MM/YYYY')+'<<');

    //caso as parcelas já tenham sido geradas elas serão excluídas para que
    //sejam geradas novas parcelas
    $(".input_fields_parcelas").empty();

    //gera os campos de parcelas
    for (i=1; i<=parcelas; i++) {

        //calcula as datas das próximas parcelas
        var futureMonth = moment(currentDate).add(i-1, 'M');
        var futureMonthEnd = moment(futureMonth).endOf('month');

        if(currentDate.date() != futureMonth.date() && futureMonth.isSame(futureMonthEnd.format('YYYY-MM-DD')))
            futureMonth = futureMonth.add(i-1, 'd');

        $(".input_fields_parcelas").append('\
            <div class="form-group">\
				<div class="panel panel-warning">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-2">\
								<label for="Parcela">Parcela:</label><br>\
								<input type="text" class="form-control" maxlength="6"\
									   name="Parcela'+i+'" value="'+i+'/'+parcelas+'">\
							</div>\
							<div class="col-md-2">\
								<label for="ValorParcela">Valor Parcela:</label><br>\
								<div class="input-group" id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										    id="ValorParcela'+i+'" name="ValorParcela'+i+'" value="'+parcorca+'">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="DataVencimento">Vencimento</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" id="DataVencimento'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataVencimento'+i+'" value="'+futureMonth.format('DD/MM/YYYY')+'">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="Quitado">Parc.Quitada?</label><br>\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_Quitado'+i+'" id="radio_Quitado'+i+'N">\
									<input type="radio" name="Quitado'+i+'" id="rdgrldnmc_cal_parc"\
										onchange="carregaQuitado(this.value,this.name,'+i+',1)" autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_Quitado'+i+'" id="radio_Quitado'+i+'S">\
									<input type="radio" name="Quitado'+i+'" id="rdgrldnmc_cal_parc"\
										onchange="carregaQuitado(this.value,this.name,'+i+',1)" autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
							<div class="col-md-2">\
								<div id="Quitado'+i+'" style="display:none">\
									<label for="DataPago">Pagamento</label>\
									<div class="input-group DatePicker">\
										<span class="input-group-addon" disabled>\
											<span class="glyphicon glyphicon-calendar"></span>\
										</span>\
										<input type="text" class="form-control Date" id="DataPago'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
											   name="DataPago'+i+'" value="">\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>'
        );

    }
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="rdgrldnmc_cal_parc"]').change(function() {

        var value_prc = $(this).val();
        var name_prc = $(this).attr("name");

        //console.log(value_prc + ' <<>> ' + name);

        $('label[name="radio_' + name_prc + '"]').removeClass();
        $('label[name="radio_' + name_prc + '"]').addClass("btn btn-default");
        $('#radio_' + name_prc + value_prc).addClass("btn btn-warning active");
        //$('#radiogeral'+ value_prc).addClass("btn btn-warning active");
		
		if(value_prc == "S"){
			$("#"+name_prc).css("display","");
		}else{
			$("#"+name_prc).css("display","none");
		}

    });
}

function adicionaTamanhos() {

    var pc = $("#PMCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pc++; //text box increment
    $("#PMCount").val(pc);
    //console.log(pc);

    if (pc >= 2) {
        //console.log( $("#listadinamicac"+(pc-1)).val() );
        var chosen;
        chosen = $("#listadinamicac"+(pc-1)).val();
        //console.log( chosen + ' :: ' + pc );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap30").append('\
        <div class="form-group" id="30div'+pc+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-2">\
							<label for="Cat_Prod'+pc+'">Cat_Prod</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="Cat_Prod'+pc+'" placeholder="0"\
									name="Cat_Prod'+pc+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pc+'" class="remove_field30 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicac'+pc);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=7',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            //$select.append('<option value="" checked>Baixa</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
    //permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //console.log(value + ' <<>> ' + name);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");
        //$('#radiogeral'+ value).addClass("btn btn-warning active");

    });

}

/*
 * Função responsável por adicionar novos campos de Procedimento dinamicamente no
 * formulário de orçamento/tratametno
 */
function adicionaProcedimento() {

    var pn = $("#PMCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pn++; //text box increment
    $("#PMCount").val(pn);
    //console.log(pn);

    if (pn >= 2) {
        //console.log( $("#listadinamicac"+(pn-1)).val() );
        var chosen;
        chosen = $("#listadinamica_comp"+(pn-1)).val();
        //console.log( chosen + ' :: ' + pn );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pn+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-4">\
							<label for="Procedimento'+pn+'">Proced.:</label>\
							<textarea class="form-control" id="Procedimento'+pn+'"\
									  name="Procedimento'+pn+'"></textarea>\
						</div>\
						<div class="col-md-4">\
							<label for="Compartilhar'+pn+'">Quem Fazer:</label>\
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen3"\
									 id="listadinamica_comp'+pn+'" name="Compartilhar'+pn+'">\
								<option value=""></option>\
							</select>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-2">\
							<label for="DataProcedimento'+pn+'">Data do Proced.:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA" readonly=""\
									   name="DataProcedimento'+pn+'" id="DataProcedimento'+pn+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="HoraProcedimento'+pn+'">Hora Proced.</label>\
							<div class="input-group TimePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-time"></span>\
								</span>\
								<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM" readonly=""\
									   name="HoraProcedimento'+pn+'"  id="HoraProcedimento'+pn+'" value="'+currentDate.format('HH:mm')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ConcluidoProcedimento">Proc. Concl.? </label><br>\
							<div class="btn-group" data-toggle="buttons">\
								<label class="btn btn-warning active" name="radio_ConcluidoProcedimento'+pn+'" id="radio_ConcluidoProcedimento'+pn+'N">\
								<input type="radio" name="ConcluidoProcedimento'+pn+'" id="rdgrldnmc_prm"\
									onchange="carregaConclProc(this.value,this.name,'+pn+',0)" autocomplete="off" value="N" checked>Não\
								</label>\
								<label class="btn btn-default" name="radio_ConcluidoProcedimento'+pn+'" id="radio_ConcluidoProcedimento'+pn+'S">\
								<input type="radio" name="ConcluidoProcedimento'+pn+'" id="rdgrldnmc_prm"\
									onchange="carregaConclProc(this.value,this.name,'+pn+',0)" autocomplete="off" value="S">Sim\
								</label>\
							</div>\
						</div>\
						<div class="col-md-4">\
							<div class="row">\
								<div id="ConcluidoProcedimento'+pn+'" style="display:none">\
									<div class="col-md-6">\
										<label for="DataConcluidoProcedimento'+pn+'">Data Concl</label>\
										<div class="input-group DatePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-calendar"></span>\
											</span>\
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA" readonly=""\
												   name="DataConcluidoProcedimento'+pn+'"  id="DataConcluidoProcedimento'+pn+'" value="">\
										</div>\
									</div>\
									<div class="col-md-6">\
										<label for="HoraConcluidoProcedimento'+pn+'">Hora Concl.</label>\
										<div class="input-group TimePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-time"></span>\
											</span>\
											<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM" readonly=""\
												   name="HoraConcluidoProcedimento'+pn+'"  id="HoraConcluidoProcedimento'+pn+'" value="">\
										</div>\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pn+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

		
	//get a reference to the select element
	$select3 = $('#listadinamica_comp'+pn);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json3.php?q=3',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select3.html('');
			//iterate over the data and append a select option
			$select3.append('<option value="">-- Sel. Quem Fazer --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select3.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen3').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais opções",
				single_text: "Selecione uma opção",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select3.html('<option id="-1">ERRO</option>');
		}

	});	

    //permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="rdgrldnmc_prm"]').change(function() {

        var value_prm = $(this).val();
        var name_prm = $(this).attr("name");

        //console.log(value_prm + ' <<>> ' + name_prm);

        $('label[name="radio_' + name_prm + '"]').removeClass();
        $('label[name="radio_' + name_prm + '"]').addClass("btn btn-default");
        $('#radio_' + name_prm + value_prm).addClass("btn btn-warning active");
        //$('#radiogeral'+ value_prm).addClass("btn btn-warning active");
		if(value_prm == "S"){
			$("#"+name_prm).css("display","");
		}else{
			$("#"+name_prm).css("display","none");
		}
		
    });
	
}

/*
 * Função responsável por adicionar novos campos de SubTarefas dinamicamente no
 * formulário de tarefa
 */
function adicionaSubProcedimento() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }
	
    if (pt >= 2) {
        //console.log( $("#listadinamicae"+(pt-1)).val() );
        var chosen2;
        chosen2 = $("#listadinamicae"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }	

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-6">\
							<label for="SubProcedimento'+pt+'">Ação:</label>\
							<textarea class="form-control" id="SubProcedimento'+pt+'"\
									  name="SubProcedimento'+pt+'"></textarea>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-2">\
							<label for="DataSubProcedimento'+pt+'">Cadastrada em:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" readonly=""\
									   name="DataSubProcedimento'+pt+'" id="DataSubProcedimento'+pt+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="HoraSubProcedimento'+pt+'">Às</label>\
							<div class="input-group TimePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-time"></span>\
								</span>\
								<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM" readonly=""\
									   name="HoraSubProcedimento'+pt+'"  id="HoraSubProcedimento'+pt+'" value="'+currentDate.format('HH:mm')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ConcluidoSubProcedimento">Concluido? </label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_ConcluidoSubProcedimento'+pt+'" id="radio_ConcluidoSubProcedimento'+pt+'N">\
									<input type="radio" name="ConcluidoSubProcedimento'+pt+'" id="radiogeraldinamico_subproc"\
										onchange="carregaConclSubProc(this.value,this.name,'+pt+',0)" autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_ConcluidoSubProcedimento'+pt+'" id="radio_ConcluidoSubProcedimento'+pt+'S">\
									<input type="radio" name="ConcluidoSubProcedimento'+pt+'" id="radiogeraldinamico_subproc"\
										onchange="carregaConclSubProc(this.value,this.name,'+pt+',0)" autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-4">\
							<div id="ConcluidoSubProcedimento'+pt+'" style="display:none">\
								<div class="row">\
									<div class="col-md-6">\
										<label for="DataConcluidoSubProcedimento'+pt+'">Data Concl</label>\
										<div class="input-group DatePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-calendar"></span>\
											</span>\
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA" readonly=""\
												   name="DataConcluidoSubProcedimento'+pt+'"  id="DataConcluidoSubProcedimento'+pt+'" value="">\
										</div>\
									</div>\
									<div class="col-md-6">\
										<label for="HoraConcluidoSubProcedimento'+pt+'">Às</label>\
										<div class="input-group TimePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-time"></span>\
											</span>\
											<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM" readonly=""\
												   name="HoraConcluidoSubProcedimento'+pt+'"  id="HoraConcluidoSubProcedimento'+pt+'" value="">\
										</div>\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=7',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            //$select.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	
    //get a reference to the select2 element
    $select2 = $('#listadinamicae'+pt);	
	
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=10',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select2
            $select2.html('');
            //iterate over the data and append a select2 option
            //$select2.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen2)
                    $select2.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select2.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select2.html('<option id="-1">ERRO</option>');
        }

    });	
	
    //permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="radiogeraldinamico_subproc"]').change(function() {

        var value_subproc = $(this).val();
        var name_subproc = $(this).attr("name");

        //console.log(value_subproc + ' <<>> ' + name_subproc);

        $('label[name="radio_' + name_subproc + '"]').removeClass();
        $('label[name="radio_' + name_subproc + '"]').addClass("btn btn-default");
        $('#radio_' + name_subproc + value_subproc).addClass("btn btn-warning active");
        //$('#radiogeral'+ value_subproc).addClass("btn btn-warning active");
		
		if(value_subproc == "S"){
			$("#"+name_subproc).css("display","");
		}else{
			$("#"+name_subproc).css("display","none");
		}
		
	});

}

function adicionaSubTarefa() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }
	
    if (pt >= 2) {
        //console.log( $("#listadinamicae"+(pt-1)).val() );
        var chosen2;
        chosen2 = $("#listadinamicae"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }	

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-4">\
							<label for="SubProcedimento'+pt+'">Ação:</label>\
							<textarea class="form-control" id="SubProcedimento'+pt+'"\
									  name="SubProcedimento'+pt+'"></textarea>\
						</div>\
						<div class="col-md-2">\
							<label for="DataSubProcedimento'+pt+'">Iniciar em:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataSubProcedimento'+pt+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataSubProcedimentoLimite'+pt+'">Concluir em:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataSubProcedimentoLimite'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ConcluidoSubProcedimento">Concluido? </label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_ConcluidoSubProcedimento'+pt+'" id="radio_ConcluidoSubProcedimento'+pt+'N">\
									<input type="radio" name="ConcluidoSubProcedimento'+pt+'" id="radiogeraldinamico"\
										autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_ConcluidoSubProcedimento'+pt+'" id="radio_ConcluidoSubProcedimento'+pt+'S">\
									<input type="radio" name="ConcluidoSubProcedimento'+pt+'" id="radiogeraldinamico"\
										autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=7',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            //$select.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	
    //get a reference to the select2 element
    $select2 = $('#listadinamicae'+pt);	
	
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=10',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select2
            $select2.html('');
            //iterate over the data and append a select2 option
            //$select2.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen2)
                    $select2.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select2.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select2.html('<option id="-1">ERRO</option>');
        }

    });	
	
    //permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //console.log(value + ' <<>> ' + name);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");
        //$('#radiogeral'+ value).addClass("btn btn-warning active");

    });	

}

function adicionaValor() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-3">\
							<label for="ValorProduto'+pt+'">Valor :</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=5',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });

}

function adicionaValor2() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-4">\
							<label for="Fornecedor'+pt+'">Fornecedor:</label>\
							<select data-placeholder="Selecione uma opção..." class="form-control"\
									 id="listadinamicad'+pt+'" name="Fornecedor'+pt+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-4">\
							<label for="Convdesc'+pt+'">Descrição:</label>\
							<input type="text" class="form-control" id="Convdesc'+pt+'"\
									  name="Convdesc'+pt+'" value="">\
						</div>\
						<div class="col-md-3">\
							<label for="ValorProduto'+pt+'">Valor :</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=5',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });

}

function adiciona_atributo() {
	
    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

	if (pt >= 2) {
        //console.log( $("#listadinamica2"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamica2"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }
	
    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-5">\
							<label for="idTab_Atributo">Atributo '+pt+':</label><br>\
							<select class="form-control Chosen" id="listadinamica2'+pt+'" name="idTab_Atributo'+pt+'">\
								<option value="">-- Selecione o Atributo --</option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
	
	//get a reference to the select element
	$select = $('#listadinamica2'+pt);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=16',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Selecione o Atributo--</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op??es",
				single_text: "Selecione uma op??o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	

}

function adiciona_opcao() {

	var pt2 = $("#POCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt2++; //text box increment
    $("#POCount").val(pt2);
    //console.log(pt2);

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap32").append('\
        <div class="form-group" id="32div'+pt2+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-6">\
							<label for="Opcao'+pt2+'">Opcao '+pt2+'</label><br>\
							<input type="text" class="form-control" id="Opcao'+pt2+'" maxlength="44"\
								name="Opcao'+pt2+'" value="">\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt2+'" class="remove_field32 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
	
}

function adiciona_opcao_select2() {

	var pt2 = $("#PT2Count").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt2++; //text box increment
    $("#PT2Count").val(pt2);
    //console.log(pt2);

    if (pt2 >= 2) {
        //console.log( $("#listadinamica2"+(pt2-1)).val() );
        var chosen;
        chosen = $("#listadinamica2"+(pt2-1)).val();
        //console.log( chosen + ' :: ' + pt2 );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap32").append('\
        <div class="form-group" id="32div'+pt2+'">\
			<div class="panel panel-success">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-10">\
							<label for="idTab_Opcao2">Opcao '+pt2+'</label><br>\
							<select class="form-control Chosen2" id="listadinamica2'+pt2+'" name="idTab_Opcao2'+pt2+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt2+'" class="remove_field32 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
	
	//get a reference to the select element
	$select = $('#listadinamica2'+pt2);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=102',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Opcao Atr. 1 --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen2').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais opções",
				single_text: "Selecione uma opção",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1"></option>');
		}

	});	
	
}

function adiciona_precos() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto'+pt+'" placeholder="0"\
								    name="QtdProdutoDesconto'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento">QtdEmb:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento'+pt+'" placeholder="0"\
								    name="QtdProdutoIncremento'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto'+pt+'">ValorEmbal</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ComissaoVenda'+pt+'">Comissao</label><br>\
							<div class="input-group id="ComissaoVenda'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoVenda'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoVenda'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="TempoDeEntrega'+pt+'">Tempo De Entrega</label><br>\
							<div class="input-group id="TempoDeEntrega'+pt+'">\
								<input type="text" class="form-control Numero text-right" id="TempoDeEntrega'+pt+'" maxlength="3" placeholder="0" \
									name="TempoDeEntrega'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">Dia(s)</span>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="Convdesc'+pt+'">Desc. Embal:</label>\
							<textarea type="text" class="form-control" id="Convdesc'+pt+'"\
									  name="Convdesc'+pt+'" value=""></textarea>\
						</div>\
						<div class="col-md-1 text-right">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-2">\
							<label for="VendaBalcaoPreco">VendaBalcao?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_VendaBalcaoPreco'+pt+'" id="radio_VendaBalcaoPreco'+pt+'N">\
									<input type="radio" name="VendaBalcaoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_VendaBalcaoPreco'+pt+'" id="radio_VendaBalcaoPreco'+pt+'S">\
									<input type="radio" name="VendaBalcaoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="VendaSitePreco">VendaSite?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_VendaSitePreco'+pt+'" id="radio_VendaSitePreco'+pt+'N">\
									<input type="radio" name="VendaSitePreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_VendaSitePreco'+pt+'" id="radio_VendaSitePreco'+pt+'S">\
									<input type="radio" name="VendaSitePreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	/*
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	*/
	
	//get a reference to the select element
	$select = $('#listadinamicad'+pt);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais opções",
				single_text: "Selecione uma opção",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	
    
	//permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //console.log(value + ' <<>> ' + name);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");

    });	
	
}

function adiciona_item_promocao() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-6">\
							<label for="idTab_Produtos">Item '+pt+'*:</label><br>\
							<select class="form-control Chosen" id="listadinamicad'+pt+'" name="idTab_Produtos'+pt+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto">QtdPrd*:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto'+pt+'" placeholder="0"\
								    name="QtdProdutoDesconto'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento">QtdEmb*:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento'+pt+'" placeholder="0"\
								    name="QtdProdutoIncremento'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto'+pt+'">ValorEmbal*:</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ComissaoVenda'+pt+'">Comissao:</label><br>\
							<div class="input-group id="ComissaoVenda'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoVenda'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoVenda'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="TempoDeEntrega'+pt+'">Tempo De Entrega:</label><br>\
							<div class="input-group id="TempoDeEntrega'+pt+'">\
								<input type="text" class="form-control Numero text-right" id="TempoDeEntrega'+pt+'" maxlength="3" placeholder="0" \
									name="TempoDeEntrega'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">Dia(s)</span>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="Convdesc'+pt+'">Desc. Embal:</label>\
							<textarea type="text" class="form-control" id="Convdesc'+pt+'"\
									  name="Convdesc'+pt+'" value=""></textarea>\
						</div>\
						<div class="col-md-1 text-right">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	/*
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	*/
	
	//get a reference to the select element
	$select = $('#listadinamicad'+pt);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais opções",
				single_text: "Selecione uma opção",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	
    
	//permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //console.log(value + ' <<>> ' + name);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");

    });	
	
}
 
function adiciona_item_promocao2() {

	var pt2 = $("#PT2Count").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt2++; //text box increment
    $("#PT2Count").val(pt2);
    //console.log(pt2);

    if (pt2 >= 2) {
        //console.log( $("#listadinamica2"+(pt2-1)).val() );
        var chosen;
        chosen = $("#listadinamica2"+(pt2-1)).val();
        //console.log( chosen + ' :: ' + pt2 );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap32").append('\
        <div class="form-group" id="32div'+pt2+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto2">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto2'+pt2+'" placeholder="0"\
								    name="QtdProdutoDesconto2'+pt2+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-5">\
							<label for="idTab_Produtos2">Item '+pt2+':</label><br>\
							<select class="form-control Chosen2" id="listadinamica2'+pt2+'" name="idTab_Produtos2'+pt2+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-2">\
							<label for="Convdesc2'+pt2+'">Desc. Embal:</label>\
							<input type="text" class="form-control" id="Convdesc2'+pt2+'"\
									  name="Convdesc2'+pt2+'" value="">\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento2">QtdEmb:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento2'+pt2+'" placeholder="0"\
								    name="QtdProdutoIncremento2'+pt2+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto2'+pt2+'">ValorEmbal</label><br>\
							<div class="input-group id="ValorProduto2'+pt2+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto2'+pt2+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto2'+pt2+'" value="">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt2+'" class="remove_field32 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	/*
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	*/
	
	//get a reference to the select element
	$select = $('#listadinamica2'+pt2);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=13',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen2').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais opções",
				single_text: "Selecione uma opção",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	
	
}
 
function adiciona_item_promocao3() {

    var pt3 = $("#PT3Count").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt3++; //text box increment
    $("#PT3Count").val(pt3);
    //console.log(pt3);

    if (pt3 >= 2) {
        //console.log( $("#listadinamica3"+(pt3-1)).val() );
        var chosen;
        chosen = $("#listadinamica3"+(pt3-1)).val();
        //console.log( chosen + ' :: ' + pt3 );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap33").append('\
        <div class="form-group" id="33div'+pt3+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto3">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto3'+pt3+'" placeholder="0"\
								    name="QtdProdutoDesconto3'+pt3+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-5">\
							<label for="idTab_Produtos3">Item '+pt3+':</label><br>\
							<select class="form-control Chosen3" id="listadinamica3'+pt3+'" name="idTab_Produtos3'+pt3+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-2">\
							<label for="Convdesc3'+pt3+'">Desc. Embal:</label>\
							<input type="text" class="form-control" id="Convdesc3'+pt3+'"\
									  name="Convdesc3'+pt3+'" value="">\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento3">QtdEmb:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento3'+pt3+'" placeholder="0"\
								    name="QtdProdutoIncremento3'+pt3+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto3'+pt3+'">ValorEmbal</label><br>\
							<div class="input-group id="ValorProduto3'+pt3+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto3'+pt3+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto3'+pt3+'" value="">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt3+'" class="remove_field33 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	/*
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	*/
	
	//get a reference to the select element
	$select = $('#listadinamica3'+pt3);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=14',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen3').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais opções",
				single_text: "Selecione uma opção",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	
	
}

function adiciona_item_promocao5() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto'+pt+'" placeholder="0"\
								    name="QtdProdutoDesconto'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-6">\
							<label for="idTab_Produtos">Item '+pt+':</label><br>\
							<select class="form-control Chosen" id="listadinamicad'+pt+'" name="idTab_Produtos'+pt+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-2">\
							<label for="Convdesc'+pt+'">Desc. Embal:</label>\
							<textarea type="text" class="form-control" id="Convdesc'+pt+'"\
									  name="Convdesc'+pt+'" value=""></textarea>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento">QtdEmb:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento'+pt+'" placeholder="0"\
								    name="QtdProdutoIncremento'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto'+pt+'">ValorEmbal</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-1 text-right"></div>\
						<div class="col-md-2">\
							<label for="AtivoPreco">Ativo?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_AtivoPreco'+pt+'" id="radio_AtivoPreco'+pt+'N">\
									<input type="radio" name="AtivoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_AtivoPreco'+pt+'" id="radio_AtivoPreco'+pt+'S">\
									<input type="radio" name="AtivoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="VendaBalcaoPreco">VendaBalcao?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_VendaBalcaoPreco'+pt+'" id="radio_VendaBalcaoPreco'+pt+'N">\
									<input type="radio" name="VendaBalcaoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_VendaBalcaoPreco'+pt+'" id="radio_VendaBalcaoPreco'+pt+'S">\
									<input type="radio" name="VendaBalcaoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="VendaSitePreco">VendaSite?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_VendaSitePreco'+pt+'" id="radio_VendaSitePreco'+pt+'N">\
									<input type="radio" name="VendaSitePreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_VendaSitePreco'+pt+'" id="radio_VendaSitePreco'+pt+'S">\
									<input type="radio" name="VendaSitePreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ComissaoVenda'+pt+'">Comissao</label><br>\
							<div class="input-group id="ComissaoVenda'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoVenda'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoVenda'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
						<div class="col-md-2 text-right"></div>\
						<div class="col-md-1 text-right">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	//get a reference to the select element
	$select = $('#listadinamicad'+pt);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=122',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais opções",
				single_text: "Selecione uma opção",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});
	
	//permite o uso de radio buttons nesse bloco dinâmico
	$('input:radio[id="radiogeraldinamico"]').change(function() {

		var value = $(this).val();
		var name = $(this).attr("name");

		//console.log(value + ' <<>> ' + name);

		$('label[name="radio_' + name + '"]').removeClass();
		$('label[name="radio_' + name + '"]').addClass("btn btn-default");
		$('#radio_' + name + value).addClass("btn btn-warning active");

	});	
	
}
/*
  * Função criada para funcionar junto com o recurso de hide/show do jquery nos
  * casos de radio button, que exigem um tratamento especial para funcionar
  * corretamente
  *
  * @param {string} campo
  * @param {string} hideshow
  */
 function radioButtonColorNS(campo, hideshow) {

     if (hideshow == 'showradio') {
        active = 'showradio';
        not = 'hideradio';
     } else {
        active = 'hideradio';
        not = 'showradio';
     }

     $('label[name="' + campo + '_' + not + '"]').removeClass();
     $('label[name="' + campo + '_' + not + '"]').addClass("btn btn-default");

     $('label[name="' + campo + '_' + active + '"]').removeClass();
     $('label[name="' + campo + '_' + active + '"]').addClass("btn btn-warning active");

 }

/*
 * Função responsável por capturar o serviço/produto selecionado e buscar seu valor
 * correspondente no arquivo Valor_json.php. Após obter o valor ele é
 * aplicado no campo de Valor correspondente.
 *
 * @param {int} id
 * @param {string} campo
 * @param {string} tabela
 * @returns {decimal}
 */

function buscaValor1Tabelas(id, campo, tabela, num, campo2) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor1_json.php?tabela=" + tabela + "&campo2=" + campo2,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {
				if (id) {
					if (data[i].id == id) {
						$('#Escrever'+campo2+num).css("display","");
						$('#Entregue'+campo2+num).css("display","");
						//""ou posso usar assim, passando diretamente o qtdinc do id ""
						$('#Nome'+campo2+num).val(data[i].nomeprod);
						$('#Comissao'+campo2+num).val(data[i].comissaoprod);
						$('#Prazo'+campo2+num).val(data[i].prazoprod);
						$('#QtdIncremento'+campo2+num).val(data[i].qtdinc);
						$('#Qtd'+campo2+num).val(data[i].qtdprod);
						$('#idTab_Produtos_'+campo2+num).val(data[i].id_produto);
						$('#Prod_Serv_'+campo2+num).val(data[i].prod_serv);
						$('#idTab_Valor_'+campo2+num).val(data[i].id_valor);
						$('#DataConcluido'+campo2+num).val(currentDate.format('DD/MM/YYYY'));
						$('#HoraConcluido'+campo2+num).val(currentDate.format('HH:mm'));
						//console.log( data[i].comissaoprod +' valor da comissão do produto');
						//carrega o valor no campo de acordo com a opção selecionada
						$('#'+campo).val(data[i].valor);

						//if (tabela == area && $("#Qtd"+tabela+num).val()) {
						if ($("#Qtd"+campo2+num).val()) {
							calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2,$("#QtdIncremento"+campo2+num).val(),$("#Comissao"+campo2+num).val());
							break;
						}

						//para cada valor carregado o orçamento é calculado/atualizado
						//através da chamada de sua função
						calculaOrcamento();
						break;
					}
				}else{
					$('#Escrever'+campo2+num).css("display","none");
					$('#Entregue'+campo2+num).css("display","none");
					//""ou posso usar assim, passando diretamente o qtdinc do id ""
					$('#Nome'+campo2+num).val("");
					$('#Comissao'+campo2+num).val("0");
					$('#QtdIncremento'+campo2+num).val("0");
					$('#Qtd'+campo2+num).val("0");
					$('#idTab_Produtos_'+campo2+num).val("0");
					$('#Prod_Serv_'+campo2+num).val("0");
					$('#idTab_Valor_'+campo2+num).val("0");
					$('#DataConcluido'+campo2+num).val("00/00/0000");
					$('#HoraConcluido'+campo2+num).val("00:00");
					//console.log( data[i].comissaoprod +' valor da comissão do produto');
					//carrega o valor no campo de acordo com a opção selecionada
					$('#'+campo).val("0");

					//if (tabela == area && $("#Qtd"+tabela+num).val()) {
					if ($("#Qtd"+campo2+num).val()) {
						calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2,$("#QtdIncremento"+campo2+num).val(),$("#Comissao"+campo2+num).val());
						break;
					}
				
					//para cada valor carregado o orçamento é calculado/atualizado
					//através da chamada de sua função
					calculaOrcamento();
					break;
				}
				
				
            }//fim do laço
        }
    });//termina o ajax

}

function buscaValor2Tabelas(id, campo, tabela, num, campo2) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor2_json.php?tabela=" + tabela + "&campo2=" + campo2,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {
				if (id) {
					if (data[i].id == id) {
						$('#Escrever'+campo2+num).css("display","");
						$('#Entregue'+campo2+num).css("display","");
						//""ou posso usar assim, passando diretamente o qtdinc do id ""
						$('#Nome'+campo2+num).val(data[i].nomeprod);
						$('#idTab_Produtos_'+campo2+num).val(data[i].id_produto);
						$('#Prod_Serv_'+campo2+num).val(data[i].prod_serv);
						$('#Comissao'+campo2+num).val(data[i].comissaoprod);
						//console.log( data[i].id_produto );
					
						//carrega o valor no campo de acordo com a opção selecionada
						$('#'+campo).val(data[i].valor);

						//if (tabela == area && $("#Qtd"+tabela+num).val()) {
						if ($("#Qtd"+campo2+num).val()) {
							calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2,$("#QtdIncremento"+campo2+num).val(),$("#Comissao"+campo2+num).val());
							break;
						}

						//para cada valor carregado o orçamento é calculado/atualizado
						//através da chamada de sua função
						calculaOrcamento();
						break;
					}
				}else{
					$('#Escrever'+campo2+num).css("display","none");
					$('#Entregue'+campo2+num).css("display","none");
					//""ou posso usar assim, passando diretamente o qtdinc do id ""
					$('#Nome'+campo2+num).val("");
					$('#Comissao'+campo2+num).val("0");
					$('#QtdIncremento'+campo2+num).val("0");
					$('#Qtd'+campo2+num).val("0");
					$('#idTab_Produtos_'+campo2+num).val("0");
					$('#Prod_Serv_'+campo2+num).val("0");
					$('#idTab_Valor_'+campo2+num).val("0");
					$('#DataConcluido'+campo2+num).val("00/00/0000");
					$('#HoraConcluido'+campo2+num).val("00:00");
					//console.log( data[i].comissaoprod +' valor da comissão do produto');
					//carrega o valor no campo de acordo com a opção selecionada
					$('#'+campo).val("0");

					//if (tabela == area && $("#Qtd"+tabela+num).val()) {
					if ($("#Qtd"+campo2+num).val()) {
						calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2,$("#QtdIncremento"+campo2+num).val(),$("#Comissao"+campo2+num).val());
						break;
					}
				
					//para cada valor carregado o orçamento é calculado/atualizado
					//através da chamada de sua função
					calculaOrcamento();
					break;
				}
            }//fim do laço

        }
    });//termina o ajax


}

/*
 * Função responsável por calcular o subtotal dos campos de produto
 *
 * @param {int} quant
 * @param {string} campo
 * @param {int} num
 * @returns {decimal}
 */
function calculaSubtotal(valor, campo, num, tipo, tabela, qtdinc, comissao) {
	
	//console.log(comissao);
	//console.log(comissao.replace(",","."));
	//var comissaoprd = $("#Comissao"+tabela+num).val();
	//console.log(comissaoprd);
	//console.log(comissaoprd.replace(",","."));
    if (tipo == 'VP') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#Qtd"+tabela+num).val();
		var qtdprdinc = $("#QtdIncremento"+tabela+num).val();
		var comissaoprd = $("#Comissao"+tabela+num).val();
		//console.log(comissaoprd);
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * data);
		//console.log(subtotal);
		var subtotalcomissao = (subtotal * comissaoprd / 100);
		//console.log(subtotalcomissao);
		var subtotalqtd = (qtdprdinc.replace(".","").replace(",",".") * data.replace(".","").replace(",","."));
        //alert('>>>'+valor+' :: '+campo+' :: '+num+' :: '+tipo+'<<<');
    } else if (tipo == 'QTD') {
        //variável quantidade recebe a quantidade do produto selecionado
        var data = $("#idTab_"+tabela+num).val();
		var qtdprdinc = $("#QtdIncremento"+tabela+num).val();
		var comissaoprd = $("#Comissao"+tabela+num).val();
		//console.log(comissaoprd);
		var qtdprd = $("#Qtd"+tabela+num).val();
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor * data.replace(".","").replace(",","."));
		//console.log(subtotal);
		var subtotalcomissao = (subtotal * comissaoprd / 100);
		//console.log(subtotalcomissao);
		var subtotalqtd = (qtdprdinc.replace(".","").replace(",",".") * qtdprd.replace(".","").replace(",","."));
	} else if (tipo == 'QTDINC') {
        //variável quantidadeincremento recebe a quantidadeincremento do produto selecionado
        var data = $("#idTab_"+tabela+num).val();
		var qtdprdinc = $("#QtdIncremento"+tabela+num).val();
		var comissaoprd = $("#Comissao"+tabela+num).val();
		//console.log(comissaoprd);
		var qtdprd = $("#Qtd"+tabela+num).val();
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (qtdprd * data.replace(".","").replace(",","."));
		//console.log(subtotal);
		var subtotalcomissao = (subtotal * comissaoprd / 100);
		//console.log(subtotalcomissao);
		var subtotalqtd = (qtdprdinc.replace(".","").replace(",",".") * qtdprd.replace(".","").replace(",","."));	
    } else {
		//o subtotal é calculado como o produto da quantidade pelo seu valor
		var subtotal = (valor.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
		//console.log(subtotal);
		var subtotalcomissao = (subtotal * comissao / 100);
		//console.log(subtotalcomissao);
		var subtotalqtd = (qtdinc.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
    }

    subtotal 			= mascaraValorReal(subtotal);
	//subtotalcomissao 	= mascaraValorReal(subtotalcomissao);
	subtotalqtd1 		= subtotalqtd;
	
	//console.log(subtotalqtd1 + ' - Quantidade do ' + tabela);
	//console.log(subtotal + ' - Subtotal do ' + tabela);
	//console.log(subtotalcomissao + ' - Subtotal da comissão do ' + tabela);
	
    //o subtotal é escrito no seu campo no formulário
    $('#Subtotal'+tabela+num).val(subtotal);
	$('#SubtotalComissao'+tabela+num).val(subtotalcomissao);
	$('#SubtotalQtd'+tabela+num).val(subtotalqtd1);

    //para cada vez que o subtotal for calculado o orçamento e o total restante
    //também serão atualizados
    calculaOrcamento();

}

/*
 * Função responsável por calcular o orçamento total
 *
 * @returns {int}
 */
function calculaOrcamento() {

    //captura o número incrementador do formulário, que controla quantos campos
    //foram acrescidos tanto para serviços quanto para produtos
    var sc = parseFloat($('#SCount').val().replace(".","").replace(",","."));
    var pc = parseFloat($('#PCount').val().replace(".","").replace(",","."));
    //define o subtotal inicial em 0.00
    
	var subtotalservico = 0.00;
	var subtotalcomissaoservico = 0.00;
	var subtotalqtdservico = 0.00;
	
	var subtotal = 0.00;
	var subtotalcomissao = 0.00;
	var subtotalqtd = 0.00;
	
    //variável incrementadora
    var i = 0;
    //percorre todos os campos de serviço, somando seus valores
    while (i <= sc) {

        //soma os valores apenas dos campos que existirem, o que forem apagados
        //ou removidos são ignorados
        if ($('#SubtotalServico'+i).val()){
            //subtotal += parseFloat($('#idTab_Servico'+i).val().replace(".","").replace(",","."));
            //subtotal -= parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));
			subtotalservico += parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));
			subtotalcomissaoservico += parseFloat($('#SubtotalComissaoServico'+i).val());
			subtotalqtdservico += parseFloat($('#SubtotalQtdServico'+i).val().replace(".","").replace(",","."));
			//incrementa a variável i
        }
		i++;
    }
	//console.log(subtotalcomissaoservico + ' - Total Comissão servico');
	//console.log(subtotalqtdservico + ' - Total Quantidade servico');
    //faz o mesmo que o laço anterior mas agora para produtos
    var i = 0;
    while (i <= pc) {

        if ($('#SubtotalProduto'+i).val()){
            subtotal += parseFloat($('#SubtotalProduto'+i).val().replace(".","").replace(",","."));
			//subtotalcomissao += parseFloat($('#SubtotalComissaoProduto'+i).val().replace(".","").replace(",","."));
			subtotalcomissao += parseFloat($('#SubtotalComissaoProduto'+i).val());
			subtotalqtd += parseFloat($('#SubtotalQtdProduto'+i).val().replace(".","").replace(",","."));
		}
		i++;
    }
	//console.log(subtotalcomissao + ' - Total Comissão produto');
    //calcula o subtotal, configurando para duas casas decimais e trocando o
    //ponto para o vírgula como separador de casas decimais
    subtotalservico = mascaraValorReal(subtotalservico);
	subtotal = mascaraValorReal(subtotal);
	//subtotalcomissao = mascaraValorReal(subtotalcomissao);
	subtotalqtd1 = subtotalqtd;
	subtotalqtd2 = subtotalqtdservico;
	//console.log(subtotalqtd1 + ' - Quantidade Total de produtos');
	//console.log(subtotalqtd2 + ' - Quantidade Total de servicos');
	//console.log(subtotal + ' - Valor Total de produtos');
	//console.log(subtotalcomissao + ' - Valor Total de comissão');
	var valorcomissao = -(-subtotalcomissaoservico -subtotalcomissao);
    //console.log(valorcomissao + ' - ValorComissao');
	//escreve o subtotal no campo do formulário
    $('#ValorDev').val(subtotalservico);
	//console.log(subtotalservico + ' - Valor Total de servicos');
	$('#ValorOrca').val(subtotal);
	//console.log(subtotal + ' - Valor Total de produtos');
	$('#ValorComissao').val(valorcomissao);
	
	$('#QtdPrdOrca').val(subtotalqtd1);
	
	$('#QtdSrvOrca').val(subtotalqtd2);
    calculaResta($("#ValorEntradaOrca").val());
	calculaTotal($("#ValorEntradaOrca").val());
}

function adicionaParcelas() {

	var pr = $("#PRCount").val(); //initlal text box count
	pr++; //text box increment
	$("#PRCount").val(pr);
	/*
	if (pr >= 2) {
		//console.log( $("#listadinamicac"+(pr-1)).val() );
		var chosen2;
		chosen2 = $("#listadinamicac"+(pr-1)).val();
		//console.log( chosen + ' :: ' + pr );
	}
	*/
    //Captura a data do dia e carrega no campo correspondente
    
	//var currentDate = moment();
	
    $(".input_fields_wrap21").append('\
		<div class="form-group" id="21div'+pr+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-2">\
							<label for="Parcela">Parcela:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="Parcela'+pr+'" value="Ex.">\
						</div>\
						<div class="col-md-2">\
							<label for="ValorParcela">Valor:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorParcela'+pr+'" name="ValorParcela'+pr+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataVencimento">Vencimento</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataVencimento'+pr+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataVencimento'+pr+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="Quitado">Parc.Quitado?</label><br>\
							<div class="btn-group" data-toggle="buttons">\
								<label class="btn btn-warning active" name="radio_Quitado'+pr+'" id="radio_Quitado'+pr+'N">\
								<input type="radio" name="Quitado'+pr+'" id="rdgrldnmc_adic_parc"\
									onchange="carregaQuitado(this.value,this.name,'+pr+',1)" autocomplete="off" value="N" checked>Não\
								</label>\
								<label class="btn btn-default" name="radio_Quitado'+pr+'" id="radio_Quitado'+pr+'S">\
								<input type="radio" name="Quitado'+pr+'" id="rdgrldnmc_adic_parc"\
									onchange="carregaQuitado(this.value,this.name,'+pr+',1)" autocomplete="off" value="S">Sim\
								</label>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<div id="Quitado'+pr+'" style="display:none">\
								<label for="DataPago">Pagamento</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" id="DataPago'+pr+'" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataPago'+pr+'" value="">\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<a href="#" id="'+pr+'" class="remove_field21 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</a>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>'
	); //add input box
	/*
	//get a reference to the select element
	$select2 = $('#listadinamicac'+pr);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=3',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select2.html('');
			//iterate over the data and append a select option
			$select2.append('<option value="">-- Sel. Profis. --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select2.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen2({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais opções",
				single_text: "Selecione uma opção",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select2.html('<option id="-1">ERRO</option>');
		}

	});	
	*/
	//habilita o botão de calendário após a geração dos campos dinâmicos
	$('.DatePicker').datetimepicker(dateTimePickerOptions);	
	
    //permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="rdgrldnmc_adic_parc"]').change(function() {

        var value_prc = $(this).val();
        var name_prc = $(this).attr("name");
        //console.log(value_prc + ' <<>> ' + name_prc);
		
		$('label[name="radio_' + name_prc + '"]').removeClass();
        $('label[name="radio_' + name_prc + '"]').addClass("btn btn-default");
        $('#radio_' + name_prc + value_prc).addClass("btn btn-warning active");
		
		if(value_prc == "S"){
			$("#"+name_prc).css("display","");
		}else{
			$("#"+name_prc).css("display","none");
		}
    });
}

function adicionaTipo() {

    var at = $("#TCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    at++; //text box increment
    $("#TCount").val(at);
    //console.log(at);

    if (at >= 2) {
        //console.log( $("#listadinamicad"+(at-1)).val() );
        var chosen;
        chosen = $("#listadinamica99"+(at-1)).val();
        //console.log( chosen + ' :: ' + at );
		
    }

    $(".input_fields_wrap99").append('\
        <div class="form-group" id="99div'+at+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-10">\
							<label for="idTab_Opcao2">Opcao '+at+'</label><br>\
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="listadinamica99'+at+'" name="idTab_Opcao2'+at+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<a href="#" id="'+at+'" class="remove_field99 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</a>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box

	//get a reference to the select element
	$select = $('#listadinamica99'+at);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=101',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Opcao --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais opções",
				single_text: "Selecione uma opção",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});

}

$("#first-choice").change(function () {

    var $dropdown = $(this);
    var items = [];

    $.getJSON("dt.json", function (data) {

        $.each(data, function (key, val) {
            items.push(val + '<br>');
        });

        $.getJSON("data.json", function (data) {

            var key = $dropdown.val();
            var vals = [];

            if (key == 'beverages')
                vals = data.beverages.split(",");
            else if (key == 'snacks')
                vals = data.snacks.split(",");
            else
                vals = ['Please choose from above'];

            var $secondChoice = $("#second-choice");
            $secondChoice.empty();
            $.each(vals, function (index, value) {
                $secondChoice.append("<option>" + value + "</option>");
            });
            $(".Chosen").trigger("chosen:updated");
        });

        $("#demo").html(items);
        //alert('opa');
    });

});

$(document).ready(function () {

    $(".Date").mask("99/99/9999");
	$(".Cnpj").mask("99.999.999/9999-99");
    $(".Time").mask("99:99");
    $(".Cpf").mask("99999999999");
    $(".Cep").mask("99999999");
	$(".Rg").mask("999999999");
    $(".TituloEleitor").mask("9999.9999.9999");
    $(".Valor").mask("#.##0,00", {reverse: true});
	$(".Peso").mask("#.##0,000", {reverse: true});
    $('.Numero').mask('0#');

    $(".Celular").mask("99999999999");
    $(".CelularVariavel").on("blur", function () {
        var last = $(this).val().substr($(this).val().indexOf("-") + 1);

        if (last.length == 3) {
            var move = $(this).val().substr($(this).val().indexOf("-") - 1, 1);
            var lastfour = move + last;

            var first = $(this).val().substr(0, 9);

            $(this).val(first + '-' + lastfour);
        }
    });

    $("[data-toggle='tooltip']").tooltip();

    $('input:radio[id="radio"]').change(function() {

        var value = $(this).val();

        if (value == 1)
            var btn = "btn btn-warning active";
        else if (value == 2)
            var btn = "btn btn-success active";
        else if (value == 3)
            var btn = "btn btn-primary active";
        else
            var btn = "btn btn-danger active";

        $('label[name="radio"]').removeClass();
        $('label[name="radio"]').addClass("btn btn-default");
        $('#radio'+ value).addClass(btn);

    });

    //permite o uso de radio buttons em blocos estáticos
    $('input:radio[id="radiobutton"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        $('label[name="radiobutton_' + name + '"]').removeClass();
        $('label[name="radiobutton_' + name + '"]').addClass("btn btn-default");
        $('#radiobutton_' + name + value).addClass("btn btn-warning active");

    });

    //permite o uso de radio buttons em blocos dinâmicos
    $('input:radio[id="radiobuttondinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        $('label[name="radiobutton_' + name + '"]').removeClass();
        $('label[name="radiobutton_' + name + '"]').addClass("btn btn-default");
        $('#radiobutton_' + name + value).addClass("btn btn-warning active");

    });
	
    //permite o uso de radio buttons em blocos dinâmicos
    $('input:radio[id="VendaSite1"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        $('label[name="radiobutton_' + name + '"]').removeClass();
        $('label[name="radiobutton_' + name + '"]').addClass("btn btn-default");
        $('#radiobutton_' + name + value).addClass("btn btn-warning active");

    });	
	
    //adiciona campos dinamicamente dos Produtos Vendidos 
	var pc = $("#PCount").val(); //initlal text box count
	$(".add_field_button9").click(function(e){ //on add input button click
		
		var negocio = $('#Negocio').val();
		//console.log( negocio );
		
		if (negocio == 1) {
			var endereco = 'q=90';
			var tipo_orca = $('#Tipo_Orca').val();
			//var escrita = 'readonly=""';
			var escrita = '';
			var buscavalor = 'buscaValor1Tabelas';
			var tblbusca = 'Valor';
		}
		if (negocio == 2) {
			var endereco = 'q=20';
			var tipo_orca = $('#Tipo_Orca').val();
			var escrita = '';
			var buscavalor = 'buscaValor2Tabelas';
			var tblbusca = 'Produtos';
		}
		
		var empresa = $('#Empresa').val();
		//console.log( empresa );
		////Ver uma solução para os campos disponíveis da empresa 42
		if(empresa == 42) {
			$('.campos').show();
		}
		if(empresa == 2) {
			$('.campos').hide();
		}

		e.preventDefault();
		
        pc++; //text box increment
        $("#PCount").val(pc);
		//console.log($("#PCount").val(pc));
        $(".input_fields_wrap9").append('\
            <div class="form-group" id="9div'+pc+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
						<div class="row">\
							<div class="col-md-8">\
								<input type="hidden" class="form-control" id="idTab_Valor_Produto'+pc+'" name="idTab_Valor_Produto'+pc+'" value="">\
								<input type="hidden" class="form-control" id="idTab_Produtos_Produto'+pc+'" name="idTab_Produtos_Produto'+pc+'" value="">\
								<input type="hidden" class="form-control" id="ComissaoProduto'+pc+'" name="ComissaoProduto'+pc+'" value="0.00">\
								<input type="hidden" class="form-control" id="Prod_Serv_Produto'+pc+'" name="Prod_Serv_Produto'+pc+'" value="">\
								<input type="hidden" class="form-control" id="NomeProduto'+pc+'" name="NomeProduto'+pc+'" value="">\
								<div class="row">\
									<div class="col-md-12">\
										<label for="idTab_Produto">Produto '+pc+':</label><br>\
										<select class="form-control Chosen" id="listadinamicab'+pc+'" name="idTab_Produto'+pc+'" onchange="'+buscavalor+'(this.value,this.name,\''+tblbusca+'\','+pc+',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')">\
											<option value="">-- Selecione uma opção --</option>\
										</select>\
									</div>\
								</div>\
								<div id="EscreverProduto'+pc+'" style="display:none">\
									<div class="row">\
										<div class="col-md-2">\
											<label for="QtdProduto">Qtd.Item</label><br>\
											<input type="text" class="form-control Numero" maxlength="10" id="QtdProduto'+pc+'" placeholder="0"\
												onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeydown="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
											   autofocus name="QtdProduto'+pc+'" value="1">\
										</div>\
										<div class="col-md-2">\
											<label for="QtdIncrementoProduto">Qtd.Embl</label><br>\
											<input type="text" class="form-control Numero" maxlength="10" id="QtdIncrementoProduto'+pc+'" placeholder="0" '+ escrita +' \
												onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTDINC\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeydown="calculaSubtotal(this.value,this.name,'+pc+',\'QTDINC\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
											   name="QtdIncrementoProduto'+pc+'" value="1">\
										</div>\
										<input type="hidden" class="form-control" id="SubtotalComissaoProduto'+pc+'" name="SubtotalComissaoProduto'+pc+'" value="0.00">\
										<div class="col-md-2">\
											<label for="SubtotalQtdProduto">Sub.Qtd.Prod</label><br>\
											<div id="txtHint">\
												<input type="text" class="form-control Numero text-right" maxlength="10" readonly="" id="SubtotalQtdProduto'+pc+'"\
													   name="SubtotalQtdProduto'+pc+'" value="">\
											</div>\
										</div>\
										<div class="col-md-3">\
											<label for="ValorProduto">Valor da Embl</label><br>\
											<div class="input-group id="txtHint">\
												<span class="input-group-addon" id="basic-addon1">R$</span>\
												<input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
													onfocus="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'VP\',\'Produto\')"\
													name="ValorProduto'+pc+'" value="">\
											</div>\
										</div>\
										<div class="col-md-3">\
											<label for="SubtotalProduto">Sub.Valor.Prod</label><br>\
											<div class="input-group id="txtHint">\
												<span class="input-group-addon" id="basic-addon1">R$</span>\
												<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="SubtotalProduto'+pc+'" readonly=""\
													   name="SubtotalProduto'+pc+'" value="">\
											</div>\
										</div>\
									</div>\
									<div class="row">\
										<div class="col-md-2">\
											<label for="PrazoProduto">Prazo(Dias)</label><br>\
											<input type="text" class="form-control Numero" maxlength="3" placeholder="0" id="PrazoProduto'+pc+'" name="PrazoProduto'+pc+'" value="0" >\
										</div>\
										<div class="col-md-10">\
											<label for="ObsProduto">Observacao</label><br>\
											<input type="text" class="form-control" maxlength="200" placeholder="Observacao:" id="ObsProduto'+pc+'"\
											   name="ObsProduto'+pc+'" value=""></input>\
										</div>\
									</div>\
								</div>\
							</div>\
							<div class="col-md-4">\
								<div class="row">\
									<div class="col-md-6 text-left">\
										<label><br></label><br>\
										<a href="#" id="'+pc+'" class="remove_field9 btn btn-danger"\
												onclick="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',1,'+pc+',\'CountMax\',0,\'ProdutoHidden\')">\
											<span class="glyphicon glyphicon-trash"></span>\
										</a>\
									</div>\
								</div>\
								<div id="EntregueProduto'+pc+'" style="display:none">\
									<div class="row">\
										<div class="col-md-6">\
											<label for="ConcluidoProduto">Entregue? </label><br>\
											<div class="btn-group" data-toggle="buttons">\
												<label class="btn btn-warning active" name="radio_ConcluidoProduto'+pc+'" id="radio_ConcluidoProduto'+pc+'N">\
												<input type="radio" name="ConcluidoProduto'+pc+'" id="rdgrldnmc_prd"\
													onchange="carregaEntreguePrd(this.value,this.name,'+pc+',0)" autocomplete="off" value="N" checked>Não\
												</label>\
												<label class="btn btn-default" name="radio_ConcluidoProduto'+pc+'" id="radio_ConcluidoProduto'+pc+'S">\
												<input type="radio" name="ConcluidoProduto'+pc+'" id="rdgrldnmc_prd"\
													onchange="carregaEntreguePrd(this.value,this.name,'+pc+',0)" autocomplete="off" value="S" >Sim\
												</label>\
											</div>\
										</div>\
									</div>\
									<div id="ConcluidoProduto'+pc+'" style="display:none">\
										<div class="row">\
											<div class="col-md-6">\
												<label for="DataConcluidoProduto">Data Entregue</label>\
												<div class="input-group DatePicker">\
													<span class="input-group-addon" disabled>\
														<span class="glyphicon glyphicon-calendar"></span>\
													</span>\
													<input type="text" class="form-control Date" id="DataConcluidoProduto'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
														   name="DataConcluidoProduto'+pc+'" value="">\
												</div>\
											</div>\
											<div class="col-md-6">\
												<label for="HoraConcluidoProduto">Hora Entregue</label>\
												<div class="input-group TimePicker">\
													<span class="input-group-addon" disabled>\
														<span class="glyphicon glyphicon-time"></span>\
													</span>\
													<input type="text" class="form-control Time" id="HoraConcluidoProduto'+pc+'" maxlength="5" placeholder="HH:MM"\
														   name="HoraConcluidoProduto'+pc+'" value="">\
												</div>\
											</div>\
										</div>\
									</div>\
								</div>\
							</div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//habilita o botão de calendário após a geração dos campos dinâmicos 
		$('.DatePicker').datetimepicker(dateTimePickerOptions);
		//Falta habilitar o botão de Tempo após a geração dos campos dinâmicos 
		//$('.TimePicker').datetimepicker(TimePickerOptions);
		
		//get a reference to the select element

		$select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
			
			//url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=90',
			url: window.location.origin+ '/' + app + '/Getvalues_json.php?' + endereco + "&tipo_orca=" + tipo_orca,
			
			dataType: 'JSON',
            type: "GET",
            success: function (data) {
				//clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Selecione uma opção --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais opções",
                    single_text: "Selecione uma opção",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1">ERRO</option>');
            }

        });
		
		//get a reference to the select element
        $select20 = $('#listadinamica_prof_prod'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json2.php?q=3',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select20.html('');
                //iterate over the data and append a select option
                $select20.append('<option value="">-- Sel. Profis. --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select20.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen20').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais opções",
                    single_text: "Selecione uma opção",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select20.html('<option id="-1">ERRO</option>');
            }

        });		
		
		//permite o uso de radio buttons nesse bloco dinâmico
		$('input:radio[id="rdgrldnmc_prd"]').change(function() {
			
			var value_prd = $(this).val();
			var name_prd = $(this).attr("name");
			//console.log(value_prd + ' <<>> ' + name_prd);
			$('label[name="radio_' + name_prd + '"]').removeClass();
			$('label[name="radio_' + name_prd + '"]').addClass("btn btn-default");
			$('#radio_' + name_prd + value_prd).addClass("btn btn-warning active");
			
			if(value_prd == "S"){
				$("#"+name_prd).css("display","");
			}else{
				$("#"+name_prd).css("display","none");
			}
		});

    });
		
	//adiciona campos dinamicamente dos Serviços 
    var ps = $("#SCount").val(); //initlal text box count
	$(".add_field_button10").click(function(e){ //on add input button click
        
		var negocio = $('#Negocio').val();
		//console.log( negocio );
		
		if (negocio == 1) {
			var endereco_serv = 'q=902';
			var tipo_orca = $('#Tipo_Orca').val();
			console.log( tipo_orca );
			var escrita_serv = 'readonly=""';
			var buscavalor_serv = 'buscaValor1Tabelas';
			var tblbusca_serv = 'Valor';
		}
		if (negocio == 2) {
			var endereco_serv = 'q=202';
			var tipo_orca = $('#Tipo_Orca').val();
			var escrita_serv = '';
			var buscavalor_serv = 'buscaValor2Tabelas';
			var tblbusca_serv = 'Produtos';
		}
		
		e.preventDefault();
    
		ps++; //text box increment
		$("#SCount").val(ps);
		
		$(".input_fields_wrap10").append('\
			<div class="form-group" id="10div'+ps+'">\
				<div class="panel panel-danger">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-8">\
								<input type="hidden" class="form-control" id="idTab_Valor_Servico'+ps+'" name="idTab_Valor_Servico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="idTab_Produtos_Servico'+ps+'" name="idTab_Produtos_Servico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="ComissaoServico'+ps+'" name="ComissaoServico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="Prod_Serv_Servico'+ps+'" name="Prod_Serv_Servico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="NomeServico'+ps+'" name="NomeServico'+ps+'" value="">\
								<div class="row">\
									<div class="col-md-12">\
										<label for="idTab_Servico">Servico '+ps+':</label><br>\
										<select class="form-control Chosen4" id="listadinamica'+ps+'"  name="idTab_Servico'+ps+'" onchange="'+buscavalor_serv+'(this.value,this.name,\''+tblbusca_serv+'\','+ps+',\'Servico\'),calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')">\
											<option value="">-- Selecione uma opção --</option>\
										</select>\
									</div>\
								</div>\
								<div id="EscreverServico'+ps+'" style="display:none">\
									<div class="row">\
										<div class="col-md-2">\
											<label for="QtdServico">Qtd</label><br>\
											<input type="text" class="form-control Numero" maxlength="10" id="QtdServico'+ps+'" placeholder="0"\
												onkeyup="calculaSubtotal(this.value,this.name,'+ps+',\'QTD\',\'Servico\'),calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')"\
												name="QtdServico'+ps+'" value="1">\
										</div>\
										<div class="col-md-4">\
											<label for="ProfissionalServico'+ps+'">Profissional:</label>\
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen2"\
													 id="listadinamica_prof'+ps+'" name="ProfissionalServico'+ps+'">\
												<option value=""></option>\
											</select>\
										</div>\
										<input type="hidden" class="form-control Numero" id="QtdIncrementoServico'+ps+'" name="QtdIncrementoServico'+ps+'" value="1">\
										<input type="hidden" class="form-control" id="SubtotalComissaoServico'+ps+'" name="SubtotalComissaoServico'+ps+'" value="0.00">\
										<input type="hidden" class="form-control Numero" id="SubtotalQtdServico'+ps+'" name="SubtotalQtdServico'+ps+'" value="">\
										<div class="col-md-3">\
											<label for="ValorServico">Valor do Serviço</label><br>\
											<div class="input-group">\
												<span class="input-group-addon" id="basic-addon1">R$</span>\
												<input type="text" class="form-control Valor" id="idTab_Servico'+ps+'" maxlength="10" placeholder="0,00" \
													onkeyup="calculaSubtotal(this.value,this.name,'+ps+',\'VP\',\'Servico\')" onchange="calculaSubtotal(this.value,this.name,'+ps+',\'VP\',\'Servico\')"\
													name="ValorServico'+ps+'" value="">\
											</div>\
										</div>\
										<div class="col-md-3">\
											<label for="SubtotalServico">Sub.Valor.Serv.</label><br>\
											<div class="input-group id="txtHint">\
												<span class="input-group-addon" id="basic-addon1">R$</span>\
												<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico'+ps+'"\
													   name="SubtotalServico'+ps+'" value="">\
											</div>\
										</div>\
									</div>\
									<div class="row">\
										<div class="col-md-2">\
											<label for="PrazoServico">Prazo(Dias)</label><br>\
											<input type="text" class="form-control Numero" maxlength="3" placeholder="0" id="PrazoServico'+ps+'" name="PrazoServico'+ps+'" value="0">\
										</div>\
										<div class="col-md-10">\
											<label for="ObsServico">Observacao</label><br>\
											<input type="text" class="form-control " maxlength="200" id="ObsServico'+ps+'" placeholder="Observacao"\
												name="ObsServico'+ps+'" value="">\
										</div>\
									</div>\
								</div>\
							</div>\
							<div class="col-md-4">\
								<div class="row">\
									<div class="col-md-6 text-left">\
										<label><br></label><br>\
										<a href="#" id="'+ps+'" class="remove_field10 btn btn-danger"\
											onclick="calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',1,'+ps+',\'CountMax2\',0,\'ServicoHidden\')">\
											<span class="glyphicon glyphicon-trash"></span>\
										</a>\
									</div>\
								</div>\
								<div id="EntregueServico'+ps+'" style="display:none">\
									<div class="row">\
										<div class="col-md-6">\
											<label for="ConcluidoServico">Entregue? </label><br>\
											<div class="btn-group" data-toggle="buttons">\
												<label class="btn btn-warning active" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'N">\
												<input type="radio" name="ConcluidoServico'+ps+'" id="rdgrldnmc_srv"\
													onchange="carregaEntregueSrv(this.value,this.name,'+ps+',0)" autocomplete="off" value="N" checked>Não\
												</label>\
												<label class="btn btn-default" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'S">\
												<input type="radio" name="ConcluidoServico'+ps+'" id="rdgrldnmc_srv"\
													onchange="carregaEntregueSrv(this.value,this.name,'+ps+',0)" autocomplete="off" value="S" >Sim\
												</label>\
											</div>\
										</div>\
									</div>\
									<div id="ConcluidoServico'+ps+'" style="display:none">\
										<div class="row">\
											<div class="col-md-6">\
												<label for="DataConcluidoServico">Data Entregue</label>\
												<div class="input-group DatePicker">\
													<span class="input-group-addon" disabled>\
														<span class="glyphicon glyphicon-calendar"></span>\
													</span>\
													<input type="text" class="form-control Date" id="DataConcluidoServico'+ps+'" maxlength="10" placeholder="DD/MM/AAAA"\
														   name="DataConcluidoServico'+ps+'" value="">\
												</div>\
											</div>\
											<div class="col-md-6">\
												<label for="HoraConcluidoServico">Hora Entregue</label>\
												<div class="input-group TimePicker">\
													<span class="input-group-addon" disabled>\
														<span class="glyphicon glyphicon-time"></span>\
													</span>\
													<input type="text" class="form-control Time" id="HoraConcluidoServico'+ps+'" maxlength="5" placeholder="HH:MM"\
														   name="HoraConcluidoServico'+ps+'" value="">\
												</div>\
											</div>\
										</div>\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>'
		); //add input box

		//habilita o botão de calendário após a geração dos campos dinâmicos
		$('.DatePicker').datetimepicker(dateTimePickerOptions);
		
		//get a reference to the select element
		$select = $('#listadinamica'+ps);

		//request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?' + endereco_serv + "&tipo_orca=" + tipo_orca,
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Selecione uma opção --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen4').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais opções",
                    single_text: "Selecione uma opção",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1">ERRO</option>');
            }

        });
		
		//get a reference to the select element
        $select2 = $('#listadinamica_prof'+ps);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json2.php?q=3',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select2.html('');
                //iterate over the data and append a select option
                $select2.append('<option value="">-- Sel. Profis. --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select2.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen2').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais opções",
                    single_text: "Selecione uma opção",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select2.html('<option id="-1">ERRO</option>');
            }

        });		

		//permite o uso de radio buttons nesse bloco dinâmico
		$('input:radio[id="rdgrldnmc_srv"]').change(function() {

			var value_srv = $(this).val();
			var name_srv = $(this).attr("name");

			//console.log(value_srv + ' <<>> ' + name_srv);

			$('label[name="radio_' + name_srv + '"]').removeClass();
			$('label[name="radio_' + name_srv + '"]').addClass("btn btn-default");
			$('#radio_' + name_srv + value_srv).addClass("btn btn-warning active");
		
			if(value_srv == "S"){
				$("#"+name_srv).css("display","");
			}else{
				$("#"+name_srv).css("display","none");
			}

		});
		
	});
			
    //adiciona campos dinamicamente das Categorias
    var ps = $("#SCount").val(); //initlal text box count
    $(".add_field_button93").click(function(e){ //on add input button click
        
		// Coloquei esse código aqui, mas não sei se está fazendo diferença!!!/////
		if (ps >= 2) {
			//console.log( $("#listadinamicah"+(ps-1)).val() );
			var chosen;
			chosen = $("#listadinamicah"+(ps-1)).val();
			//console.log( chosen + ' :: ' + ps );
		}
		
		// Termina aqui!!! ////
		
		e.preventDefault();
		
        ps++; //text box increment
        $("#SCount").val(ps);

        $(".input_fields_wrap93").append('\
            <div class="form-group" id="93div'+ps+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
                        <div class="row">\
							<div class="col-md-10">\
								<label for="Cat_Prod'+ps+'">Cat_Prod:</label>\
								<select data-placeholder="Selecione uma opção..." class="form-control"\
										 id="listadinamicah'+ps+'" name="Cat_Prod'+ps+'">\
									<option value=""></option>\
								</select>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+ps+'" class="remove_field93 btn btn-danger"\
										onclick="calculaQtdSoma(\'Cat_Prod\',\'QtdSoma\',\'ProdutoSoma\',1,'+ps+',\'CountMax\',0,\'ProdutoHidden\')">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//habilita o botão de calendário após a geração dos campos dinâmicos
		$('.DatePicker').datetimepicker(dateTimePickerOptions);
		
		//get a reference to the select element
        $select = $('#listadinamicah'+ps);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=93',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Selecione uma opção --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais opções",
                    single_text: "Selecione uma opção",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1">ERRO</option>');
            }

        });				

		//permite o uso de radio buttons nesse bloco dinâmico
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });
		
    //adiciona campos dinamicamente das Cor e Tipos	
    var pc = $("#PCount").val(); //initlal text box count
    $(".add_field_button92").click(function(e){ //on add input button click
        
		e.preventDefault();
		/*
		// Coloquei esse código aqui, mas não sei se está fazendo diferença!!!/////
		if (pc >= 2) {
			//console.log( $("#listadinamica10"+(pc-1)).val() );
			var chosen;
			chosen = $("#listadinamica10"+(pc-1)).val();
			//console.log( chosen + ' :: ' + pc );			
		}
		*/
        pc++; //text box increment
        $("#PCount").val(pc);

        $(".input_fields_wrap92").append('\
            <div class="form-group" id="92div'+pc+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
						<div class="row">\
							<div class="col-md-10">\
								<label for="Cor_Prod'+pc+'">Tipo '+pc+'</label>\
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen" \
										 id="listadinamica10'+pc+'" name="Cor_Prod'+pc+'">\
									<option value=""></option>\
								</select>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+pc+'" class="remove_field92 btn btn-danger">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//get a reference to the select element
        $select = $('#listadinamica10'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=92',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Selecione uma opção --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais opções",
                    single_text: "Selecione uma opção",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1">ERRO</option>');
            }

        });		
		
		//permite o uso de radio buttons nesse bloco dinâmico
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });
	
    //adiciona campos dinamicamente do Atributo 2
    var pm = $("#PMCount").val(); //initlal text box count
    $(".add_field_button91").click(function(e){ //on add input button click
        
		e.preventDefault();

		// Coloquei esse código aqui, mas não sei se está fazendo diferença!!!/////
		if (pm >= 2) {
			//console.log( $("#listadinamicag"+(pm-1)).val() );
			var chosen;
			chosen = $("#listadinamicag"+(pm-1)).val();
			//console.log( chosen + ' :: ' + pm );			
		}
		
        pm++; //text box increment
        $("#PMCount").val(pm);

        $(".input_fields_wrap91").append('\
            <div class="form-group" id="91div'+pm+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
						<div class="row">\
							<div class="col-md-10">\
								<label for="idTab_Opcao3'+pm+'">Opcao '+pm+'</label>\
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen91" \
										 id="listadinamicag'+pm+'" name="idTab_Opcao3'+pm+'">\
									<option value=""></option>\
								</select>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+pm+'" class="remove_field91 btn btn-danger">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//get a reference to the select element
        $select = $('#listadinamicag'+pm);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=101',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Sel. Opção Atr. 2 --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen91').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais opções",
                    single_text: "Selecione uma opção",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1"></option>');
            }

        });		
		
		//permite o uso de radio buttons nesse bloco dinâmico
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });
	
    //adiciona campos dinamicamente dos Produtos Derivados 
    var pd = $("#PDCount").val(); //initlal text box count
    $(".add_field_button97").click(function(e){ //on add input button click
        e.preventDefault();
		/*
		// Coloquei esse código aqui, mas não sei se está fazendo diferença!!!/////
		if (pc >= 2) {
			//console.log( $("#listadinamicag"+(pc-1)).val() );
			var chosen;
			chosen = $("#listadinamicam"+(pc-1)).val();
			//console.log( chosen + ' :: ' + pc );
			var chosen2;
			chosen2 = $("#listadinamican"+(pc-1)).val();			
		}
		*/
		// Termina aqui!!! ////		
		
        pd++; //text box increment
        $("#PDCount").val(pd);

        $(".input_fields_wrap97").append('\
            <div class="form-group" id="97div'+pd+'">\
                <div class="panel panel-success">\
                    <div class="panel-heading">\
                        <div class="row">\
							<div class="col-md-3">\
								<label for="Nome_Prod'+pd+'">Produto '+pd+'</label>\
								<input type="text" class="form-control" id="Nome_Prod'+pd+'" readonly=""\
										  name="Nome_Prod'+pd+'" value="">\
							</div>\
							<div class="col-md-3">\
								<label for="Opcao_Atributo_2'+pd+'">Atributo1</label>\
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen2" id="listadinamican'+pd+'" name="Opcao_Atributo_2'+pd+'">\
									<option value="">-- Selecione uma opção --</option>\
								</select>\
							</div>\
							<div class="col-md-3">\
                                <label for="Opcao_Atributo_1'+pd+'">Atributo2</label>\
                                <select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="listadinamicam'+pd+'" name="Opcao_Atributo_1'+pd+'">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
							<div class="col-md-2">\
								<label for="Valor_Produto'+pd+'">Valor Custo</label><br>\
								<div class="input-group id="Valor_Produto'+pd+'">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" id="Valor_Produto'+pd+'" maxlength="10" placeholder="0,00" \
										name="Valor_Produto'+pd+'" value="">\
								</div>\
							</div>\
							<div class="col-md-1">\
                                <label><br></label><br>\
                                <a href="#" id="'+pd+'" class="remove_field97 btn btn-danger">\
                                    <span class="glyphicon glyphicon-trash"></span>\
                                </a>\
                            </div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//habilita o botão de calendário após a geração dos campos dinâmicos
		$('.DatePicker').datetimepicker(dateTimePickerOptions);
		
		//get a reference to the select element
        $select = $('#listadinamicam'+pd);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=97',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Sel. Opcao --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais opções",
                    single_text: "Selecione uma opção",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1"></option>');
            }

        });
		
		//get a reference to the select element
        $select2 = $('#listadinamican'+pd);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=98',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select2.html('');
                //iterate over the data and append a select option
                $select2.append('<option value="">-- Sel. Opcao --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select2.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen2').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais opções",
                    single_text: "Selecione uma opção",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select2.html('<option id="-1"></option>');
            }

        });		

		//permite o uso de radio buttons nesse bloco dinâmico
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });	
			
    //Remove os campos adicionados de Produtos No Orçamento dinamicamente
    $(".input_fields_wrap9").on("click",".remove_field9", function(e){ //user click on remove text
        $("#9div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaOrcamento();
    })	

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap10").on("click",".remove_field10", function(e){ //user click on remove text
        $("#10div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaOrcamento();
    })
	
    //Remove os campos adicionados dinamicamente das Categorias
    $(".input_fields_wrap93").on("click",".remove_field93", function(e){ //user click on remove text
        $("#93div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados dinamicamente das Cores e Tipos
    $(".input_fields_wrap92").on("click",".remove_field92", function(e){ //user click on remove text
        $("#92div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados dinamicamente das Tamanhos
    $(".input_fields_wrap91").on("click",".remove_field91", function(e){ //user click on remove text
        $("#91div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados de Produtos No Orçamento do CONSULTOR dinamicamente
    $(".input_fields_wrap97").on("click",".remove_field97", function(e){ //user click on remove text
        $("#97div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados de Produtos No Orçamento do CONSULTOR dinamicamente
    $(".input_fields_wrap99").on("click",".remove_field99", function(e){ //user click on remove text
        $("#99div"+$(this).attr("id")).remove();
    })

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap3").on("click",".remove_field3", function(e){ //user click on remove text
		$("#3div"+$(this).attr("id")).remove();
    })	
	
    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap32").on("click",".remove_field32", function(e){ //user click on remove text
        $("#32div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap33").on("click",".remove_field33", function(e){ //user click on remove text
        $("#33div"+$(this).attr("id")).remove();
    })	

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap30").on("click",".remove_field30", function(e){ //user click on remove text
        $("#30div"+$(this).attr("id")).remove();
    })
	
    //Remove as PARCELAS dinamicamente
    $(".input_fields_wrap21").on("click",".remove_field21", function(e){ //user click on remove text
        $("#21div"+$(this).attr("id")).remove();
    })
	
    /*
     * Função para capturar o valor escolhido no campo select (Serviço e Produto, por exemplo)
     */
    $("#addValues").change(function () {
        //var n = $(this).attr("value");
        //var n = $("option:selected", this);

        alert (this.value);

        //alert('oi');
    });

    /*
     * As duas funções a seguir servem para exibir ou ocultar uma div em função
     * do seu nome
     */
    $("input[id$='hide']").click(function () {
        var n = $(this).attr("name");
        $("#" + n).hide();
    });
    $("input[id$='show']").click(function () {
        var n = $(this).attr("name");
        $("#" + n).show();
    });

    /*
     * Mesma função que a de cima mas com uma modificação para funcionar nos
     * radios buttons e permitir a alternância da cor do botão
     */
     $("input[id$='hideradio']").change(function () {
         var n = $(this).attr("name");
         $("#" + n).hide();
         radioButtonColorNS(n, 'hideradio');
     });
     $("input[id$='showradio']").change(function () {
         var n = $(this).attr("name");
         $("#" + n).show();
         radioButtonColorNS(n, 'showradio');
     });

    /*
     * A função a seguir servem para exibir ou ocultar uma div em função do
     * valor selecionado no select/pulldown
     */
    $('#SelectShowHide').change(function () {
        $('.colors').hide();
        $('.div' + $(this).val()).show();
    });

    $('#SelectShowHideId').change(function () {
        var n = $(this).attr("name");
        //alert(n + $(this).val());
        //$('#' + n).hide();
        $('.' + n).hide();
        $('#' + n + $(this).val()).show();
    });

    $('.Chosen').chosen({
        disable_search_threshold: 10,
        multiple_text: "Selecione uma ou mais opções",
        single_text: "Selecione uma opção",
        no_results_text: "Nenhum resultado para",
        width: "100%"
    });

    $("button.fc-today-button").click(function () {
        $('#datepickerinline').datetimepicker({
            today: '2011-01-01',
        });
        alert(date);
    });
	
    $('.DatePicker').datetimepicker(dateTimePickerOptions);
    $('.TimePicker').datetimepicker({
        tooltips: {
            today: 'Hoje',
            clear: 'Limpar seleção',
            close: 'Fechar este menu',
            selectMonth: 'Selecione um mês',
            prevMonth: 'Mês anterior',
            nextMonth: 'Próximo mês',
            selectYear: 'Selecione um ano',
            prevYear: 'Ano anterior',
            nextYear: 'Próximo ano',
            selectDecade: 'Selecione uma década',
            prevDecade: 'Década anterior',
            nextDecade: 'Próxima década',
            prevCentury: 'Centenário anterior',
            nextCentury: 'Próximo centenário',
            incrementHour: 'Aumentar hora',
            decrementHour: 'Diminuir hora',
            incrementMinute: 'Aumentar minutos',
            decrementMinute: 'Diminuir minutos',
            incrementSecond: 'Aumentar segundos',
            decrementSecond: 'Diminuir segundos',
        },
        showTodayButton: true,
        showClose: true,
        //stepping: 30,
        format: 'HH:mm',
        locale: 'pt-br'
    });
});
$('#datepickerinline').datetimepicker({
    tooltips: {
        today: 'Hoje',
        clear: 'Limpar seleção',
        close: 'Fechar este menu',
        selectMonth: 'Selecione um mês',
        prevMonth: 'Mês anterior',
        nextMonth: 'Próximo mês',
        selectYear: 'Selecione um ano',
        prevYear: 'Ano anterior',
        nextYear: 'Próximo ano',
        selectDecade: 'Selecione uma década',
        prevDecade: 'Década anterior',
        nextDecade: 'Próxima década',
        prevCentury: 'Centenário anterior',
        nextCentury: 'Próximo centenário',
        incrementHour: 'Aumentar hora',
        decrementHour: 'Diminuir hora',
        incrementMinute: 'Aumentar minutos',
        decrementMinute: 'Diminuir minutos',
        incrementSecond: 'Aumentar segundos',
        decrementSecond: 'Diminuir segundos'
    },
    inline: true,
    showTodayButton: true,
    //showClear: true,
    format: 'DD/MM/YYYY',
    //defaultDate: '2015-01-01',
    locale: 'pt-br'
});


$("#datepickerinline").on("dp.change", function (e) {
    var d = new Date(e.date);
    $('#calendar').fullCalendar('gotoDate', d);
});

/*
 * veio junto com o último datetimepicker, não parei pra analisar sua relevância
 * vou deixar aqui por enquanto
 * http://eonasdan.github.io/bootstrap-datetimepicker/
 * */

ko.bindingHandlers.dateTimePicker = {
    init: function (element, valueAccessor, allBindingsAccessor) {
        //initialize datepicker with some optional options
        var options = allBindingsAccessor().dateTimePickerOptions || {};
        $(element).datetimepicker(options);
        //when a user changes the date, update the view model
        ko.utils.registerEventHandler(element, "dp.change", function (event) {
            var value = valueAccessor();
            if (ko.isObservable(value)) {
                if (event.date != null && !(event.date instanceof Date)) {
                    value(event.date.toDate());
                } else {
                    value(event.date);
                }
            }
        });
        ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
            var picker = $(element).data("DateTimePicker");
            if (picker) {
                picker.destroy();
            }
        });
    },
    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {

        var picker = $(element).data("DateTimePicker");
        //when the view model is updated, update the widget
        if (picker) {
            var koDate = ko.utils.unwrapObservable(valueAccessor());
            //in case return from server datetime i am get in this form for example /Date(93989393)/ then fomat this
            koDate = (typeof (koDate) !== 'object') ? new Date(parseFloat(koDate.replace(/[^0-9]/g, ''))) : koDate;
            picker.date(koDate);
        }
    }
};
function EventModel() {
    this.ScheduledDate = ko.observable('');
}
ko.applyBindings(new EventModel());
/*
 $("#inputDate").mask("99/99/9999");
 $("#inputDate0").mask("99/99/9999");
 $("#inputDate1").mask("99/99/9999");
 $("#inputDate2").mask("99/99/9999");
 $("#inputDate3").mask("99/99/9999");
 $("#Cpf").mask("999.999.999-99");
 $("#Cep").mask("99999-999");
 $("#TituloEleitor").mask("9999.9999.9999");
 */

$('#popoverData').popover();
$('#popoverOption').popover({trigger: "hover"});
var tempo = 5 * 60 * 60 * 1000;
//var tempo = 10 * 1000;
//var date = new Date(new Date().valueOf() + 60 * 60 * 1000);
var date = new Date(new Date().valueOf() + tempo);
$('#clock').countdown(date, function (event) {
    $(this).html(event.strftime('%H:%M:%S'));
});
var branco = tempo - 1200000;
$('#countdowndiv').delay(branco).queue(function () {
    $(this).addClass("btn-warning");
});
$('#submit').on('click', function () {
    var $btn = $(this).button('loading')
})

jQuery(document).ready(function ($) {
    $(".clickable-row").click(function () {
        if(!$(event.target).hasClass('notclickable'))
           window.location = $(this).data("href");
        else
            event.stopPropagation();
    });

});
setTimeout(function () {
    $('#hidediv').fadeOut('slow');
}, 3000); // <-- time in milliseconds

setTimeout(function () {
    $('#hidediverro').fadeOut('slow');
}, 10000); // <-- time in milliseconds

$(document).ready(function () {
    $(".js-data-example-ajax").select2({
        ajax: {
            url: "https://api.github.com/search/repositories",
            //url: "http://localhost/sisgef/testebd.php",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, page) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data
                return {
                    results: data.items
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
});
$(document).ready(function () {
    $(".js-example-basic-single").select2();
});
//Determina a raiz do site
var pathArray = window.location.pathname.split('/');
var basePath = window.location.protocol + "//" + window.location.host + "/" + pathArray[1];
$("#series").remoteChained({
    parents: "#mark",
    url: basePath + "/api/teste.php"
});
$("#StatusAntigo").remoteChained({
    parents: "#Especialidade",
    url: basePath + "/api/teste.php",
    loading: "Carregando...",
});
$('#Chosen').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#id_Municipio').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#Uf').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#Municipio').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#EstadoCivil').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#Especialidade').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Cid').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Prestador').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Cirurgia').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Status').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Posicao').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#calendar').fullCalendar({
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    eventSources: [{
            url: 'Consulta_json.php', // use the `url` property
        }],
    //allDayDefault: true,
    defaultView: 'agendaWeek',
    //contentHeight: 700,
    height: 'auto',
    //handleWindowResize: false,
    //aspectRatio: 2,
	//showNonCurrentDates: false,
	fixedWeekCount: false,
    firstDay: '0',
	//minTime: '07:00',
    //maxTime: '21:00',
    scrollTime: '06:00',
	//minTime: '00:00',
    maxTime: '24:00',
    nowIndicator: true,
    selectable: true,
    //selectHelper: true,
    editable: false,
    timezone: "local",
    lang: 'pt-br',
    eventAfterRender: function (event, element) {

        if (event.Evento == 1)
            var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b>" + event.Obs + "<br>\n\<b>Prof.:</b> " + event.Profissional + "<br>\n\<b>Ocorrência:</b> " + event.Recorrencias + "<br>\n\<b>Termina em:</b> " + event.DataTermino;
        else {

            if (event.Paciente == 'D')
                var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b> " + event.Obs  + "<br>\n\<b>Prof.:</b> " + event.Profissional + "<br>\n\<b>Cliente: </b>" + event.title + "</b><br><b>Responsável:</b> " + event.subtitle + "<br><b>Tel.:</b> " + event.CelularCliente + 
							"<br>\n\<b>Tipo: </b> " + event.TipoConsulta + "<br>\n\<b>Ocorrência:</b> " + event.Recorrencias + "<br>\n\<b>Termina em:</b> " + event.DataTermino;
            else
                var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b> " + event.Obs + "<br>\n\<b>Prof.:</b> " + event.Profissional + "<br>\n\<b>Cliente: </b>" + event.title + "<b> " + "<br><b>Tel.:</b> " + event.CelularCliente + 
							"<br>\n\<b>Tipo: </b> " + event.TipoConsulta + "<br>\n\<b>Ocorrência:</b> " + event.Recorrencias + "<br>\n\<b>Termina em:</b> " + event.DataTermino;
        }


        $(element).tooltip({
            title: title,
            container: 'body',
            position: {my: "left bottom-3", at: "center top"},
            placement: 'auto top',
            html: true,
            delay: {"show": 500, "hide": 100},
            template: '<div class="tooltip" role="tooltip" ><div class="tooltip-inner" \n\
                    style="color: #000; border-radius: 4px; text-align: left; border-width: thin; border-style: solid; \n\
                    border-color: #000; background-color: #fff; white-space:pre-wrap;"></div></div>'
        });
    },
    /*
    selectConstraint: {
        start: agora,
        end: '2099-12-31T23:59:00'
    },*/
    select: function (start, end, jsEvent, view) {
        //var re = new RegExp(/^.*\//);
        //window.location = re.exec(window.location.href) + 'cliente/pesquisar?start=' + start + '&end=' + end;

        //alert(start + ' :: ' + end);

        //endtime = $.fullCalendar.formatDate(end, 'HH:mm');
        //starttime = $.fullCalendar.formatDate(start, 'DD/MM/YYYY, HH:mm');
        //var slot = 'start=' + start + '&end=' + end;

        $('#fluxo #start').val(start);
        $('#fluxo #end').val(end);
        //$('#fluxo #slot').text(slot);
        $('#fluxo').modal('show');
    },
});

/*
 * Redireciona o usuário de acordo com a opção escolhida no modal da agenda,
 * que surge ao clicar em algum slot de tempo vazio.
 */

function redirecionar_Funcionando(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 1) ? url = 'consulta/cadastrar_evento' : url = 'consulta/cadastrar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}
 
 function redirecionar(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 1) ? url = 'consulta/cadastrar_evento' : url = 'cliente/pesquisar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}

function redirecionar1(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 1) ? url = 'consultaconsultor/cadastrar_evento' : url = 'consultaconsultor/cadastrar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}

function redirecionar2(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 1) ? url = 'consultafuncionario/cadastrar_evento' : url = 'consultafuncionario/cadastrar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}

function redirecionar3(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 3) ? url = 'consulta/cadastrar_particular' : url = 'cliente/pesquisar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}

/*
 * Função para capturar a url com o objetivo de obter a data, após criar/alterar
 * uma consulta, e assim usar a função gotoDate do Fullcalendar para mostrar a
 * agenda na data escolhida
 */
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
var gtd = getUrlParameter('gtd');
(gtd) ? $('#calendar').fullCalendar('gotoDate', gtd) : false;

