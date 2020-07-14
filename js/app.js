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

    if (valor) {
        document.getElementById('submeter').style.display = "none";
		document.getElementById('submeter2').style.display = "none";
        document.getElementById('aguardar').style.display = "";
    }
    else {
        document.getElementById('submeter').style.display = "";
		document.getElementById('submeter2').style.display = "";
        document.getElementById('aguardar').style.display = "none";
    }

}

function DesabilitaBotaoExcluir (valor) {

    if (valor) {
		document.getElementById('submeter3').style.display = "none";
		document.getElementById('submeter4').style.display = "none";
        document.getElementById('aguardar').style.display = "";
    }
    else {
		document.getElementById('submeter3').style.display = "";
		document.getElementById('submeter4').style.display = "";
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
            if (cadastrar == 1)
                $("#DataPago"+i).val($("#DataVencimento"+i).val())
            else
                $("#DataPago"+i).val(currentDate.format('DD/MM/YYYY'))
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

/*
 * Função responsável por carregar valores nos respectivos campos do despesas
 * caso o botão Quitado seja alterado para SIM
 *
 * @param {int} quant
 * @param {string} campo
 * @param {int} num
 * @returns {decimal}
 */

 /*Carrega a Data do Dia do lançamento*/
function carregaQuitadoDespesas2(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#ValorPagoPagaveis"+i).val() || $("#ValorPagoPagaveis"+i).val() == "0,00")
            $("#ValorPagoPagaveis"+i).val($("#ValorParcelaPagaveis"+i).val())

		if (!$("#DataPagoPagaveis"+i).val()) {
            if (cadastrar == 1)
                $("#DataPagoPagaveis"+i).val($("#DataVencimentoPagaveis"+i).val())
            else
                $("#DataPagoPagaveis"+i).val(currentDate.format('DD/MM/YYYY'))
        }

    }
    else {

        $("#ValorPagoPagaveis"+i).val("")
        $("#DataPagoPagaveis"+i).val("")

    }

}

/*Carrega a Data do Dia do Vencimento*/
function carregaQuitadoDespesas(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#ValorPagoPagaveis"+i).val() || $("#ValorPagoPagaveis"+i).val() == "0,00")
            $("#ValorPagoPagaveis"+i).val($("#ValorParcelaPagaveis"+i).val())

		if (!$("#DataPagoPagaveis"+i).val()) {
            if (cadastrar == 1)
                $("#DataPagoPagaveis"+i).val($("#DataVencimentoPagaveis"+i).val())
            else
                $("#DataPagoPagaveis"+i).val($("#DataVencimentoPagaveis"+i).val())
        }

    }
    else {

        $("#ValorPagoPagaveis"+i).val("")
        $("#DataPagoPagaveis"+i).val("")

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

    //recebe o valor do orçamento
    var orcamento = $("#ValorRestanteOrca").val();
	var devolucao = $("#ValorFrete").val();
    var restaT = -(- devolucao.replace(".","").replace(",",".") - orcamento.replace(".","").replace(",","."));

    restaT = mascaraValorReal(restaT);

    //o valor é escrito no seu campo no formulário
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

function calculaRestaDespesas(entrada) {

    //recebe o valor da despesa
    var despesa = $("#ValorDespesas").val();
    var resta = (despesa.replace(".","").replace(",",".") - entrada.replace(".","").replace(",","."));

    resta = mascaraValorReal(resta);

    //o valor é escrito no seu campo no formulário
    $('#ValorRestanteDespesas').val(resta);

}

function calculaRestaConsumo(entrada) {

    //recebe o valor da despesa
    var despesa = $("#ValorConsumo").val();
    var resta = (despesa.replace(".","").replace(",",".") - entrada.replace(".","").replace(",","."));

    resta = mascaraValorReal(resta);

    //o valor é escrito no seu campo no formulário
    $('#ValorRestanteConsumo').val(resta);

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
function calculaParcelas() {
    //alert();
	//captura os valores dos campos indicados
    //var resta = $("#ValorRestanteOrca").val();
	var resta = $("#ValorTotalOrca").val();
    var parcelas = $("#QtdParcelasOrca").val();
    var vencimento = $("#DataVencimentoOrca").val();

    //valor de cada parcela
    var parcorca = (resta.replace(".","").replace(",",".") / parcelas);
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
							<div class="col-md-3">\
								<label for="ValorParcela">Valor Parcela:</label><br>\
								<div class="input-group" id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										    id="ValorParcela'+i+'" name="ValorParcela'+i+'" value="'+parcorca+'">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="DataVencimento">Data Venc. Parc.</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" id="DataVencimento'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataVencimento'+i+'" value="'+futureMonth.format('DD/MM/YYYY')+'">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="Quitado">Parc.Quitada?</label><br>\
								<div class="form-group">\
									<div class="btn-group" data-toggle="buttons">\
										<label class="btn btn-warning active" name="radio_Quitado'+i+'" id="radio_Quitado'+i+'N">\
										<input type="radio" name="Quitado'+i+'" id="radiogeraldinamico"\
											onchange="carregaQuitado(this.value,this.name,'+i+',1)" autocomplete="off" value="N" checked>Não\
										</label>\
										<label class="btn btn-default" name="radio_Quitado'+i+'" id="radio_Quitado'+i+'S">\
										<input type="radio" name="Quitado'+i+'" id="radiogeraldinamico"\
											onchange="carregaQuitado(this.value,this.name,'+i+',1)" autocomplete="off" value="S">Sim\
										</label>\
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
 * Função responsável por calcular as parcelas Mensais do orçamento em função do dados
 * informados no formulário (valor restante / parcelas e datas do vencimento)
 */  
function calculaParcelasMensais() {

    //captura os valores dos campos indicados
    //var resta = $("#ValorRestanteOrca").val();
	var resta = $("#ValorTotalOrca").val();
    var parcelas = $("#QtdParcelasOrca").val();
    var vencimento = $("#DataVencimentoOrca").val();

    //valor de cada parcela
    var parcorca = (resta.replace(".","").replace(",",".") / 1);
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
							<div class="col-md-3">\
								<label for="ValorParcela">Valor Parcela:</label><br>\
								<div class="input-group" id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										    id="ValorParcela'+i+'" name="ValorParcela'+i+'" value="'+parcorca+'">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="DataVencimento">Data Venc. Parc.</label>\
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
								<div class="form-group">\
									<div class="btn-group" data-toggle="buttons">\
										<label class="btn btn-warning active" name="radio_Quitado'+i+'" id="radio_Quitado'+i+'N">\
										<input type="radio" name="Quitado'+i+'" id="radiogeraldinamico"\
											onchange="carregaQuitado(this.value,this.name,'+i+',1)" autocomplete="off" value="N" checked>Não\
										</label>\
										<label class="btn btn-default" name="radio_Quitado'+i+'" id="radio_Quitado'+i+'S">\
										<input type="radio" name="Quitado'+i+'" id="radiogeraldinamico"\
											onchange="carregaQuitado(this.value,this.name,'+i+',1)" autocomplete="off" value="S">Sim\
										</label>\
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
 * Função responsável por calcular as parcelas PAGAVEIS do orçamento em função do dados
 * informados no formulário (valor restante / parcelas e datas do vencimento)
 */
function calculaParcelasPagaveis() {

    //captura os valores dos campos indicados
    var resta = $("#ValorRestanteDespesas").val();
    var parcelas = $("#QtdParcelasDespesas").val();
    var vencimento = $("#DataVencimentoDespesas").val();

    //valor de cada parcela
    var parcdesp = (resta.replace(".","").replace(",",".") / parcelas);
    parcdesp = mascaraValorReal(parcdesp);

    //pega a data do primeiro vencimento e separa em dia, mês e ano
    var split = vencimento.split("/");

    //define a data do primeiro vencimento no formato do momentjs
    var currentDate = moment(split[2]+'-'+split[1]+'-'+split[0]);

    //console.log(currentDate.format('DD-MM-YYYY'));
    //console.log(futureMonth.format('DD-MM-YYYY'));
    //alert('>>v '+vencimento+'::d1 '+currentDate.format('DD/MM/YYYY')+'::d2 '+futureMonth.format('DD/MM/YYYY')+'::d3 '+futureMonthEnd.format('DD/MM/YYYY')+'<<');

    //caso as parcelas já tenham sido geradas elas serão excluídas para que
    //sejam geradas novas parcelas
    $(".input_fields_parcelas2").empty();

    //gera os campos de parcelas
    for (i=1; i<=parcelas; i++) {

        //calcula as datas das próximas parcelas
        var futureMonth = moment(currentDate).add(i-1, 'M');
        var futureMonthEnd = moment(futureMonth).endOf('month');

        if(currentDate.date() != futureMonth.date() && futureMonth.isSame(futureMonthEnd.format('YYYY-MM-DD')))
            futureMonth = futureMonth.add(i-1, 'd');

        $(".input_fields_parcelas2").append('\
			<div class="form-group">\
				<div class="panel panel-warning">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-2">\
								<label for="ParcelaPagaveis">Parcela:</label><br>\
								<input type="text" class="form-control" maxlength="6" readonly=""\
									   name="ParcelaPagaveis'+i+'" value="'+i+'/'+parcelas+'">\
							</div>\
							<div class="col-md-3">\
								<label for="ValorParcelaPagaveis">Valor Parcela:</label><br>\
								<div class="input-group" id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										    id="ValorParcelaPagaveis'+i+'" name="ValorParcelaPagaveis'+i+'" value="'+parcdesp+'">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="DataVencimentoPagaveis">Data Venc. Parc.</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" id="DataVencimentoPagaveis'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataVencimentoPagaveis'+i+'" value="'+futureMonth.format('DD/MM/YYYY')+'">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="ValorPagoPagaveis">Valor Pago:</label><br>\
								<div class="input-group" id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										    id="ValorPagoPagaveis'+i+'" name="ValorPagoPagaveis'+i+'" value="">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="DataPagoPagaveis">Data Pag.</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" id="DataPagoPagaveis'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataPagoPagaveis'+i+'" value="">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="QuitadoPagaveis">Parc.Quitada?</label><br>\
								<div class="form-group">\
									<div class="btn-group" data-toggle="buttons">\
										<label class="btn btn-warning active" name="radio_QuitadoPagaveis'+i+'" id="radio_QuitadoPagaveis'+i+'N">\
										<input type="radio" name="QuitadoPagaveis'+i+'" id="radiogeraldinamico"\
											onchange="carregaQuitadoDespesas(this.value,this.name,'+i+',1)" autocomplete="off" value="N" checked>Não\
										</label>\
										<label class="btn btn-default" name="radio_QuitadoPagaveis'+i+'" id="radio_QuitadoPagaveis'+i+'S">\
										<input type="radio" name="QuitadoPagaveis'+i+'" id="radiogeraldinamico"\
											onchange="carregaQuitadoDespesas(this.value,this.name,'+i+',1)" autocomplete="off" value="S">Sim\
										</label>\
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
 * Função responsável por calcular as parcelas PAGAVEIS MENSAIS do orçamento em função do dados
 * informados no formulário (valor restante / parcelas e datas do vencimento)
 */
function calculaParcelasPagaveisMensais() {

    //captura os valores dos campos indicados
    var resta = $("#ValorRestanteDespesas").val();
    var parcelas = $("#QtdParcelasDespesas").val();
    var vencimento = $("#DataVencimentoDespesas").val();

    //valor de cada parcela
    var parcdesp = (resta.replace(".","").replace(",",".") / 1);
    parcdesp = mascaraValorReal(parcdesp);

    //pega a data do primeiro vencimento e separa em dia, mês e ano
    var split = vencimento.split("/");

    //define a data do primeiro vencimento no formato do momentjs
    var currentDate = moment(split[2]+'-'+split[1]+'-'+split[0]);

    //console.log(currentDate.format('DD-MM-YYYY'));
    //console.log(futureMonth.format('DD-MM-YYYY'));
    //alert('>>v '+vencimento+'::d1 '+currentDate.format('DD/MM/YYYY')+'::d2 '+futureMonth.format('DD/MM/YYYY')+'::d3 '+futureMonthEnd.format('DD/MM/YYYY')+'<<');

    //caso as parcelas já tenham sido geradas elas serão excluídas para que
    //sejam geradas novas parcelas
    $(".input_fields_parcelas2").empty();

    //gera os campos de parcelas
    for (i=1; i<=parcelas; i++) {

        //calcula as datas das próximas parcelas
        var futureMonth = moment(currentDate).add(i-1, 'M');
        var futureMonthEnd = moment(futureMonth).endOf('month');

        if(currentDate.date() != futureMonth.date() && futureMonth.isSame(futureMonthEnd.format('YYYY-MM-DD')))
            futureMonth = futureMonth.add(i-1, 'd');

        $(".input_fields_parcelas2").append('\
			<div class="form-group">\
				<div class="panel panel-warning">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-2">\
								<label for="ParcelaPagaveis">Parcela:</label><br>\
								<input type="text" class="form-control" maxlength="6" readonly=""\
									   name="ParcelaPagaveis'+i+'" value="'+i+'/'+parcelas+'">\
							</div>\
							<div class="col-md-3">\
								<label for="ValorParcelaPagaveis">Valor Parcela:</label><br>\
								<div class="input-group" id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										    id="ValorParcelaPagaveis'+i+'" name="ValorParcelaPagaveis'+i+'" value="'+parcdesp+'">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="DataVencimentoPagaveis">Data Venc. Parc.</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" id="DataVencimentoPagaveis'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataVencimentoPagaveis'+i+'" value="'+futureMonth.format('DD/MM/YYYY')+'">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="ValorPagoPagaveis">Valor Pago:</label><br>\
								<div class="input-group" id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										    id="ValorPagoPagaveis'+i+'" name="ValorPagoPagaveis'+i+'" value="">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="DataPagoPagaveis">Data Pag.</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" id="DataPagoPagaveis'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataPagoPagaveis'+i+'" value="">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="QuitadoPagaveis">Parc.Quitada?</label><br>\
								<div class="form-group">\
									<div class="btn-group" data-toggle="buttons">\
										<label class="btn btn-warning active" name="radio_QuitadoPagaveis'+i+'" id="radio_QuitadoPagaveis'+i+'N">\
										<input type="radio" name="QuitadoPagaveis'+i+'" id="radiogeraldinamico"\
											onchange="carregaQuitadoDespesas(this.value,this.name,'+i+',1)" autocomplete="off" value="N" checked>Não\
										</label>\
										<label class="btn btn-default" name="radio_QuitadoPagaveis'+i+'" id="radio_QuitadoPagaveis'+i+'S">\
										<input type="radio" name="QuitadoPagaveis'+i+'" id="radiogeraldinamico"\
											onchange="carregaQuitadoDespesas(this.value,this.name,'+i+',1)" autocomplete="off" value="S">Sim\
										</label>\
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
    var currentDate = moment();

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
    var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pc+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-4">\
							<label for="Procedimento'+pc+'">Procedimento:</label>\
							<textarea class="form-control" id="Procedimento'+pc+'"\
									  name="Procedimento'+pc+'"></textarea>\
						</div>\
						<div class="col-md-2">\
							<label for="Prioridade'+pc+'">Prioridade:</label>\
							<select data-placeholder="Selecione uma opção..." class="form-control"\
									 id="listadinamicac'+pc+'" name="Prioridade'+pc+'">\
								<option value="" checked>Alta</option>\
							</select>\
						</div>\
						<div class="col-md-3">\
							<label for="DataProcedimentoLimite'+pc+'">Limite:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataProcedimentoLimite'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-3">\
							<label for="DataProcedimento'+pc+'">Data do Proced.:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataProcedimento'+pc+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-9"></div>\
						<div class="col-md-2">\
							<label for="ConcluidoProcedimento">Proc. Concl.? </label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_ConcluidoProcedimento'+pc+'" id="radio_ConcluidoProcedimento'+pc+'N">\
									<input type="radio" name="ConcluidoProcedimento'+pc+'" id="radiogeraldinamico"\
										autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_ConcluidoProcedimento'+pc+'" id="radio_ConcluidoProcedimento'+pc+'S">\
									<input type="radio" name="ConcluidoProcedimento'+pc+'" id="radiogeraldinamico"\
										autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pc+'" class="remove_field3 btn btn-danger">\
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
 * Função responsável por adicionar novos campos de Procedtarefa dinamicamente no
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
    var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-3">\
							<label for="SubProcedimento'+pt+'">Ação:</label>\
							<textarea class="form-control" id="SubProcedimento'+pt+'"\
									  name="SubProcedimento'+pt+'"></textarea>\
						</div>\
						<div class="col-md-2">\
							<label for="Prioridade'+pt+'">Prioridade:</label>\
							<select data-placeholder="Selecione uma opção..." class="form-control"\
									 id="listadinamicad'+pt+'" name="Prioridade'+pt+'">\
								<option value="" checked>Baixa</option>\
							</select>\
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
							<label for="Statussubtarefa'+pt+'">Sts.SubTrf:</label>\
							<select data-placeholder="Selecione uma opção..." class="form-control"\
									 id="listadinamicae'+pt+'" name="Statussubtarefa'+pt+'">\
								<option value="" checked>Fazer</option>\
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
    var currentDate = moment();

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
    var currentDate = moment();

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

function adicionaValorDesconto() {

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
    var currentDate = moment();

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
							<label for="QtdProdutoIncremento">QtdInc:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento'+pt+'" placeholder="0"\
								    name="QtdProdutoIncremento'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-4">\
							<label for="idTab_Produtos">Item '+pt+':</label><br>\
							<select class="form-control Chosen" id="listadinamicad'+pt+'" name="idTab_Produtos'+pt+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto'+pt+'">Valor Venda S/Desc.</label><br>\
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
	
	/*
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=8',
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
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=15',
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

}

function adicionaValorConsultor() {

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
    var currentDate = moment();

    $(".input_fields_wrap13").append('\
        <div class="form-group" id="13div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
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
							<button type="button" id="'+pt+'" class="remove_field13 btn btn-danger">\
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

function adicionaValorServ() {

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
    var currentDate = moment();

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
						<div class="col-md-3">\
							<label for="ValorServico'+pt+'">Valor :</label><br>\
							<div class="input-group id="ValorServico'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorServico'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorServico'+pt+'" value="">\
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
    var currentDate = moment();

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
    var currentDate = moment();

    $(".input_fields_wrap32").append('\
        <div class="form-group" id="32div'+pt2+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-4">\
							<label for="Opcao'+pt2+'">Opcao '+pt2+'</label><br>\
							<div class="input-group id="Opcao'+pt2+'">\
								<input type="text" class="form-control" id="Opcao'+pt2+'" maxlength="44"\
									name="Opcao'+pt2+'" value="">\
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
    var currentDate = moment();

    $(".input_fields_wrap32").append('\
        <div class="form-group" id="32div'+pt2+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-10">\
							<label for="idTab_Opcao2">Opcao '+pt2+':</label><br>\
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
			$select.html('<option id="-1">ERRO</option>');
		}

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
    var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-5">\
							<label for="idTab_Produtos">Item '+pt+':</label><br>\
							<select class="form-control Chosen" id="listadinamicad'+pt+'" name="idTab_Produtos'+pt+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto'+pt+'" placeholder="0"\
								    name="QtdProdutoDesconto'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento">QtdInc:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento'+pt+'" placeholder="0"\
								    name="QtdProdutoIncremento'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto'+pt+'">Valor</label><br>\
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
    var currentDate = moment();

    $(".input_fields_wrap32").append('\
        <div class="form-group" id="32div'+pt2+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-5">\
							<label for="idTab_Produtos2">Item '+pt2+':</label><br>\
							<select class="form-control Chosen2" id="listadinamica2'+pt2+'" name="idTab_Produtos2'+pt2+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto2">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto2'+pt2+'" placeholder="0"\
								    name="QtdProdutoDesconto2'+pt2+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento2">QtdInc:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento2'+pt2+'" placeholder="0"\
								    name="QtdProdutoIncremento2'+pt2+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto2'+pt2+'">Valor</label><br>\
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
    var currentDate = moment();

    $(".input_fields_wrap33").append('\
        <div class="form-group" id="33div'+pt3+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-5">\
							<label for="idTab_Produtos3">Item '+pt3+':</label><br>\
							<select class="form-control Chosen3" id="listadinamica3'+pt3+'" name="idTab_Produtos3'+pt3+'">\
								<option value="">-- Selecione uma opção --</option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto3">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto3'+pt3+'" placeholder="0"\
								    name="QtdProdutoDesconto3'+pt3+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento3">QtdInc:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento3'+pt3+'" placeholder="0"\
								    name="QtdProdutoIncremento3'+pt3+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto3'+pt3+'">Valor</label><br>\
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

 function nomeProduto(id, tabela, campo, num) {
	 //alert('Funcionando'); 
	 
    $.ajax({
        // url para o arquivo json.php
			// "Posso passar assim:"
		//url: "../Nome_json.php?tabela=" + tabela + "&id_prod=" + id,
			// "ou, Posso passar assim:"
		url: window.location.origin + "/" + app + "/Nome_json.php?tabela=" + tabela + "&id_prod=" + id,
		//type: 'POST',
		dataType: 'html',
        //dataType: "json",		
		cache: false,
		data:{},

        // função para de sucesso
        success: function (data) {

			console.log(data);	

        }, error: function(jqXHR, textStatus, errorThrown){
			console.log('Erro');
		}
    });//termina o ajax
	
}

function nomeProduto_2(id, tabela, campo, num) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Nome_json.php?tabela=" + tabela + "&id_prod=" + id,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {
					console.log(data[i].nome);
                    //carrega o valor no campo de acordo com a opção selecionada
                    //$('#'+campo).val(data[i].valor);
					
					//""Posso usar assim, compondo o id passando o campo, pela variável, vindo do formulário""
					//$('#'+campo2+num).val(data[i].nome);
					
					//""ou posso usar assim, passando diretamente o nome do id ""
					//$('#NomeProduto'+num).val(data[i].nome);
					
					
					//$('#'+campo2+num).val(data[i].id);
					//var idproduto = data[i].id;
					//var nomeproduto = data[i].nome;
					//var nomecomposto1 = idproduto+'-'+nomeproduto;
					//var nomecomposto2 = idproduto+' '+nomeproduto;
					//var nomecomposto3 = idproduto+nomeproduto;
					//$('#NomeProduto'+num).val(nomeproduto);
					//$('#NomeProduto'+num).val(idproduto+'-'+nomeproduto);
					//$('#NomeProduto'+num).val(nomecomposto2);
					
					//""Exemplo de outro código, para me guiar""
					//var valor = $('#Valor'+item).html();
					//var Subtotal = (valor.replace(".","").replace(",",".") * qtd.replace(".","").replace(",","."));
					//var valorsubtotal = Subtotal.toFixed(2).replace(".", ",");
					//$('#Subtotal'+item).html(valorsubtotal);				

                }

            }//fim do laço

        }, error: function(jqXHR, textStatus, errorThrown){
			console.log('Erro');
		}
    });//termina o ajax
}
 
 function nomeProduto_BKP() {
	//alert('Funcionando'); 
	 
    $.ajax({
        // url para o arquivo json.php
        url: '../Nome_json.php',
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript

				console.log(data.id);
				
				
				/*
                if (data.id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    //$('#'+campo).val(data[i].valor);
					
					//""Posso usar assim, compondo o id passando o campo, pela variável, vindo do formulário""
					//$('#'+campo2+num).val(data[i].nome);
					
					//""ou posso usar assim, passando diretamente o nome do id ""
					//$('#NomeProduto'+num).val(data[i].nome);
					
					
					//$('#'+campo2+num).val(data[i].id);
					var idproduto = data.id;
					
					var nomeproduto = data.nome;
					
					var nomecomposto1 = idproduto+'-'+nomeproduto;
					var nomecomposto2 = idproduto+' '+nomeproduto;
					var nomecomposto3 = idproduto+nomeproduto;
					
					$('#Produtos').val(nomeproduto);
					
					//$('#NomeProduto'+num).val(nomeproduto);
					//$('#NomeProduto'+num).val(idproduto+'-'+nomeproduto);
					//$('#NomeProduto'+num).val(nomecomposto2);
					
					//""Exemplo de outro código, para me guiar""
					//var valor = $('#Valor'+item).html();
					//var Subtotal = (valor.replace(".","").replace(",",".") * qtd.replace(".","").replace(",","."));
					//var valorsubtotal = Subtotal.toFixed(2).replace(".", ",");
					//$('#Subtotal'+item).html(valorsubtotal);				


				}
				*/	
                    //para cada valor carregado o orçamento é calculado/atualizado
                    //através da chamada de sua função
                    //calculaOrcamento();
					
                    //break;
					
        }, error: function(jqXHR, textStatus, errorThrown){
			console.log('Erro');
		}
    });//termina o ajax
	
}
 
function buscaValor01(id, campo, tabela) {
	
    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor_json.php?tabela=" + tabela,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para ecessar os itens do objeto javaScript
            for ($i = 0; $i < data.length; $i++) {
                
                if (data[$i].id == id) {
                    
                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[$i].valor);
                    
                    //para cada valor carregado o orçamento é calculado/atualizado
                    //através da chamada de sua função
                    calculaOrcamento();
                    break;
                }                    
                
            }//fim do laço

        }
    });//termina o ajax
    

}

function buscaValor(id, campo, tabela, num, campo2) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor_json.php?tabela=" + tabela,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {
					console.log(data[i].nome);
                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);
					
					//""Posso usar assim, compondo o id passando o campo, pela variável, vindo do formulário""
					//$('#'+campo2+num).val(data[i].nome);
					
					//""ou posso usar assim, passando diretamente o nome do id ""
					//$('#NomeProduto'+num).val(data[i].nome);
					
					
					//$('#'+campo2+num).val(data[i].id);
					var idproduto = data[i].id;
					var nomeproduto = data[i].nome;
					var nomecomposto1 = idproduto+'-'+nomeproduto;
					var nomecomposto2 = idproduto+' '+nomeproduto;
					var nomecomposto3 = idproduto+nomeproduto;
					//$('#NomeProduto'+num).val(nomeproduto);
					//$('#NomeProduto'+num).val(idproduto+'-'+nomeproduto);
					$('#NomeProduto'+num).val(nomecomposto2);
					
					//""Exemplo de outro código, para me guiar""
					//var valor = $('#Valor'+item).html();
					//var Subtotal = (valor.replace(".","").replace(",",".") * qtd.replace(".","").replace(",","."));
					//var valorsubtotal = Subtotal.toFixed(2).replace(".", ",");
					//$('#Subtotal'+item).html(valorsubtotal);				

					
					
                    //if (tabela == area && $("#Qtd"+tabela+num).val()) {
                    if ($("#QtdProduto"+num).val()) {
                        calculaSubtotal($("#idTab_Produto"+num).val(),$("#QtdProduto"+num).val(),num,'OUTRO',tabela);
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

function buscaValor_BKP(id, campo, tabela, num) {
	
    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor_json.php?tabela=" + tabela,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#Qtd"+tabela+num).val()) {
                    if ($("#QtdProduto"+num).val()) {
                        calculaSubtotal($("#idTab_Produto"+num).val(),$("#QtdProduto"+num).val(),num,'OUTRO',tabela);
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

function buscaValorDev(id, campo, tabela, num) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor_json.php?tabela=" + tabela,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#Qtd"+tabela+num).val()) {
                    if ($("#QtdServico"+num).val()) {
                        calculaSubtotalDev($("#idTab_Servico"+num).val(),$("#QtdServico"+num).val(),num,'OUTRO',tabela);
                        break;
                    }

                    //para cada valor carregado o orçamento é calculado/atualizado
                    //através da chamada de sua função
                    calculaDevolucao();
                    break;
                }

            }//fim do laço

        }
    });//termina o ajax


}
 
