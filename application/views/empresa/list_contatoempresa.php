<?php (isset($contatoempresa)) ? $query = $contatoempresa : FALSE; ?>


<?php
foreach ($query->result_array() as $row) {

    if ($row['StatusVida'] == 'O') {
        $row['class'] = 'danger';
        #$row['icon'] = 'glyphicon glyphicon-info-sign';
        $row['vida'] = '<span class="label label-danger" style="font-size: 14px;">�bito</span>';
    } else {
        $row['class'] = 'info';
        #$row['icon'] = 'fa fa-user';
        $row['vida'] = '';
    }

    if ($row['Sexo'] == 'FEMININO') {
        $row['icon'] = 'fa fa-female';
        $row['icon-sex'] = 'fa fa-venus';
    }
    elseif ($row['Sexo'] == 'MASCULINO') {
        $row['icon'] = 'fa fa-male';
        $row['icon-sex'] = 'fa fa-mars';
    }
    else  {
        $row['icon'] = 'fa fa-user';
        $row['icon-sex'] = 'fa fa-genderless';
    }

    ?>

        <div class="bs-callout bs-callout-<?php echo $row['class']; ?>" id=callout-overview-not-both>

            <h4>
                <span class="<?php echo $row['icon']; ?>"></span>
                <?php echo $row['Nome'] . '</small></code>'; ?>
                <?php echo $row['vida']; ?>

			</h4>

            <p>
                <?php if ($row['DataNascimento']) { ?>
                <span class="glyphicon glyphicon-gift"></span> <b>Aniver.:</b> <?php echo $row['DataNascimento']; ?>-

					<b>Idade:</b> <?php echo $row['Idade']; ?>
            </p>
			<p>
				<?php } if ($row['Sexo']) { ?>
                <span class="<?php echo $row['icon-sex']; ?>"></span> <b>Sexo:</b> <?php echo $row['Sexo']; ?>
                <?php } ?>
			</p>
			<p>
				<?php if ($row['Celular']) { ?>
				<span class="glyphicon glyphicon-phone-alt"></span> <b>Telefone:</b> <?php echo $row['Celular']; ?>
				<?php } ?>
            </p>

        </div>

<?php } ?>
