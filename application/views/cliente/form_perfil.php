<?php if (isset($msg)) echo $msg; ?>

<div class="row">

    <div class="col-md-2"></div>
    <div class="col-md-8">

        <?php echo validation_errors(); ?>

        <div class="panel panel-<?php echo $panel; ?>">

            <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
            <div class="panel-body">

                <?php echo form_open_multipart($form_open_path); ?>
				<!--
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Tipo">Tipo: *</label>
                            <select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="Tipo" name="Tipo" <?php echo $readonly; ?>> 
                                <option value=""></option>
                                <option value="R" <?php echo set_select('Tipo', 'R') . $default['R']; ?>>Revisão</option>
                                <option value="C" <?php echo set_select('Tipo', 'C') . $default['C']; ?>>Complemento</option>
                            </select>                            
                        </div>                        
                    </div>
                </div>                
                -->
                <?php if ($metodo != 3) { ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="Arquivo">Arquivo: *</label>
                            <input type="file" class="file" multiple="false" data-show-upload="false" data-show-caption="true" 
                                   name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
                        </div>
                    </div>
                </div>

                <?php } else { ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="Arquivo">Arquivo: *</label><br>
                            <a href="<?php echo base_url() . 'arquivos/imagens/clientes//' . $file['Arquivo']?>" target="_blank" class="btn btn-info">
                                <span class="glyphicon glyphicon-file"></span> Visualizar
                            </a>
                            <?php echo $file['Arquivo']; ?>
                        </div>
                    </div>
                </div>                
                
                <?php } ?>
                
                <br>



                    <div class="form-group">
                        <div class="row">
                            <input type="hidden" name="idApp_Cliente" value="<?php echo $file['idApp_Cliente']; ?>">
                            <?php if ($metodo == 3) { ?>
                                <input type="hidden" name="idSis_Arquivo" value="<?php echo $file['idSis_Arquivo']; ?>">
                                <input type="hidden" name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
                                <div class="col-md-6">                            
                                    <button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." type="submit" name="submit">
                                        <span class="glyphicon glyphicon-trash"></span> Excluir
                                    </button>                            
                                </div>                        
                            <?php } else { ?>
                                <div class="col-md-6">                            
                                    <button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
                                        <span class="glyphicon glyphicon-save"></span> Salvar
                                    </button>                            
                                </div>                        
                            <?php } ?>     
                                <div class="col-md-6 text-right">
                                    <button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1); return true;">
                                        <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                                    </button>
                                </div>  
                        </div>
                    </div>                


                </form>

            </div>

        </div>

    </div>
    <div class="col-md-2"></div>

</div>