function buscaValor1(id, campo, tabela, num, campo2) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor2_json.php?tabela=" + tabela,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#Qtd"+tabela+num).val()) {
                    if ($("#Qtd"+tabela+num).val()) {
                        calculaSubtotal($("#idTab_"+tabela+num).val(),$("#Qtd"+tabela+num).val(),num,'OUTRO',tabela);
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

function buscaValor2(id, campo, tabela, num, campo2) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor_json.php?tabela=" + tabela + "&campo2=" + campo2,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#Qtd"+tabela+num).val()) {
                    if ($("#Qtd"+campo2+num).val()) {
                        calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2);
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

                if (data[i].id == id) {
					
					//""ou posso usar assim, passando diretamente o qtdinc do id ""
					$('#QtdIncremento'+campo2+num).val(data[i].qtdinc);
					$('#idTab_Produtos_'+campo2+num).val(data[i].id_produto);
					$('#idTab_Valor_'+campo2+num).val(data[i].id_valor);
					//console.log( data[i].id_produto );
                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#Qtd"+tabela+num).val()) {
                    if ($("#Qtd"+campo2+num).val()) {
                        calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2,$("#QtdIncremento"+campo2+num).val());
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

                if (data[i].id == id) {
					
					//""ou posso usar assim, passando diretamente o qtdinc do id ""

					$('#idTab_Produtos_'+campo2+num).val(data[i].id_produto);
					//console.log( data[i].id_produto );
				
                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#Qtd"+tabela+num).val()) {
                    if ($("#Qtd"+campo2+num).val()) {
                        calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2);
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

function buscaValor2TabelasCli(id, campo, tabela, num, campo2) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor_json.php?tabela=" + tabela + "&campo2=" + campo2,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#Qtd"+tabela+num).val()) {
                    if ($("#Qtd"+campo2+num).val()) {
                        calculaSubtotalCli($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2);
                        break;
                    }

                    //para cada valor carregado o orçamento é calculado/atualizado
                    //através da chamada de sua função
                    calculaOrcamentoCli();
                    break;
                }

            }//fim do laço

        }
    });//termina o ajax


}

