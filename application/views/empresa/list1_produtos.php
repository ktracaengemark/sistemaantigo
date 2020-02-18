<div class="container">
	<div class="row">
		<?php
			if($q){
				foreach ($q as $row){
				?>		
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<img class="team-img" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?>">
						<!--<a href="produto.php?id=<?php echo $row['idTab_Produto'];?>"><img class="team-img" src="arquivos/imagens/empresas/<?php echo $_SESSION['Empresa']['idSis_Empresa']; ?>/produtos/miniatura/<?php echo $row['Arquivo']; ?>" alt="" ></a>					 
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>-->
						
						<div class="card-body">
							<h4 class="card-title">
								<a href="produto.php?id=<?php echo $row['idTab_Produto'];?>"><?php echo utf8_encode ($row['Produtos']);?></a>
							</h4>
							<h5>R$ <?php echo number_format($row['ValorProduto'],2,",",".");?></h5>
							<!--<p><?php echo utf8_encode ($row['produto_breve_descricao']);?></p>-->
						</div>
					</div>
				</div>
				<?php 
				}
			}
		?>
	</div>
</div>