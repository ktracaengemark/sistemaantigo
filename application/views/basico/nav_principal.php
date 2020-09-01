<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="col-lg-12 col-md-12 col-sm-12 ">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
				<span class="sr-only">MENU</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<!--
			<a type="button" class="navbar-brand btn btn-sm" href="<?php echo base_url() ?>usuario2/prontuario/<?php echo $_SESSION['log']['idSis_Usuario']; ?>"> 
				 <?php echo $_SESSION['log']['Nome2']; ?>./<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
			</a>
			-->
			<?php echo form_open(base_url() . 'cliente/pesquisar', 'class="navbar-form navbar-left"'); ?>
			<div class="input-group">
				<span class="input-group-btn">
					<button class="btn btn-info btn-md" type="submit">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
				<input type="text" placeholder="Pesquisar Cliente" class="form-control btn-sm " name="Pesquisa" value="">
			</div>
			</form>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar1">

			<ul class="nav navbar-nav navbar-center">
				<!--
				<li>
					<?php echo form_open(base_url() . 'empresacli/pesquisar', 'class="navbar-form navbar-left"'); ?>
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-info" type="submit">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
						<input type="text" placeholder="Pesquisar Empresa" class="form-control" name="Pesquisa" value="">
					</div>
					</form>
				</li>
				-->
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<a type="button" class="btn btn-sm btn-info" role="button" href="<?php echo base_url(); ?>agenda">
							<span class="glyphicon glyphicon-calendar"></span> 
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
							Agendas
							<?php } else {?>
							Agenda
							<?php } ?>
						</a>
						<button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/tarefa"><span class="glyphicon glyphicon-pencil"></span> Estatística das Tarefas </a></li>
						</ul>
					</div>							
				</li>						
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<!--
						<a type="button" class="btn btn-sm btn-primary" role="button" href="<?php echo base_url(); ?>orcatrata/cadastrar3">
							Receitas<span class="glyphicon glyphicon-usd"></span><span class="glyphicon glyphicon-arrow-down"></span> & 
							Vendas<span class="glyphicon glyphicon-gift"></span><span class="glyphicon glyphicon-arrow-up"></span>

						</a>
						<button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
						</button>
						-->
						<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
							Receitas <span class="glyphicon glyphicon-usd"></span><span class="glyphicon glyphicon-arrow-down"></span> / 
							Vendas <span class="glyphicon glyphicon-gift"></span><span class="glyphicon glyphicon-arrow-up"></span> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li><a class="dropdown-item" href="<?php echo base_url() ?>orcatrata/cadastrar3"><span class="glyphicon glyphicon-plus"></span> Nova Receita / Venda</a></li>
							<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>orcatrata/pedido"><span class="glyphicon glyphicon-edit"></span> Atualizar Status dos Pedidos</a></li>
							<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/parcelasrec"><span class="glyphicon glyphicon-pencil"></span> Relatório das Receitas</a></li>
							<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/orcamento"><span class="glyphicon glyphicon-pencil"></span> Relatorio de Orçamentos</a></li>
							<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/rankingformapag"><span class="glyphicon glyphicon-pencil"></span> Ranking de Pagamento</a></li>
							<li role="separator" class="divider"></li>
							<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
							<!--<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/orcamentoonline"><span class="glyphicon glyphicon-pencil"></span> Orçamentos Online</a></li>
							<li role="separator" class="divider"></li>							
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/produtosvendaonline"><span class="glyphicon glyphicon-pencil"></span> Produtos Vendidos Online</a></li>
							<li role="separator" class="divider"></li>-->
							<?php } else {?>
							<!--<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/orcamentoonlineempresa"><span class="glyphicon glyphicon-pencil"></span> Orçamentos Online</a></li>
							<li role="separator" class="divider"></li>							
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/comissao"><span class="glyphicon glyphicon-pencil"></span> Relatório de Vendas Online</a></li>
							<li role="separator" class="divider"></li>-->							
							<?php } ?>
							<!--<li><a href="<?php echo base_url() ?>relatorio/rankingreceitas"><span class="glyphicon glyphicon-equalizer"></span> Estatística das Receitas</a></li>-->
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
							<!--<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/fiadorec"><span class="glyphicon glyphicon-usd"></span> Fiado das Vendas</a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/produtosvend"><span class="glyphicon glyphicon-pencil"></span> Produtos Vendidos</a></li>
							<li role="separator" class="divider"></li>-->
							<li><a href="<?php echo base_url() ?>relatorio/rankingvendas"><span class="glyphicon glyphicon-pencil"></span> Ranking de Clientes</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/rankingformaentrega"><span class="glyphicon glyphicon-pencil"></span> Ranking de Entrega</a></li>
							<?php } ?>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>							
						</ul>
					</div>							
				</li>
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<!--
						<a type="button" class="btn btn-sm btn-danger" role="button" href="<?php echo base_url(); ?>orcatrata/cadastrardesp">
							Despesas<span class="glyphicon glyphicon-usd"></span><span class="glyphicon glyphicon-arrow-up"></span>/ 
							Compras<span class="glyphicon glyphicon-gift"></span><span class="glyphicon glyphicon-arrow-down"></span>
						</a>
						<button type="button" class="btn btn-sm btn-danger dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="caret"></span>
						</button>
						-->
						<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
							Despesas <span class="glyphicon glyphicon-usd"></span><span class="glyphicon glyphicon-arrow-up"></span>/ 
							Compras <span class="glyphicon glyphicon-gift"></span><span class="glyphicon glyphicon-arrow-down"></span> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li><a class="dropdown-item" href="<?php echo base_url() ?>orcatrata/cadastrardesp"><span class="glyphicon glyphicon-plus"></span> Nova Despesa / Compra</a></li>
							<li role="separator" class="divider"></li>
							<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/parcelasdesp"><span class="glyphicon glyphicon-pencil"></span> Relatório das Despesas</a></li>
							<li role="separator" class="divider"></li>
							<!--<li><a href="<?php echo base_url() ?>relatorio/rankingdespesas"><span class="glyphicon glyphicon-equalizer"></span> Estatística das Despesas</a></li>-->
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
							<!--<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/fiadodesp"><span class="glyphicon glyphicon-usd"></span> Fiado das Compras</a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/produtoscomp"><span class="glyphicon glyphicon-pencil"></span> Produtos Comprados </a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/rankingcompras"><span class="glyphicon glyphicon-pencil"></span> Ranking de Compras</a></li>-->
							<?php } ?>
							<!--<li role="separator" class="divider"></li>-->
							<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>							
						</ul>
					</div>							
				</li>
				<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-pencil"></span> Cadastros<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<!--<li><a href="<?php echo base_url() . 'OrcatrataPrintCobranca/imprimir/' . $_SESSION['log']['idSis_Empresa']; ?>"><span class="glyphicon glyphicon-user"></span> Cobranca</a></li>
							<li role="separator" class="divider"></li>-->							
							<li><a href="<?php echo base_url() ?>cliente/pesquisar"><span class="glyphicon glyphicon-user"></span> Clientes com filtro</a></li>
							<li role="separator" class="divider"></li>
							<!--<li><a href="<?php echo base_url() ?>relatorio/clientes"><span class="glyphicon glyphicon-user"></span> Clientes Lista </a></li>
							<li role="separator" class="divider"></li>-->
							<li><a href="<?php echo base_url() ?>relatorio/fornecedor"><span class="glyphicon glyphicon-user"></span> Fornecedores </a></li>
							<!--<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>login/registrar2"><span class="glyphicon glyphicon-user"></span> Conta Pessoal</a></li>-->
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/atributo"><span class="glyphicon glyphicon-pencil"></span> Atributos </a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/catprod"><span class="glyphicon glyphicon-pencil"></span> Categorias </a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/produtos2"><span class="glyphicon glyphicon-gift"></span> Modelos </a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-gift"></span> Produtos Derivados </a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/precopromocao"><span class="glyphicon glyphicon-usd"></span> Produtos & Preços de Venda </a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/promocao"><span class="glyphicon glyphicon-usd"></span> Promoções & Preços de Venda </a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-gift"></span> Produtos & Estoque</a></li>							
							<!--<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/produtosvend"><span class="glyphicon glyphicon-pencil"></span> Produtos Vendidos</a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/produtoscomp"><span class="glyphicon glyphicon-pencil"></span> Produtos Comprados </a></li>-->
							<?php if ($_SESSION['log']['idSis_Empresa'] == 2 ) { ?>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/clenkontraki"><span class="glyphicon glyphicon-list-alt"></span> Clientes Enkontraki</a></li>									
							<?php } ?>
						</ul>
					</div>
				</li>
				<?php } ?>
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">								
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
							
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
								<span class="glyphicon glyphicon-hand-right"></span>
								<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?> 
								 / <span class="glyphicon glyphicon-home"></span> Admin / Sair
							<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
								<span class="glyphicon glyphicon-warning-sign"></span> Renovar ! 
								<span class="glyphicon glyphicon-home"></span> Admin / Sair
							<?php } else {?>
								<span class="glyphicon glyphicon-home"></span> enkontraki / Sair
							<?php } ?>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a href="<?php echo base_url() ?>acesso"> 
									<span class="glyphicon glyphicon-user"></span> Perfil
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a href="<?php echo base_url() ?>usuario2/prontuario/<?php echo $_SESSION['log']['idSis_Usuario']; ?>"> 
									<span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Nome2']; ?>./<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
								</a>
							</li>
							<li role="separator" class="divider"></li>							
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
							<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Administração</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Funcionários</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Renovar Assinatura</a></li>
							<li role="separator" class="divider"></li>
							<!--<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Cadastrar Empresa</a></li>
							<li role="separator" class="divider"></li>-->
							<li><a href="<?php echo base_url() ?>relatorio/slides"><span class="glyphicon glyphicon-user"></span> Slides</a></li>							
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/site"><span class="glyphicon glyphicon-user"></span> Site</a></li>
							<li role="separator" class="divider"></li>							
							<?php } ?>
							<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-home"></span> Empresas</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>login/sair"><span class="glyphicon glyphicon-log-out"></span> Sair do Sistema</a></li>
						</ul>
					</div>
				</li>	
			</ul>
		</div>			
	</div>
</nav>
<br>