function buscaValorDevTabelas(id, campo, tabela, num, campo2) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor2_json.php?tabela=" + tabela + "&campo2=" + campo2,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#Qtd"+tabela+num).val()) {
                    if ($("#QtdServico"+num).val()) {
                        calculaSubtotalDev($("#idTab_Servico"+num).val(),$("#QtdServico"+num).val(),num,'OUTRO',campo2);
                        break;
                    }

                    //para cada valor carregado o orçamento é calculado/atualizado
                    //através da chamada de sua função
                    calculaDevolucao();
                    break;
                }

            }//fim do laço

        }
    });//termina o ajax


}

function buscaValorCompra(id, campo, tabela, num) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/ValorCompra_json.php?tabela=" + tabela,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#QtdCompra"+tabela+num).val()) {
                    if ($("#QtdCompra"+tabela+num).val()) {
                        calculaSubtotalCompra($("#idTab_"+tabela+num).val(),$("#QtdCompra"+tabela+num).val(),num,'OUTRO',tabela);
                        break;
                    }

                    //para cada valor carregado a despesa é calculado/atualizado
                    //através da chamada de sua função
                    calculaDespesas();
                    break;
                }

            }//fim do laço

        }
    });//termina o ajax


}

function buscaValorConsumo(id, campo, tabela, num) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/ValorConsumo_json.php?tabela=" + tabela,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[i].valor);

                    //if (tabela == area && $("#QtdCompra"+tabela+num).val()) {
                    if ($("#QtdConsumo"+tabela+num).val()) {
                        calculaSubtotalConsumo($("#idTab_"+tabela+num).val(),$("#QtdConsumo"+tabela+num).val(),num,'OUTRO',tabela);
                        break;
                    }

                    //para cada valor carregado a despesa é calculado/atualizado
                    //através da chamada de sua função
                    calculaConsumo();
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
function calculaSubtotal(valor, campo, num, tipo, tabela, qtdinc) {

    if (tipo == 'VP') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#Qtd"+tabela+num).val();
		var qtdprdinc = $("#QtdIncremento"+tabela+num).val();
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * data);
		var subtotalqtd = (qtdprdinc.replace(".","").replace(",",".") * data.replace(".","").replace(",","."));
        //alert('>>>'+valor+' :: '+campo+' :: '+num+' :: '+tipo+'<<<');
    } else if (tipo == 'QTD') {
        //variável quantidade recebe a quantidade do produto selecionado
        var data = $("#idTab_"+tabela+num).val();
		var qtdprdinc = $("#QtdIncremento"+tabela+num).val();
		var qtdprd = $("#Qtd"+tabela+num).val();
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor * data.replace(".","").replace(",","."));
		var subtotalqtd = (qtdprdinc.replace(".","").replace(",",".") * qtdprd.replace(".","").replace(",","."));
    } else {
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
		var subtotalqtd = (qtdinc.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
    }

    subtotal 	= mascaraValorReal(subtotal);
	subtotalqtd1 = subtotalqtd;
    //o subtotal é escrito no seu campo no formulário
    $('#Subtotal'+tabela+num).val(subtotal);
	$('#SubtotalQtd'+tabela+num).val(subtotalqtd1);

    //para cada vez que o subtotal for calculado o orçamento e o total restante
    //também serão atualizados
    calculaOrcamento();

}

function calculaSubtotalCli(valor, campo, num, tipo, tabela) {

    if (tipo == 'VP') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#Qtd"+tabela+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * data);
        //alert('>>>'+valor+' :: '+campo+' :: '+num+' :: '+tipo+'<<<');
    } else if (tipo == 'QTD') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#idTab_"+tabela+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor * data.replace(".","").replace(",","."));
    } else {
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
    }

    subtotal = mascaraValorReal(subtotal);
    //o subtotal é escrito no seu campo no formulário
    $('#Subtotal'+tabela+num).val(subtotal);

    //para cada vez que o subtotal for calculado o orçamento e o total restante
    //também serão atualizados
    calculaOrcamentoCli();

}

function calculaSubtotalDev(valor, campo, num, tipo, tabela) {

    if (tipo == 'VP') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#QtdServico"+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * data);
        //alert('>>>'+valor+' :: '+campo+' :: '+num+' :: '+tipo+'<<<');
    } else if (tipo == 'QTD') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#idTab_Servico"+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor * data.replace(".","").replace(",","."));
    } else {
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
    }

    subtotal = mascaraValorReal(subtotal);
    //o subtotal é escrito no seu campo no formulário
    $('#SubtotalServico'+num).val(subtotal);

    //para cada vez que o subtotal for calculado o orçamento e o total restante
    //também serão atualizados
    calculaDevolucao();

}

function calculaSubtotalCompra(valor, campo, num, tipo, tabela) {

    if (tipo == 'VP') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#QtdCompra"+tabela+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * data);
        //alert('>>>'+valor+' :: '+campo+' :: '+num+' :: '+tipo+'<<<');
    } else if (tipo == 'QTD') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#idTab_"+tabela+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor * data.replace(".","").replace(",","."));
    } else {
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
    }

    subtotal = mascaraValorReal(subtotal);
    //o subtotal é escrito no seu campo no formulário
    $('#Subtotal'+tabela+num).val(subtotal);

    //para cada vez que o subtotal for calculado o orçamento e o total restante
    //também serão atualizados
    calculaDespesas();

}

function calculaSubtotalConsumo(valor, campo, num, tipo, tabela) {

    if (tipo == 'VP') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#QtdConsumo"+tabela+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * data);
        //alert('>>>'+valor+' :: '+campo+' :: '+num+' :: '+tipo+'<<<');
    } else if (tipo == 'QTD') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#idTab_"+tabela+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor * data.replace(".","").replace(",","."));
    } else {
        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
    }

    subtotal = mascaraValorReal(subtotal);
    //o subtotal é escrito no seu campo no formulário
    $('#Subtotal'+tabela+num).val(subtotal);

    //para cada vez que o subtotal for calculado o orçamento e o total restante
    //também serão atualizados
    calculaConsumo();

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
	var subtotal = 0.00;
	var subtotalqtd = 0.00;

    //variável incrementadora
    var i = 0;
    //percorre todos os campos de serviço, somando seus valores
    while (i <= sc) {

        //soma os valores apenas dos campos que existirem, o que forem apagados
        //ou removidos são ignorados
        if ($('#SubtotalServico'+i).val())
            //subtotal += parseFloat($('#idTab_Servico'+i).val().replace(".","").replace(",","."));
            //subtotal -= parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));
			subtotalservico += parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));

        //incrementa a variável i
        i++;
    }

    //faz o mesmo que o laço anterior mas agora para produtos
    var i = 0;
    while (i <= pc) {

        if ($('#SubtotalProduto'+i).val()){
            subtotal += parseFloat($('#SubtotalProduto'+i).val().replace(".","").replace(",","."));
			subtotalqtd += parseFloat($('#SubtotalQtdProduto'+i).val().replace(".","").replace(",","."));
		}
		i++;
    }

    //calcula o subtotal, configurando para duas casas decimais e trocando o
    //ponto para o vírgula como separador de casas decimais
    subtotalservico = mascaraValorReal(subtotalservico);
	subtotal = mascaraValorReal(subtotal);
	subtotalqtd1 = subtotalqtd;
	//console.log(subtotalqtd1);
    //escreve o subtotal no campo do formulário
    $('#ValorDev').val(subtotalservico);
	$('#ValorOrca').val(subtotal);
	$('#QtdPrdOrca').val(subtotalqtd1);
    calculaResta($("#ValorEntradaOrca").val());
	calculaTotal($("#ValorEntradaOrca").val());
}

function calculaOrcamentoCli() {

    //captura o número incrementador do formulário, que controla quantos campos
    //foram acrescidos tanto para serviços quanto para produtos
    //var sc = parseFloat($('#SCount').val().replace(".","").replace(",","."));
    var pc = parseFloat($('#PCount').val().replace(".","").replace(",","."));
    //define o subtotal inicial em 0.00
    var subtotal = 0.00;
/*
    //variável incrementadora
    var i = 0;
    //percorre todos os campos de serviço, somando seus valores
    while (i <= sc) {

        //soma os valores apenas dos campos que existirem, o que forem apagados
        //ou removidos são ignorados
        if ($('#SubtotalServico'+i).val())
            //subtotal += parseFloat($('#idTab_Servico'+i).val().replace(".","").replace(",","."));
            subtotal -= parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));

        //incrementa a variável i
        i++;
    }
*/
    //faz o mesmo que o laço anterior mas agora para produtos
    var i = 0;
    while (i <= pc) {

        if ($('#SubtotalProduto'+i).val())
            subtotal += parseFloat($('#SubtotalProduto'+i).val().replace(".","").replace(",","."));

        i++;
    }

    //calcula o subtotal, configurando para duas casas decimais e trocando o
    //ponto para o vírgula como separador de casas decimais
    subtotal = mascaraValorReal(subtotal);

    //escreve o subtotal no campo do formulário
    $('#ValorRestanteOrca').val(subtotal);
    //calculaResta($("#ValorEntradaOrca").val());
}

function calculaDevolucao() {

    //captura o número incrementador do formulário, que controla quantos campos
    //foram acrescidos tanto para serviços quanto para produtos
    var sc = parseFloat($('#SCount').val().replace(".","").replace(",","."));
    //var pc = parseFloat($('#PCount').val().replace(".","").replace(",","."));
    //define o subtotal inicial em 0.00
    var subtotal = 0.00;

    //variável incrementadora
    var i = 0;
    //percorre todos os campos de serviço, somando seus valores
    while (i <= sc) {

        //soma os valores apenas dos campos que existirem, o que forem apagados
        //ou removidos são ignorados
        if ($('#SubtotalServico'+i).val())
            //subtotal += parseFloat($('#idTab_Servico'+i).val().replace(".","").replace(",","."));
            subtotal += parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));

        //incrementa a variável i
        i++;
    }
