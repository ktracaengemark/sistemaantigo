<?php if ($msg) echo $msg; ?>
<div class="container-fluid">
    <div class="row">
        <div class="main">
            <?php echo validation_errors(); ?>
            <div class="panel panel-primary">
                <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
                <div class="panel-body">
                    <?php echo form_open('relatorioempresa/empresas', 'role="form"'); ?>

                    </form>

                    <?php echo (isset($list)) ? $list : FALSE ?>
                </div>
            </div>
        </div>
    </div>
</div>