/*
    //faz o mesmo que o laço anterior mas agora para produtos
    var i = 0;
    while (i <= pc) {

        if ($('#SubtotalProduto'+i).val())
            subtotal += parseFloat($('#SubtotalProduto'+i).val().replace(".","").replace(",","."));

        i++;
    }
*/
    //calcula o subtotal, configurando para duas casas decimais e trocando o
    //ponto para o vírgula como separador de casas decimais
    subtotal = mascaraValorReal(subtotal);

    //escreve o subtotal no campo do formulário
    $('#ValorDev').val(subtotal);
    calculaResta();
}

function calculaDespesas() {

    //captura o número incrementador do formulário, que controla quantos campos
    //foram acrescidos tanto para serviços quanto para produtos
    var sc = parseFloat($('#SCount').val().replace(".","").replace(",","."));
    var pc = parseFloat($('#PCount').val().replace(".","").replace(",","."));
    //define o subtotal inicial em 0.00
    var subtotal = 0.00;

    //variável incrementadora
    var i = 0;
    //percorre todos os campos de serviço, somando seus valores
    while (i <= sc) {

        //soma os valores apenas dos campos que existirem, o que forem apagados
        //ou removidos são ignorados
        if ($('#SubtotalServico'+i).val())
            //subtotal += parseFloat($('#idTab_Servico'+i).val().replace(".","").replace(",","."));
            subtotal += parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));

        //incrementa a variável i
        i++;
    }

    //faz o mesmo que o laço anterior mas agora para produtos
    var i = 0;
    while (i <= pc) {

        if ($('#SubtotalProduto'+i).val())
            subtotal += parseFloat($('#SubtotalProduto'+i).val().replace(".","").replace(",","."));

        i++;
    }

    //calcula o subtotal, configurando para duas casas decimais e trocando o
    //ponto para o vírgula como separador de casas decimais
    subtotal = mascaraValorReal(subtotal);

    //escreve o subtotal no campo do formulário
    $('#ValorRestanteDespesas').val(subtotal);
    calculaRestaDespesas($("#ValorEntradaDespesas").val());
}

function calculaConsumo() {

    //captura o número incrementador do formulário, que controla quantos campos
    //foram acrescidos tanto para serviços quanto para produtos
    var sc = parseFloat($('#SCount').val().replace(".","").replace(",","."));
    var pc = parseFloat($('#PCount').val().replace(".","").replace(",","."));
    //define o subtotal inicial em 0.00
    var subtotal = 0.00;

    //variável incrementadora
    var i = 0;
    //percorre todos os campos de serviço, somando seus valores
    while (i <= sc) {

        //soma os valores apenas dos campos que existirem, o que forem apagados
        //ou removidos são ignorados
        if ($('#SubtotalServico'+i).val())
            //subtotal += parseFloat($('#idTab_Servico'+i).val().replace(".","").replace(",","."));
            subtotal += parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));

        //incrementa a variável i
        i++;
    }

    //faz o mesmo que o laço anterior mas agora para produtos
    var i = 0;
    while (i <= pc) {

        if ($('#SubtotalProduto'+i).val())
            subtotal += parseFloat($('#SubtotalProduto'+i).val().replace(".","").replace(",","."));

        i++;
    }

    //calcula o subtotal, configurando para duas casas decimais e trocando o
    //ponto para o vírgula como separador de casas decimais
    subtotal = mascaraValorReal(subtotal);

    //escreve o subtotal no campo do formulário
    $('#ValorConsumo').val(subtotal);
    calculaRestaConsumo($("#ValorEntradaConsumo").val());
}

/*
 * Função responsável por adicionar novos campos de serviço dinamicamente no
 * formulário de orçamento/tratametno
 */
function adicionaServico() {

    var ps = $("#SCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    ps++; //text box increment
    $("#SCount").val(ps);
    //console.log(ps);

    $(".input_fields_wrap").append('\
        <div class="form-group" id="1div'+ps+'">\
            <div class="panel panel-info">\
                <div class="panel-heading">\
                    <div class="row">\
						<div class="col-md-2">\
                            <label for="QtdServico">Qtd:</label><br>\
                            <div class="input-group">\
                                <input type="text" class="form-control Numero" maxlength="10" id="QtdServico'+ps+'" placeholder="0"\
                                    onkeyup="calculaSubtotal(this.value,this.name,'+ps+',\'QTD\',\'Servico\')"\
                                    name="QtdServico'+ps+'" value="">\
                            </div>\
                        </div>\
						<div class="col-md-4">\
                            <label for="idTab_Servico">Serviços:</label><br>\
                            <select class="form-control" id="listadinamica'+ps+'" onchange="buscaValor(this.value,this.name,\'Servico\','+ps+')" name="idTab_Servico'+ps+'">\
                                <option value="">-- Selecione uma opção --</option>\
                            </select>\
                        </div>\
                        <div class="col-md-3">\
                            <label for="ValorServico">Valor do Serviço:</label><br>\
                            <div class="input-group" id="txtHint">\
                                <span class="input-group-addon" id="basic-addon1">R$</span>\
                                <input type="text" class="form-control Valor" id="idTab_Servico'+ps+'" maxlength="10" placeholder="0,00" \
                                    onkeyup="calculaSubtotal(this.value,this.name,'+ps+',\'VP\',\'Servico\')"\
                                    name="ValorServico'+ps+'" value="">\
                            </div>\
                        </div>\
                        <div class="col-md-3">\
                            <label for="SubtotalServico">Subtotal:</label><br>\
                            <div class="input-group id="txtHint">\
                                <span class="input-group-addon" id="basic-addon1">R$</span>\
                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico'+ps+'"\
                                       name="SubtotalServico'+ps+'" value="">\
                            </div>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-6">\
                            <label for="ObsServico'+ps+'">Obs:</label><br>\
                            <input type="text" class="form-control" id="ObsServico'+ps+'" maxlength="250"\
                                   name="ObsServico'+ps+'" value="">\
                        </div>\
                        <div class="col-md-3">\
                            <label for="ConcluidoServico">Concluído? </label><br>\
                            <div class="form-group">\
                                <div class="btn-group" data-toggle="buttons">\
                                    <label class="btn btn-warning active" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'N">\
                                    <input type="radio" name="ConcluidoServico'+ps+'" id="radiogeraldinamico"\
                                        autocomplete="off" value="N" checked>Não\
                                    </label>\
                                    <label class="btn btn-default" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'S">\
                                    <input type="radio" name="ConcluidoServico'+ps+'" id="radiogeraldinamico"\
                                        autocomplete="off" value="S">Sim\
                                    </label>\
                                </div>\
                            </div>\
                        </div>\
						<div class="col-md-2">\
                            <label><br></label><br>\
                            <a href="#" id="'+ps+'" class="remove_field btn btn-danger">\
                                <span class="glyphicon glyphicon-trash"></span>\
                            </a>\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>'
    ); //add input box

    //get a reference to the select element
    $select = $('#listadinamica'+ps);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=1',
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
        },
        error: function () {
            //alert('erro listadinamicaA');
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

function adicionaServicoCompra() {

    var ps = $("#SCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    ps++; //text box increment
    $("#SCount").val(ps);
    //console.log(ps);

    $(".input_fields_wrap5").append('\
        <div class="form-group" id="5div'+ps+'">\
            <div class="panel panel-info">\
                <div class="panel-heading">\
                    <div class="row">\
						<div class="col-md-2">\
                            <label for="QtdCompraServico">Qtd:</label><br>\
                            <div class="input-group">\
                                <input type="text" class="form-control Numero" maxlength="10" id="QtdCompraServico'+ps+'" placeholder="0"\
                                    onkeyup="calculaSubtotalCompra(this.value,this.name,'+ps+',\'QTD\',\'Servico\')"\
                                    name="QtdCompraServico'+ps+'" value="">\
                            </div>\
                        </div>\
						<div class="col-md-4">\
                            <label for="idTab_Servico">Serviços:</label><br>\
                            <select class="form-control" id="listadinamica'+ps+'" onchange="buscaValorCompra(this.value,this.name,\'Servico\','+ps+')" name="idTab_Servico'+ps+'">\
                                <option value="">-- Selecione uma opção --</option>\
                            </select>\
                        </div>\
                        <div class="col-md-3">\
                            <label for="ValorCompraServico">Valor do Serviço:</label><br>\
                            <div class="input-group" id="txtHint">\
                                <span class="input-group-addon" id="basic-addon1">R$</span>\
                                <input type="text" class="form-control Valor" id="idTab_Servico'+ps+'" maxlength="10" placeholder="0,00" \
                                    onkeyup="calculaSubtotalCompra(this.value,this.name,'+ps+',\'VP\',\'Servico\')"\
                                    name="ValorCompraServico'+ps+'" value="">\
                            </div>\
                        </div>\
                        <div class="col-md-3">\
                            <label for="SubtotalServico">Subtotal:</label><br>\
                            <div class="input-group id="txtHint">\
                                <span class="input-group-addon" id="basic-addon1">R$</span>\
                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico'+ps+'"\
                                       name="SubtotalServico'+ps+'" value="">\
                            </div>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-8">\
                            <label for="ObsServico'+ps+'">Obs:</label><br>\
                            <input type="text" class="form-control" id="ObsServico'+ps+'" maxlength="250"\
                                   name="ObsServico'+ps+'" value="">\
                        </div>\
                        <div class="col-md-2">\
                            <label for="ConcluidoServico">Concluído? </label><br>\
                            <div class="form-group">\
                                <div class="btn-group" data-toggle="buttons">\
                                    <label class="btn btn-warning active" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'N">\
                                    <input type="radio" name="ConcluidoServico'+ps+'" id="radiogeraldinamico"\
                                        autocomplete="off" value="N" checked>Não\
                                    </label>\
                                    <label class="btn btn-default" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'S">\
                                    <input type="radio" name="ConcluidoServico'+ps+'" id="radiogeraldinamico"\
                                        autocomplete="off" value="S">Sim\
                                    </label>\
                                </div>\
                            </div>\
                        </div>\
						<div class="col-md-1">\
                            <label><br></label><br>\
                            <a href="#" id="'+ps+'" class="remove_field5 btn btn-danger">\
                                <span class="glyphicon glyphicon-trash"></span>\
                            </a>\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>'
    ); //add input box

    //get a reference to the select element
    $select = $('#listadinamica'+ps);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/GetvaluesCompra_json.php?q=1',
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
			},
        error: function () {
            //alert('erro listadinamicaA');
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

function adicionaParcelas() {

	var pc = $("#PRCount").val(); //initlal text box count
	pc++; //text box increment
	$("#PRCount").val(pc);

	if (pc >= 2) {
		//console.log( $("#listadinamicac"+(pc-1)).val() );
		var chosen2;
		chosen2 = $("#listadinamicac"+(pc-1)).val();
		//console.log( chosen + ' :: ' + pc );
	}	
	
    //Captura a data do dia e carrega no campo correspondente
    var currentDate = moment();
	
    $(".input_fields_wrap21").append('\
		<div class="form-group" id="21div'+pc+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-2">\
							<label for="Parcela">Parcela:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="Parcela'+pc+'" value="Ex.">\
						</div>\
						<div class="col-md-3">\
							<label for="ValorParcela">Valor:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorParcela'+pc+'" name="ValorParcela'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-3">\
							<label for="DataVencimento">Vencimento:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataVencimento'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataVencimento'+pc+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-3">\
							<label for="Quitado">Parc.Quitado?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_Quitado'+pc+'" id="radio_Quitado'+pc+'N">\
									<input type="radio" name="Quitado'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitado(this.value,this.name,'+pc+',1)" autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_Quitado'+pc+'" id="radio_Quitado'+pc+'S">\
									<input type="radio" name="Quitado'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitado(this.value,this.name,'+pc+',1)" autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<a href="#" id="'+pc+'" class="remove_field21 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</a>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>'
	); //add input box

	//get a reference to the select element
	$select2 = $('#listadinamicac'+pc);

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
	
	//habilita o botão de calendário após a geração dos campos dinâmicos
	$('.DatePicker').datetimepicker(dateTimePickerOptions);	
	
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
function adicionaParcelas-BKP() {
	
	var pc = $("#PRCount").val(); //initlal text box count
	pc++; //text box increment
	$("#PRCount").val(pc);

	if (pc >= 2) {
		//console.log( $("#listadinamicac"+(pc-1)).val() );
		var chosen2;
		chosen2 = $("#listadinamicac"+(pc-1)).val();
		//console.log( chosen + ' :: ' + pc );
	}	
	
    //Captura a data do dia e carrega no campo correspondente
    var currentDate = moment();
	
    $(".input_fields_wrap21").append('\
		<div class="form-group" id="21div'+pc+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-2">\
							<label for="Parcela">Parcela:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="Parcela'+pc+'" value="Ex.">\
						</div>\
						<div class="col-md-2">\
							<label for="ValorParcela">Valor:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorParcela'+pc+'" name="ValorParcela'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-3">\
							<label for="DataVencimento">Vencimento:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataVencimento'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataVencimento'+pc+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="Quitado">Parc.Quitado?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_Quitado'+pc+'" id="radio_Quitado'+pc+'N">\
									<input type="radio" name="Quitado'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitado(this.value,this.name,'+pc+',1)" autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_Quitado'+pc+'" id="radio_Quitado'+pc+'S">\
									<input type="radio" name="Quitado'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitado(this.value,this.name,'+pc+',1)" autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="idSis_Usuario'+pc+'">Profissional:</label>\
							<select data-placeholder="Selecione uma opção..." class="form-control"\
									 id="listadinamicac'+pc+'" name="idSis_Usuario'+pc+'">\
								<option value=""></option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<a href="#" id="'+pc+'" class="remove_field21 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</a>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>'
	); //add input box

	//get a reference to the select element
	$select2 = $('#listadinamicac'+pc);

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
	
	//habilita o botão de calendário após a geração dos campos dinâmicos
	$('.DatePicker').datetimepicker(dateTimePickerOptions);	
	
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
*/
function adicionaParcelasAlterar() {

	var pc = $("#PRCount").val(); //initlal text box count
	pc++; //text box increment
	$("#PRCount").val(pc);
	
    $(".input_fields_wrap24").append('\
		<div class="form-group" id="24div'+pc+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="idSis_Empresa">Empresa:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="idSis_Empresa'+pc+'" value="Ex.">\
						</div>\
						<div class="col-md-1">\
							<label for="idApp_OrcaTrata">Receita:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="idApp_OrcaTrata'+pc+'" value="Ex.">\
						</div>\
						<div class="col-md-1">\
							<label for="Parcela">Parcela:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="Parcela'+pc+'" value="Ex.">\
						</div>\
						<div class="col-md-2">\
							<label for="ValorParcela">Valor Parcela:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorParcela'+pc+'" name="ValorParcela'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataVencimento">Data Venc. Parc.</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataVencimento'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataVencimento'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorPago">Valor Pago:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorPago'+pc+'" name="ValorPago'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataPago">Data Pag.</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataPago'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataPago'+pc+'" value="">\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-8"></div>\
						<div class="col-md-2">\
							<label for="Quitado">Quitado????</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_Quitado'+pc+'" id="radio_Quitado'+pc+'N">\
									<input type="radio" name="Quitado'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitado(this.value,this.name,'+pc+',1)" autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_Quitado'+pc+'" id="radio_Quitado'+pc+'S">\
									<input type="radio" name="Quitado'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitado(this.value,this.name,'+pc+',1)" autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label><br></label><br>\
							<a href="#" id="'+pc+'" class="remove_field24 btn btn-danger">\
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
}

function adicionaParcelasPagaveis() {

	var pc = $("#PRCount").val(); //initlal text box count
	pc++; //text box increment
	$("#PRCount").val(pc);

	$(".input_fields_wrap22").append('\
		<div class="form-group" id="22div'+pc+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="ParcelaPagaveis">Parcela:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="ParcelaPagaveis'+pc+'" value="Ex.">\
						</div>\
						<div class="col-md-2">\
							<label for="ValorParcelaPagaveis">Valor Parcela:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorParcelaPagaveis'+pc+'" name="ValorParcelaPagaveis'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataVencimentoPagaveis">Data Venc. Parc.</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataVencimentoPagaveis'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataVencimentoPagaveis'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorPagoPagaveis">Valor Pago:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorPagoPagaveis'+pc+'" name="ValorPagoPagaveis'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataPagoPagaveis">Data Pag.</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataPagoPagaveis'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataPagoPagaveis'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="QuitadoPagaveis">Quitado????</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_QuitadoPagaveis'+pc+'" id="radio_QuitadoPagaveis'+pc+'N">\
									<input type="radio" name="QuitadoPagaveis'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitadoDespesas(this.value,this.name,'+pc+',1)" autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_QuitadoPagaveis'+pc+'" id="radio_QuitadoPagaveis'+pc+'S">\
									<input type="radio" name="QuitadoPagaveis'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitadoDespesas(this.value,this.name,'+pc+',1)" autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<a href="#" id="'+pc+'" class="remove_field22 btn btn-danger">\
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
}

function adicionaParcelasPagaveisAlterar() {

	var pc = $("#PRCount").val(); //initlal text box count
	pc++; //text box increment
	$("#PRCount").val(pc);

	$(".input_fields_wrap23").append('\
		<div class="form-group" id="23div'+pc+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="idSis_Empresa">Empresa:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="idSis_Empresa'+pc+'" value="Ex.">\
						</div>\
						<div class="col-md-1">\
							<label for="idApp_Despesas">Despesa:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="idApp_Despesas'+pc+'" value="Ex.">\
						</div>\
						<div class="col-md-1">\
							<label for="ParcelaPagaveis">Parcela:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="ParcelaPagaveis'+pc+'" value="Ex.">\
						</div>\
						<div class="col-md-2">\
							<label for="ValorParcelaPagaveis">Valor Parcela:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorParcelaPagaveis'+pc+'" name="ValorParcelaPagaveis'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataVencimentoPagaveis">Data Venc. Parc.</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataVencimentoPagaveis'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataVencimentoPagaveis'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorPagoPagaveis">Valor Pago:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorPagoPagaveis'+pc+'" name="ValorPagoPagaveis'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataPagoPagaveis">Data Pag.</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataPagoPagaveis'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataPagoPagaveis'+pc+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="QuitadoPagaveis">Quitado????</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_QuitadoPagaveis'+pc+'" id="radio_QuitadoPagaveis'+pc+'N">\
									<input type="radio" name="QuitadoPagaveis'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitadoDespesas(this.value,this.name,'+pc+',1)" autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_QuitadoPagaveis'+pc+'" id="radio_QuitadoPagaveis'+pc+'S">\
									<input type="radio" name="QuitadoPagaveis'+pc+'" id="radiogeraldinamico"\
										onchange="carregaQuitadoDespesas(this.value,this.name,'+pc+',1)" autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<a href="#" id="'+pc+'" class="remove_field23 btn btn-danger">\
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

	//adiciona campos dinamicamente Dos Produtos Devolvidos pelos CLIENTES
    var ps = $("#SCount").val(); //initlal text box count
	$(".add_field_button").click(function(e){ //on add input button click
        e.preventDefault();
    
		ps++; //text box increment
		$("#SCount").val(ps);
		
		$(".input_fields_wrap").append('\
			<div class="form-group" id="1div'+ps+'">\
				<div class="panel panel-danger">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-1">\
								<label for="QtdServico">Qtd:</label><br>\
								<div class="input-group">\
									<input type="text" class="form-control Numero" maxlength="10" id="QtdServico'+ps+'" placeholder="0"\
										onkeyup="calculaSubtotalDev(this.value,this.name,'+ps+',\'QTD\',\'Servico\'),calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')"\
										name="QtdServico'+ps+'" value="">\
								</div>\
							</div>\
							<div class="col-md-7">\
								<label for="idTab_Servico">Produto:</label><br>\
								<select class="form-control Chosen" id="listadinamica'+ps+'" onchange="buscaValor2Tabelas(this.value,this.name,\'Valor\','+ps+',\'Produto\')" name="idTab_Servico'+ps+'">\
									<option value="">-- Selecione uma opção --</option>\
								</select>\
							</div>\
							<div class="col-md-2">\
								<label for="ValorServico">Valor do Produto:</label><br>\
								<div class="input-group">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" id="idTab_Servico'+ps+'" maxlength="10" placeholder="0,00" \
										onkeyup="calculaSubtotalDev(this.value,this.name,'+ps+',\'VP\',\'Servico\')"\
										name="ValorServico'+ps+'" value="">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="SubtotalServico">Subtotal:</label><br>\
								<div class="input-group id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico'+ps+'"\
										   name="SubtotalServico'+ps+'" value="">\
								</div>\
							</div>\
						</div>\
						<div class="row">\
							<div class="col-md-1"></div>\
							<div class="col-md-7">\
								<label for="ObsServico'+ps+'">Obs:</label><br>\
								<input type="text" class="form-control" id="ObsServico'+ps+'" maxlength="250"\
									   name="ObsServico'+ps+'" value="">\
							</div>\
							<div class="col-md-2">\
								<label for="DataValidadeServico'+ps+'">Valid. do Prod:</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataValidadeServico'+ps+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
								</div>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+ps+'" class="remove_field btn btn-danger"\
									onclick="calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',1,'+ps+',\'CountMax2\',0,\'ServicoHidden\')">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>'
		); //add input box

		//get a reference to the select element
		$select = $('#listadinamica'+ps);

		//request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=2',
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
		
	});
	
    //adiciona campos dinamicamente dos Produtos Entregues aos CLIENTES
    var pc = $("#PCount").val(); //initlal text box count
    $(".add_field_button2").click(function(e){ //on add input button click
        e.preventDefault();

        pc++; //text box increment
        $("#PCount").val(pc);

        $(".input_fields_wrap2").append('\
            <div class="form-group" id="2div'+pc+'">\
                <div class="panel panel-success">\
                    <div class="panel-heading">\
                        <div class="row">\
                            <div class="col-md-1">\
                                <label for="QtdProduto">Qtd:</label><br>\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdProduto'+pc+'" placeholder="0"\
                                        onkeyup="calculaSubtotalCli(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
                                        name="QtdProduto'+pc+'" value="">\
                            </div>\
							<div class="col-md-3">\
                                <label for="idTab_Produto">Produto:</label><br>\
                                <select class="form-control Chosen" id="listadinamicab'+pc+'" onchange="buscaValor2TabelasCli(this.value,this.name,\'Valor\','+pc+',\'Produto\')" name="idTab_Produto'+pc+'">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
							<div class="col-md-3">\
								<label for="ObsProduto'+pc+'">Obs:</label><br>\
								<input type="text" class="form-control" id="ObsProduto'+pc+'" maxlength="250"\
									   name="ObsProduto'+pc+'" value="">\
							</div>\
                            <div class="col-md-2">\
                                <label for="ValorProduto">Valor do Produto:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
                                        onkeyup="calculaSubtotalCli(this.value,this.name,'+pc+',\'VP\',\'Produto\')"\
                                        name="ValorProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-2">\
                                <label for="SubtotalProduto">Subtotal:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto'+pc+'"\
                                           name="SubtotalProduto'+pc+'" value="">\
                                </div>\
                            </div>\
							<div class="col-md-1">\
                                <label><br></label><br>\
                                <a href="#" id="'+pc+'" class="remove_field2 btn btn-danger"\
                                        onclick="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',1,'+pc+',\'CountMax\',0,\'ProdutoHidden\')">\
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
        $select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=2',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                //$select.append('<option value="">-- Selecione uma opção --</option>');
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

    });

    //adiciona campos dinamicamente dos Produtos Entregues da Empresa 42
    $(".add_field_button42").click(function(e){ //on add input button click
        
		var negocio = $('#Negocio').val();
		//console.log( negocio );
		
		if (negocio == 1) {
			var endereco = 'q=90';
			var escrita = 'readonly=""';
			var buscavalor = 'buscaValor1Tabelas';
			var tblbusca = 'Valor';
		}
		if (negocio == 2) {
			var endereco = 'q=20';
			var escrita = '';
			var buscavalor = 'buscaValor2Tabelas';
			var tblbusca = 'Produtos';
		}
		
		var empresa = $('#Empresa').val();
		console.log( empresa );			
		/*
		//////// Coloquei esse código aqui, mas não sei se está fazendo diferença!!!/////
		if (pc >= 2) {
			//console.log( $("#listadinamicab"+(pc-1)).val() );
			var chosen;
			chosen = $("#listadinamicab"+(pc-1)).val();
			//console.log( chosen + ' :: ' + pc );
		}
		
		if (pc >= 2) {
			//console.log( $("#listadinamicac"+(pc-1)).val() );
			var chosen2;
			chosen2 = $("#listadinamicac"+(pc-1)).val();
			//console.log( chosen + ' :: ' + pc );
		}
		
		/////// Termina aqui!!! ////
		*/
		e.preventDefault();
		
        pc++; //text box increment
        $("#PCount").val(pc);

        $(".input_fields_wrap42").append('\
            <div class="form-group" id="42div'+pc+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
                        <div class="row">\
                            <div class="col-md-1">\
                                <label for="QtdProduto">Qtd.Item</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdProduto'+pc+'" placeholder="0"\
                                        onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeydown="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
                                       autofocus name="QtdProduto'+pc+'" value="1">\
                                </div>\
                            </div>\
                            <div class="col-md-1">\
                                <label for="QtdIncremento">Qtd.Emb</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdIncremento'+pc+'" '+ escrita +'\
                                       name="QtdIncremento'+pc+'" value="">\
                                </div>\
                            </div>\
							<input type="hidden" class="form-control" id="idTab_Valor'+pc+'" name="idTab_Valor'+pc+'" value="">\
							<input type="hidden" class="form-control" id="idTab_Produtos'+pc+'" name="idTab_Produtos'+pc+'" value="">\
							<div class="col-md-6">\
                                <label for="idTab_Produto">Produto:</label><br>\
                                <select class="form-control Chosen" id="listadinamicab'+pc+'" onchange="'+buscavalor+'(this.value,this.name,\''+tblbusca+'\','+pc+',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" name="idTab_Produto'+pc+'">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
							<div class="col-md-2">\
								<label for="ValorProduto">Valor:</label><br>\
								<div class="input-group id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
										onfocus="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'VP\',\'Produto\')"\
										name="ValorProduto'+pc+'" value="">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="SubtotalProduto">Subtotal:</label><br>\
								<div class="input-group id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto'+pc+'"\
										   name="SubtotalProduto'+pc+'" value="">\
								</div>\
							</div>\
						</div>\
						<div class="row">\
							<div class="col-md-2">\
								<div class="row">\
									<div class="col-md-12">\
										<label for="idSis_Usuario'+pc+'">Profissional:</label>\
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen2"\
												 id="listadinamicac'+pc+'" name="idSis_Usuario'+pc+'">\
											<option value=""></option>\
										</select>\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-12">\
										<label><br></label><br>\
										<a href="#" id="'+pc+'" class="remove_field42 btn btn-danger"\
												onclick="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',1,'+pc+',\'CountMax\',0,\'ProdutoHidden\')">\
											<span class="glyphicon glyphicon-trash"></span>\
										</a>\
									</div>\
								</div>\
							</div>\
							<div class="col-md-2">\
								<div class="row">\
									<div class="col-md-12">\
										<label for="Aux_App_Produto_5'+pc+'">Nome Rec.:</label>\
											<input type="text" class="form-control" maxlength="100"\
												   name="Aux_App_Produto_5'+pc+'" value="">\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-12">\
										<label for="Aux_App_Produto_2'+pc+'">CD:</label>\
											<input type="text" class="form-control" maxlength="100"\
												   name="Aux_App_Produto_2'+pc+'" value="">\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-12">\
										<label for="DataValidadeProduto'+pc+'">Validade:</label>\
										<div class="input-group DatePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-calendar"></span>\
											</span>\
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
												   name="DataValidadeProduto'+pc+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
										</div>\
									</div>\
								</div>\
							</div>\
							<div class="col-md-2">\
								<div class="row">\
									<div class="col-md-12">\
										<label for="Aux_App_Produto_1'+pc+'">Tel. Rec.:</label>\
											<input type="text" class="form-control Celular CelularVariavel" maxlength="11" placeholder="(XX)999999999"\
												   name="Aux_App_Produto_1'+pc+'" value="">\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-12">\
										<label for="Aux_App_Produto_3'+pc+'">Nº Mens.:</label>\
											<input type="text" class="form-control" maxlength="100"\
												   name="Aux_App_Produto_3'+pc+'" value="">\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-12">\
										<label for="HoraValidadeProduto'+pc+'">Hora Envio:</label>\
											<input type="text" class="form-control Time" maxlength="5"  placeholder="HH:MM"\
												   name="HoraValidadeProduto'+pc+'" value="">\
									</div>\
								</div>\
							</div>\
							<div class="col-md-2">\
								<div class="row">\
									<div class="col-md-12">\
										<label for="Aux_App_Produto_4'+pc+'">Parentesco:</label>\
											<input type="text" class="form-control" maxlength="200"\
												   name="Aux_App_Produto_4'+pc+'" value="">\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-12">\
										<label for="ObsProduto'+pc+'">Obs:</label><br>\
										<textarea type="text" class="form-control" id="ObsProduto'+pc+'" maxlength="250"\
											  onfocus="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" name="ObsProduto'+pc+'" value=""></textarea>\
									</div>\
								</div>\
							</div>\
							<div class="col-md-2">\
								<div class="row">\
									<div class="col-md-12 panel-body">\
										<div class="panel panel-primary">\
											<div class="panel-heading">\
												<div class="row">\
													<div class="col-md-12">\
														<label for="ConcluidoProduto">Entregue? </label><br>\
														<div class="btn-group" data-toggle="buttons">\
															<label class="btn btn-warning active" name="radio_ConcluidoProduto'+pc+'" id="radio_ConcluidoProduto'+pc+'N">\
															<input type="radio" name="ConcluidoProduto'+pc+'" id="radiogeraldinamico"\
																autocomplete="off" value="N" checked>Não\
															</label>\
															<label class="btn btn-default" name="radio_ConcluidoProduto'+pc+'" id="radio_ConcluidoProduto'+pc+'S">\
															<input type="radio" name="ConcluidoProduto'+pc+'" id="radiogeraldinamico"\
																autocomplete="off" value="S" >Sim\
															</label>\
														</div>\
													</div>\
												</div>\
											</div>\
										</div>\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-12 panel-body">\
										<div class="panel panel-danger">\
											<div class="panel-heading">\
												<div class="row">\
													<div class="col-md-12">\
														<label for="CanceladoProduto">Cancelado? </label><br>\
														<div class="btn-group" data-toggle="buttons">\
															<label class="btn btn-warning active" name="radio_CanceladoProduto'+pc+'" id="radio_CanceladoProduto'+pc+'N">\
															<input type="radio" name="CanceladoProduto'+pc+'" id="radiogeraldinamico"\
																autocomplete="off" value="N" checked>Não\
															</label>\
															<label class="btn btn-default" name="radio_CanceladoProduto'+pc+'" id="radio_CanceladoProduto'+pc+'S">\
															<input type="radio" name="CanceladoProduto'+pc+'" id="radiogeraldinamico"\
																autocomplete="off" value="S" >Sim\
															</label>\
														</div>\
													</div>\
												</div>\
											</div>\
										</div>\
									</div>\
								</div>\
							</div>\
							<div class="col-md-2 panel-body">\
								<div class="panel panel-success">\
									<div class="panel-heading">\
										<div class="row">\
											<div class="col-md-12">\
												<label for="DevolvidoProduto">Devolvido? </label><br>\
												<div class="btn-group" data-toggle="buttons">\
													<label class="btn btn-warning active" name="radio_DevolvidoProduto'+pc+'" id="radio_DevolvidoProduto'+pc+'N">\
													<input type="radio" name="DevolvidoProduto'+pc+'" id="radiogeraldinamico"\
														autocomplete="off" value="N" checked>Não\
													</label>\
													<label class="btn btn-default" name="radio_DevolvidoProduto'+pc+'" id="radio_DevolvidoProduto'+pc+'S">\
													<input type="radio" name="DevolvidoProduto'+pc+'" id="radiogeraldinamico"\
														autocomplete="off" value="S" >Sim\
													</label>\
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
        $select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?' + endereco,
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
        $select2 = $('#listadinamicac'+pc);

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
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });
	
    //adiciona campos dinamicamente dos Produtos Vendidos 
	var pc = $("#PCount").val(); //initlal text box count
	$(".add_field_button9").click(function(e){ //on add input button click
        
		var negocio = $('#Negocio').val();
		//console.log( negocio );
		
		if (negocio == 1) {
			var endereco = 'q=90';
			var escrita = 'readonly=""';
			var buscavalor = 'buscaValor1Tabelas';
			var tblbusca = 'Valor';
		}
		if (negocio == 2) {
			var endereco = 'q=20';
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

        $(".input_fields_wrap9").append('\
            <div class="form-group" id="9div'+pc+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
                        <div class="row">\
							<input type="hidden" class="form-control" id="idTab_Valor_Produto'+pc+'" name="idTab_Valor_Produto'+pc+'" value="">\
							<input type="hidden" class="form-control" id="idTab_Produtos_Produto'+pc+'" name="idTab_Produtos_Produto'+pc+'" value="">\
							<div class="col-md-11">\
                                <label for="idTab_Produto">Produto '+pc+':</label><br>\
                                <select class="form-control Chosen" id="listadinamicab'+pc+'" name="idTab_Produto'+pc+'" onchange="'+buscavalor+'(this.value,this.name,\''+tblbusca+'\','+pc+',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
							<div class="col-md-1 text-right">\
								<label><br></label><br>\
								<a href="#" id="'+pc+'" class="remove_field9 btn btn-danger"\
										onclick="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',1,'+pc+',\'CountMax\',0,\'ProdutoHidden\')">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
                        </div>\
						<div class="row">\
							<div class="col-md-2">\
                                <label for="QtdProduto">Qtd.Item</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdProduto'+pc+'" placeholder="0"\
                                        onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeydown="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
                                       autofocus name="QtdProduto'+pc+'" value="1">\
                                </div>\
                            </div>\
							<div class="col-md-2">\
                                <label for="QtdIncrementoProduto">Qtd.na Embl</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdIncrementoProduto'+pc+'" '+ escrita +'\
                                       name="QtdIncrementoProduto'+pc+'" value="1">\
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
							<div class="col-md-2">\
								<label for="SubtotalQtdProduto">Sub.Qtd.Prod</label><br>\
								<div class="input-group id="txtHint">\
									<input type="text" class="form-control Numero text-right" maxlength="10" readonly="" id="SubtotalQtdProduto'+pc+'"\
										   name="SubtotalQtdProduto'+pc+'" value="">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="SubtotalProduto">Sub.Valor.Prod</label><br>\
								<div class="input-group id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto'+pc+'"\
										   name="SubtotalProduto'+pc+'" value="">\
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
        $select = $('#listadinamicab'+pc);
		
        //request the JSON data and parse into the select element
        $.ajax({
			
			//url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=90',
			url: window.location.origin+ '/' + app + '/Getvalues_json.php?' + endereco,
			
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
        $select2 = $('#listadinamicac'+pc);

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
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });

/*	
    //adiciona campos dinamicamente dos Produtos Vendidos 
	var pc = $("#PCount").val(); //initlal text box count
	$(".add_field_button9_BKP").click(function(e){ //on add input button click
        
		var negocio = $('#Negocio').val();
		//console.log( negocio );
		
		if (negocio == 1) {
			var endereco = 'q=90';
			var escrita = 'readonly=""';
			var buscavalor = 'buscaValor1Tabelas';
			var tblbusca = 'Valor';
		}
		if (negocio == 2) {
			var endereco = 'q=20';
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
		//termina aqui
		//////// Coloquei esse código aqui, mas não sei se está fazendo diferença!!!/////
		
		if (pc >= 2) {
			//console.log( $("#listadinamicab"+(pc-1)).val() );
			var chosen;
			chosen = $("#listadinamicab"+(pc-1)).val();
			//console.log( chosen + ' :: ' + pc );
			//var chosen2;
			//chosen2 = $("#listadinamicac"+(pc-1)).val();		
		
		}
		
		/////// Termina aqui!!! ////
		
		e.preventDefault();
		
        pc++; //text box increment
        $("#PCount").val(pc);

        $(".input_fields_wrap9").append('\
            <div class="form-group" id="9div'+pc+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
                        <div class="row">\
							<input type="hidden" class="form-control" id="idTab_Valor'+pc+'" name="idTab_Valor'+pc+'" value="">\
							<input type="hidden" class="form-control" id="idTab_Produtos'+pc+'" name="idTab_Produtos'+pc+'" value="">\
							<div class="col-md-11">\
                                <label for="idTab_Produto">Produto '+pc+':</label><br>\
                                <select class="form-control Chosen" id="listadinamicab'+pc+'" name="idTab_Produto'+pc+'" onchange="'+buscavalor+'(this.value,this.name,\''+tblbusca+'\','+pc+',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+pc+'" class="remove_field9 btn btn-danger"\
										onclick="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',1,'+pc+',\'CountMax\',0,\'ProdutoHidden\')">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
                        </div>\
						<div class="row">\
							<div class="col-md-2">\
                                <label for="QtdProduto">Qtd.Item</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdProduto'+pc+'" placeholder="0"\
                                        onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeydown="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
                                       autofocus name="QtdProduto'+pc+'" value="1">\
                                </div>\
                            </div>\
							<div class="col-md-2">\
                                <label for="QtdIncremento">Qtd.Emb.</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdIncremento'+pc+'" '+ escrita +'\
                                       name="QtdIncremento'+pc+'" value="1">\
                                </div>\
                            </div>\
							<div class="col-md-3">\
								<label for="ValorProduto">Valor.Emb.:</label><br>\
								<div class="input-group id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
										onfocus="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'VP\',\'Produto\')"\
										name="ValorProduto'+pc+'" value="">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="SubtotalProduto">Subtotal:</label><br>\
								<div class="input-group id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto'+pc+'"\
										   name="SubtotalProduto'+pc+'" value="">\
								</div>\
							</div>\
						</div>\
						<div class="row">\
							<div class="col-md-3">\
								<label for="idSis_Usuario'+pc+'">Profissional:</label>\
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen2"\
										 id="listadinamicac'+pc+'" name="idSis_Usuario'+pc+'">\
									<option value=""></option>\
								</select>\
							</div>\
							<div class="col-md-3">\
								<label for="DataValidadeProduto'+pc+'">Validade:</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataValidadeProduto'+pc+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="ConcluidoProduto">Entregue? </label><br>\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_ConcluidoProduto'+pc+'" id="radio_ConcluidoProduto'+pc+'N">\
									<input type="radio" name="ConcluidoProduto'+pc+'" id="radiogeraldinamico"\
										autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_ConcluidoProduto'+pc+'" id="radio_ConcluidoProduto'+pc+'S">\
									<input type="radio" name="ConcluidoProduto'+pc+'" id="radiogeraldinamico"\
										autocomplete="off" value="S" >Sim\
									</label>\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="DevolvidoProduto">Devolvido? </label><br>\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_DevolvidoProduto'+pc+'" id="radio_DevolvidoProduto'+pc+'N">\
									<input type="radio" name="DevolvidoProduto'+pc+'" id="radiogeraldinamico"\
										autocomplete="off" value="N" checked>Não\
									</label>\
									<label class="btn btn-default" name="radio_DevolvidoProduto'+pc+'" id="radio_DevolvidoProduto'+pc+'S">\
									<input type="radio" name="DevolvidoProduto'+pc+'" id="radiogeraldinamico"\
										autocomplete="off" value="S" >Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="row">\
							<div class="col-md-3">\
								<label for="ObsProduto'+pc+'">Obs:</label><br>\
								<textarea type="text" class="form-control" id="ObsProduto'+pc+'" maxlength="250"\
									  onfocus="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" name="ObsProduto'+pc+'" value=""></textarea>\
							</div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//habilita o botão de calendário após a geração dos campos dinâmicos
		$('.DatePicker').datetimepicker(dateTimePickerOptions);
		
		//get a reference to the select element
        $select = $('#listadinamicab'+pc);
		
        //request the JSON data and parse into the select element
        $.ajax({
			
			//url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=90',
			url: window.location.origin+ '/' + app + '/Getvalues_json.php?' + endereco,
			
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
        $select2 = $('#listadinamicac'+pc);

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
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });
	
*/	
	
	//adiciona campos dinamicamente dos Serviços 
    var ps = $("#SCount").val(); //initlal text box count
	$(".add_field_button10").click(function(e){ //on add input button click
        
		var negocio = $('#Negocio').val();
		//console.log( negocio );
		
		if (negocio == 1) {
			var endereco_serv = 'q=902';
			var escrita_serv = 'readonly=""';
			var buscavalor_serv = 'buscaValor1Tabelas';
			var tblbusca_serv = 'Valor';
		}
		if (negocio == 2) {
			var endereco_serv = 'q=202';
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
							<input type="hidden" class="form-control" id="idTab_Valor_Servico'+ps+'" name="idTab_Valor_Servico'+ps+'" value="">\
							<input type="hidden" class="form-control" id="idTab_Produtos_Servico'+ps+'" name="idTab_Produtos_Servico'+ps+'" value="">\
							<div class="col-md-11">\
								<label for="idTab_Servico">Servico '+ps+':</label><br>\
								<select class="form-control Chosen4" id="listadinamica'+ps+'"  name="idTab_Servico'+ps+'" onchange="'+buscavalor_serv+'(this.value,this.name,\''+tblbusca_serv+'\','+ps+',\'Servico\'),calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')">\
									<option value="">-- Selecione uma opção --</option>\
								</select>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+ps+'" class="remove_field10 btn btn-danger"\
									onclick="calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',1,'+ps+',\'CountMax2\',0,\'ServicoHidden\')">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
						<div class="row">\
							<div class="col-md-2">\
								<label for="QtdServico">Qtd</label><br>\
								<div class="input-group">\
									<input type="text" class="form-control Numero" maxlength="10" id="QtdServico'+ps+'" placeholder="0"\
										onkeyup="calculaSubtotal(this.value,this.name,'+ps+',\'QTD\',\'Servico\'),calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')"\
										name="QtdServico'+ps+'" value="1">\
								</div>\
							</div>\
							<input type="hidden" class="form-control Numero" id="QtdIncrementoServico'+ps+'" name="QtdIncrementoServico'+ps+'" value="">\
							<div class="col-md-3">\
								<label for="ValorServico">Valor do Serviço</label><br>\
								<div class="input-group">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" id="idTab_Servico'+ps+'" maxlength="10" placeholder="0,00" \
										onkeyup="calculaSubtotal(this.value,this.name,'+ps+',\'VP\',\'Servico\')" onchange="calculaSubtotal(this.value,this.name,'+ps+',\'VP\',\'Servico\')"\
										name="ValorServico'+ps+'" value="">\
								</div>\
							</div>\
							<div class="col-md-4">\
								<label for="ProfissionalServico'+ps+'">Profissional:</label>\
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen2"\
										 id="listadinamica_prof'+ps+'" name="ProfissionalServico'+ps+'">\
									<option value=""></option>\
								</select>\
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
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?' + endereco_serv,
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
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});
		
	});

/*	
	//adiciona campos dinamicamente dos Serviços 
    var ps = $("#SCount").val(); //initlal text box count
	$(".add_field_button10_BKP").click(function(e){ //on add input button click
        e.preventDefault();
    
		ps++; //text box increment
		$("#SCount").val(ps);
		
		$(".input_fields_wrap10").append('\
			<div class="form-group" id="10div'+ps+'">\
				<div class="panel panel-danger">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-12">\
								<label for="idTab_Servico">Servico'+ps+':</label><br>\
								<select class="form-control Chosen" id="listadinamica'+ps+'" onchange="buscaValorDevTabelas(this.value,this.name,\'Valor\','+ps+',\'Produto\')" name="idTab_Servico'+ps+'">\
									<option value="">-- Selecione uma opção --</option>\
								</select>\
							</div>\
						</div>\
						<div class="row">\
							<div class="col-md-2">\
								<label for="QtdServico">Qtd:</label><br>\
								<div class="input-group">\
									<input type="text" class="form-control Numero" maxlength="10" id="QtdServico'+ps+'" placeholder="0"\
										onkeyup="calculaSubtotalDev(this.value,this.name,'+ps+',\'QTD\',\'Servico\'),calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')"\
										name="QtdServico'+ps+'" value="1">\
								</div>\
							</div>\
							<div class="col-md-3"></div>\
							<div class="col-md-3">\
								<label for="ValorServico">Valor:</label><br>\
								<div class="input-group">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" id="idTab_Servico'+ps+'" maxlength="10" placeholder="0,00" \
										onkeyup="calculaSubtotalDev(this.value,this.name,'+ps+',\'VP\',\'Servico\')"\
										name="ValorServico'+ps+'" value="">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="SubtotalServico">Subtotal:</label><br>\
								<div class="input-group id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico'+ps+'"\
										   name="SubtotalServico'+ps+'" value="">\
								</div>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+ps+'" class="remove_field10 btn btn-danger"\
									onclick="calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',1,'+ps+',\'CountMax2\',0,\'ServicoHidden\')">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
						<div class="row">\
							<div class="col-md-2"></div>\
							<div class="col-md-3">\
								<label for="ObsServico'+ps+'">Obs:</label><br>\
								<input type="text" class="form-control" id="ObsServico'+ps+'" maxlength="250"\
									   name="ObsServico'+ps+'" value="">\
							</div>\
							<div class="col-md-3">\
								<label for="DataValidadeServico'+ps+'">Validade:</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataValidadeServico'+ps+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="ConcluidoServico">Prd.Ent? </label><br>\
								<div class="form-group">\
									<div class="btn-group" data-toggle="buttons">\
										<label class="btn btn-warning active" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'N">\
										<input type="radio" name="ConcluidoServico'+ps+'" id="radiogeraldinamico"\
											autocomplete="off" value="N" checked>Não\
										</label>\
										<label class="btn btn-default" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'S">\
										<input type="radio" name="ConcluidoServico'+ps+'" id="radiogeraldinamico"\
											autocomplete="off" value="S" >Sim\
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
		
		//get a reference to the select element
		$select = $('#listadinamica'+ps);

		//request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=9',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                //$select.append('<option value="">-- Selecione uma opção --</option>');
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
*/
	
    //adiciona campos dinamicamente dos Produtos Comprados 
    var pc = $("#PCount").val(); //initlal text box count
    $(".add_field_button11").click(function(e){ //on add input button click
        e.preventDefault();

        pc++; //text box increment
        $("#PCount").val(pc);

        $(".input_fields_wrap11").append('\
            <div class="form-group" id="11div'+pc+'">\
                <div class="panel panel-success">\
                    <div class="panel-heading">\
                        <div class="row">\
                            <div class="col-md-2">\
                                <label for="QtdProduto">Qtd:</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdProduto'+pc+'" placeholder="0"\
                                        onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
                                        name="QtdProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-4">\
                                <label for="idTab_Produto">Produto:</label><br>\
                                <select class="form-control Chosen" id="listadinamicab'+pc+'" onchange="buscaValor(this.value,this.name,\'Produto\','+pc+')" name="idTab_Produto'+pc+'">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
                            <div class="col-md-3">\
                                <label for="ValorProduto">Valor:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
                                        onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'VP\',\'Produto\')"\
                                        name="ValorProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-3">\
                                <label for="SubtotalProduto">Subtotal:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto'+pc+'"\
                                           name="SubtotalProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                        </div>\
						<div class="row">\
							<div class="col-md-6"></div>\
							<div class="col-md-3">\
								<label for="ObsProduto'+pc+'">Obs:</label><br>\
								<input type="text" class="form-control" id="ObsProduto'+pc+'" maxlength="250"\
									   name="ObsProduto'+pc+'" value="">\
							</div>\
							<div class="col-md-2">\
								<label for="DataValidadeProduto'+pc+'">Validade:</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataValidadeProduto'+pc+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
								</div>\
							</div>\
							<div class="col-md-1">\
                                <label><br></label><br>\
                                <a href="#" id="'+pc+'" class="remove_field11 btn btn-danger"\
                                        onclick="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',1,'+pc+',\'CountMax\',0,\'ProdutoHidden\')">\
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
        $select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=2',
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

    });

	//adiciona campos dinamicamente dos Produtos Devolvidos (Comprados)
    var ps = $("#SCount").val(); //initlal text box count
	$(".add_field_button12").click(function(e){ //on add input button click
        e.preventDefault();
    
		ps++; //text box increment
		$("#SCount").val(ps);
		
		$(".input_fields_wrap12").append('\
			<div class="form-group" id="12div'+ps+'">\
				<div class="panel panel-warning">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-1">\
								<label for="QtdServico">Qtd:</label><br>\
								<div class="input-group">\
									<input type="text" class="form-control Numero" maxlength="10" id="QtdServico'+ps+'" placeholder="0"\
										onkeyup="calculaSubtotalDev(this.value,this.name,'+ps+',\'QTD\',\'Produto\'),calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')"\
										name="QtdServico'+ps+'" value="">\
								</div>\
							</div>\
							<div class="col-md-3">\
								<label for="idTab_Servico">Produto:</label><br>\
								<select class="form-control Chosen" id="listadinamica'+ps+'" onchange="buscaValorDev(this.value,this.name,\'Produto\','+ps+')" name="idTab_Servico'+ps+'">\
									<option value="">-- Selecione uma opção --</option>\
								</select>\
							</div>\
							<div class="col-md-3">\
								<label for="ObsServico'+ps+'">Obs:</label><br>\
								<input type="text" class="form-control" id="ObsServico'+ps+'" maxlength="250"\
									   name="ObsServico'+ps+'" value="">\
							</div>\
							<div class="col-md-2">\
								<label for="ValorServico">Valor:</label><br>\
								<div class="input-group">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" id="idTab_Servico'+ps+'" maxlength="10" placeholder="0,00" \
										onkeyup="calculaSubtotalDev(this.value,this.name,'+ps+',\'VP\',\'Produto\')"\
										name="ValorServico'+ps+'" value="">\
								</div>\
							</div>\
							<div class="col-md-2">\
								<label for="SubtotalServico">Subtotal:</label><br>\
								<div class="input-group id="txtHint">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico'+ps+'"\
										   name="SubtotalServico'+ps+'" value="">\
								</div>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+ps+'" class="remove_field12 btn btn-danger"\
									onclick="calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',1,'+ps+',\'CountMax2\',0,\'ServicoHidden\')">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
						<div class="row">\
							<div class="col-md-9"></div>\
							<div class="col-md-2">\
								<label for="DataValidadeServico'+ps+'">Validade:</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataValidadeServico'+ps+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
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
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=2',
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
		
	});
		
    //adiciona campos dinamicamente
    var pc = $("#PCount").val(); //initlal text box count
    $(".add_field_button8").click(function(e){ //on add input button click
        e.preventDefault();

        pc++; //text box increment
        $("#PCount").val(pc);

        $(".input_fields_wrap8").append('\
            <div class="form-group" id="8div'+pc+'">\
                <div class="panel panel-info">\
                    <div class="panel-heading">\
                        <div class="row">\
                            <div class="col-md-1">\
                                <label for="QtdProduto">Qtd:</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdProduto'+pc+'" placeholder="0"\
                                        onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\')"\
                                        name="QtdProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-7">\
                                <label for="idTab_Produto">Produto:</label><br>\
                                <select class="form-control Chosen" id="listadinamicab'+pc+'" onchange="buscaValor2Tabelas(this.value,this.name,\'Valor\','+pc+',\'Produto\')" name="idTab_Produto'+pc+'">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
                            <div class="col-md-2">\
                                <label for="ValorProduto">Valor do Produto:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
                                        onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'VP\',\'Produto\')"\
                                        name="ValorProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-2">\
                                <label for="SubtotalProduto">Subtotal:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto'+pc+'"\
                                           name="SubtotalProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                        </div>\
						<div class="row">\
							<div class="col-md-1"></div>\
							<div class="col-md-7">\
								<label for="ObsProduto'+pc+'">Obs:</label><br>\
								<input type="text" class="form-control" id="ObsProduto'+pc+'" maxlength="250"\
									   name="ObsProduto'+pc+'" value="">\
							</div>\
							<div class="col-md-2">\
								<label for="DataValidadeProduto'+pc+'">Val. do Produto:</label>\
								<div class="input-group DatePicker">\
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataValidadeProduto'+pc+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
								</div>\
							</div>\
							<div class="col-md-1">\
                                <label><br></label><br>\
                                <a href="#" id="'+pc+'" class="remove_field8 btn btn-danger">\
                                    <span class="glyphicon glyphicon-trash"></span>\
                                </a>\
                            </div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

        //get a reference to the select element
        $select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=8',
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

    });	

	//adiciona campos dinamicamente
    var pc = $("#PCount").val(); //initlal text box count
    $(".add_field_button4").click(function(e){ //on add input button click
        e.preventDefault();

        pc++; //text box increment
        $("#PCount").val(pc);

		$(".input_fields_wrap4").append('\
            <div class="form-group" id="4div'+pc+'">\
                <div class="panel panel-info">\
                    <div class="panel-heading">\
                        <div class="row">\
                            <div class="col-md-1">\
                                <label for="QtdCompraProduto">Qtd:</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdCompraProduto'+pc+'" placeholder="0"\
                                        onkeyup="calculaSubtotalCompra(this.value,this.name,'+pc+',\'QTD\',\'Produto\')"\
                                        name="QtdCompraProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-7">\
                                <label for="idTab_Produto">Produto:</label><br>\
                                <select class="form-control Chosen" id="listadinamicab'+pc+'" onchange="buscaValorCompra(this.value,this.name,\'Produto\','+pc+')" name="idTab_Produto'+pc+'">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
                            <div class="col-md-2">\
                                <label for="ValorCompraProduto">Valor do Produto:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
                                        onkeyup="calculaSubtotalCompra(this.value,this.name,'+pc+',\'VP\',\'Produto\')"\
                                        name="ValorCompraProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-2">\
                                <label for="SubtotalProduto">Subtotal:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto'+pc+'"\
                                           name="SubtotalProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-1">\
                                <label><br></label><br>\
                                <a href="#" id="'+pc+'" class="remove_field4 btn btn-danger">\
                                    <span class="glyphicon glyphicon-trash"></span>\
                                </a>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

        //get a reference to the select element
        $select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/GetvaluesCompra_json.php?q=2',
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

    });

	//adiciona campos dinamicamente
    var pc = $("#PCount").val(); //initlal text box count
    $(".add_field_button6").click(function(e){ //on add input button click
        e.preventDefault();

        pc++; //text box increment
        $("#PCount").val(pc);

		$(".input_fields_wrap6").append('\
            <div class="form-group" id="6div'+pc+'">\
                <div class="panel panel-success">\
                    <div class="panel-heading">\
                        <div class="row">\
                            <div class="col-md-1">\
                                <label for="QtdCompraProduto">Qtd:</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdCompraProduto'+pc+'" placeholder="0"\
                                        onkeyup="calculaSubtotalCompra(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdCompraProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
										name="QtdCompraProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-7">\
                                <label for="idTab_Produto">Produto:</label><br>\
                                <select class="form-control Chosen" id="listadinamicab'+pc+'" onchange="buscaValorCompra(this.value,this.name,\'Produto\','+pc+')" name="idTab_Produto'+pc+'">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
                            <div class="col-md-2">\
                                <label for="ValorCompraProduto">Valor do Produto:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
                                        onkeyup="calculaSubtotalCompra(this.value,this.name,'+pc+',\'VP\',\'Produto\')"\
                                        name="ValorCompraProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-2">\
                                <label for="SubtotalProduto">Subtotal:</label><br>\
                                <div class="input-group id="txtHint">\
                                    <span class="input-group-addon" id="basic-addon1">R$</span>\
                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto'+pc+'"\
                                           name="SubtotalProduto'+pc+'" value="">\
                                </div>\
                            </div>\
						</div>\
						<div class="row">\
							<div class="col-md-1"></div>\
							<div class="col-md-7">\
								<label for="ObsProduto'+pc+'">Obs:</label><br>\
								<input type="text" class="form-control" id="ObsProduto'+pc+'" maxlength="250"\
									   name="ObsProduto'+pc+'" value="">\
							</div>\
							<div class="col-md-2">\
								<label for="DataValidadeProduto'+pc+'">Val. do Produto:</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataValidadeProduto'+pc+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
								</div>\
							</div>\
							<div class="col-md-1">\
                                <label><br></label><br>\
                                <a href="#" id="'+pc+'" class="remove_field6 btn btn-danger"\
                                    onclick="calculaQtdSoma(\'QtdCompraProduto\',\'QtdSoma\',\'ProdutoSoma\',1,'+pc+',\'CountMax\',0,\'ProdutoHidden\')">\
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
        $select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/GetvaluesCompra_json.php?q=2',
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

    });

	//adiciona campos dinamicamente
    var pc = $("#PCount").val(); //initlal text box count
    $(".add_field_button7").click(function(e){ //on add input button click
        e.preventDefault();

        pc++; //text box increment
        $("#PCount").val(pc);

		$(".input_fields_wrap7").append('\
            <div class="form-group" id="7div'+pc+'">\
                <div class="panel panel-danger">\
                    <div class="panel-heading">\
                        <div class="row">\
                            <div class="col-md-1">\
                                <label for="QtdCompraProduto">Qtd:</label><br>\
                                <div class="input-group">\
                                    <input type="text" class="form-control Numero" maxlength="10" id="QtdCompraProduto'+pc+'" placeholder="0"\
                                        onkeyup="calculaSubtotalCompra(this.value,this.name,'+pc+',\'QTD\',\'Produto\')"\
                                        name="QtdCompraProduto'+pc+'" value="">\
                                </div>\
                            </div>\
                            <div class="col-md-7">\
                                <label for="idTab_Produto">Produto:</label><br>\
                                <select class="form-control Chosen" id="listadinamicab'+pc+'" onchange="buscaValorCompra(this.value,this.name,\'Produto\','+pc+')" name="idTab_Produto'+pc+'">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
                        </div>\
						<div class="row">\
						<div class="col-md-1"></div>\
						<div class="col-md-7">\
								<label for="ObsProduto'+pc+'">Obs:</label><br>\
								<input type="text" class="form-control" id="ObsProduto'+pc+'" maxlength="250"\
									   name="ObsProduto'+pc+'" value="">\
							</div>\
							<div class="col-md-1">\
                                <label><br></label><br>\
                                <a href="#" id="'+pc+'" class="remove_field7 btn btn-danger">\
                                    <span class="glyphicon glyphicon-trash"></span>\
                                </a>\
                            </div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

        //get a reference to the select element
        $select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/GetvaluesCompra_json.php?q=2',
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
							<div class="col-md-4">\
								<label for="Nome_Prod'+pd+'">Produto '+pd+'</label>\
								<input type="text" class="form-control" id="Nome_Prod'+pd+'" readonly=""\
										  name="Nome_Prod'+pd+'" value="">\
							</div>\
							<div class="col-md-3">\
                                <label for="Opcao_Atributo_1">Atributo1 </label><br>\
                                <select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="listadinamicam'+pd+'" name="Opcao_Atributo_1'+pd+'">\
                                    <option value="">-- Selecione uma opção --</option>\
                                </select>\
                            </div>\
							<div class="col-md-2">\
								<label for="Opcao_Atributo_2'+pd+'">Atributo2</label>\
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen2" id="listadinamican'+pd+'" name="Opcao_Atributo_2'+pd+'">\
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
                $select.html('<option id="-1">ERRO</option>');
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

		});

    });	
		
    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap").on("click",".remove_field", function(e){ //user click on remove text
        $("#1div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaDevolucao();
    })
			
    //Remove os campos adicionados de Produtos No Orçamento do CLIENTE dinamicamente
    $(".input_fields_wrap2").on("click",".remove_field2", function(e){ //user click on remove text
        $("#2div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaOrcamentoCli();
    })

    //Remove os campos adicionados de Produtos No Orçamento do CONSULTOR dinamicamente
    $(".input_fields_wrap42").on("click",".remove_field42", function(e){ //user click on remove text
        $("#42div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaOrcamento();
    })
	
    //Remove os campos adicionados de Produtos No Orçamento do CONSULTOR dinamicamente
    $(".input_fields_wrap9").on("click",".remove_field9", function(e){ //user click on remove text
        $("#9div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaOrcamento();
    })	

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap10").on("click",".remove_field10", function(e){ //user click on remove text
        $("#10div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaDevolucao();
    })
	
    //Remove os campos adicionados dinamicamente das Categorias
    $(".input_fields_wrap93").on("click",".remove_field93", function(e){ //user click on remove text
        $("#93div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaDevolucao();
    })
	
    //Remove os campos adicionados dinamicamente das Cores e Tipos
    $(".input_fields_wrap92").on("click",".remove_field92", function(e){ //user click on remove text
        $("#92div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaDevolucao();
    })
	
    //Remove os campos adicionados dinamicamente das Tamanhos
    $(".input_fields_wrap91").on("click",".remove_field91", function(e){ //user click on remove text
        $("#91div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaDevolucao();
    })
	
    //Remove os campos adicionados de Produtos No Orçamento do CONSULTOR dinamicamente
    $(".input_fields_wrap97").on("click",".remove_field97", function(e){ //user click on remove text
        $("#97div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        //calculaOrcamento();
    })
	
    //Remove os campos adicionados de Produtos No Orçamento do CONSULTOR dinamicamente
    $(".input_fields_wrap99").on("click",".remove_field99", function(e){ //user click on remove text
        $("#99div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        //calculaOrcamento();
    })	
	
    //Remove os campos adicionados dinamicamente das Cores e Tipos
    $(".input_fields_wrap100").on("click",".remove_field100", function(e){ //user click on remove text
        $("#100div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaDevolucao();
    })	
	
    //Remove os campos adicionados de Produtos Comprados dinamicamente
    $(".input_fields_wrap11").on("click",".remove_field11", function(e){ //user click on remove text
        $("#11div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaOrcamento();
    })	

    //Remove os campos adicionados de Produtos Devolvidos (Comprados) dinamicamente
    $(".input_fields_wrap12").on("click",".remove_field12", function(e){ //user click on remove text
        $("#12div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaDevolucao();
    })
	
	//Remove os campos adicionados dinamicamente
    $(".input_fields_wrap4").on("click",".remove_field4", function(e){ //user click on remove text
        $("#4div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaOrcamento();
    })

	//Remove os campos adicionados dinamicamente
    $(".input_fields_wrap5").on("click",".remove_field5", function(e){ //user click on remove text
        $("#5div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo da despesa e total restante
        calculaDespesas();
    })

	//Remove os campos adicionados dinamicamente
    $(".input_fields_wrap6").on("click",".remove_field6", function(e){ //user click on remove text
        $("#6div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaDespesas();
    })

	//Remove os campos adicionados dinamicamente
    $(".input_fields_wrap7").on("click",".remove_field7", function(e){ //user click on remove text
        $("#7div"+$(this).attr("id")).remove();
		//após remover o campo refaz o cálculo do orçamento e total restante
        //calculaCompra();
    })

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap3").on("click",".remove_field3", function(e){ //user click on remove text
        $("#3div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap31").on("click",".remove_field31", function(e){ //user click on remove text
        $("#31div"+$(this).attr("id")).remove();
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
	
    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap13").on("click",".remove_field13", function(e){ //user click on remove text
        $("#13div"+$(this).attr("id")).remove();
    })
	
    //Remove as PARCELAS RECEBÍVEIS dinamicamente
    $(".input_fields_wrap21").on("click",".remove_field21", function(e){ //user click on remove text
        $("#21div"+$(this).attr("id")).remove();
    })

    //Remove as PARCELAS RECEBÍVEIS ALTERAR dinamicamente
    $(".input_fields_wrap24").on("click",".remove_field24", function(e){ //user click on remove text
        $("#24div"+$(this).attr("id")).remove();
    })
	
    //Remove as PARCELAS PAGÁVEIS dinamicamente
    $(".input_fields_wrap22").on("click",".remove_field22", function(e){ //user click on remove text
        $("#22div"+$(this).attr("id")).remove();
    })	

    //Remove as PARCELAS PAGÁVEIS ALTERAR dinamicamente
    $(".input_fields_wrap23").on("click",".remove_field23", function(e){ //user click on remove text
        $("#23div"+$(this).attr("id")).remove();
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
    defaultView: 'month',
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
            var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b>" + event.Obs + "<br>\n\<b>Prof.:</b> " + event.Profissional;
        else {

            if (event.Paciente == 'D')
                var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b> " + event.Obs  + "<br>\n\<b>Prof.:</b> " + event.Profissional + "<br>\n\<b>Cliente: </b>" + event.title + "</b><br><b>Responsável:</b> " + event.subtitle + "<br><b>Tel.:</b> " + event.CelularCliente + 
							"<br>\n\<b>Tipo: </b> " + event.TipoConsulta;
            else
                var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b> " + event.Obs + "<br>\n\<b>Prof.:</b> " + event.Profissional + "<br>\n\<b>Cliente: </b>" + event.title + "<b> " + "<br><b>Tel.:</b> " + event.CelularCliente + 
							"<br>\n\<b>Tipo: </b> " + event.TipoConsulta;
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

function redirecionar(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 1) ? url = 'consulta/cadastrar_evento' : url = 'consulta/cadastrar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}
 
 function redirecionar4(x) {

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

