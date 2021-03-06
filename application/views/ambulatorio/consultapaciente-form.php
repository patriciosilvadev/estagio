<?php
$empresa = $this->guia->listarempresapermissoes();
$desabilitar_trava_retorno = $empresa[0]->desabilitar_trava_retorno;
?>
<script>
//    function consultasAnteriores() {
//        if( $("#txtNomeid").val() != "" && $("#convenio").val() != "" && $("#procedimento").val() != ""){
//            jQuery.ajax({
//                url: "<?= base_url(); ?>autocomplete/buscaconsultasanteriores",
//                type: "GET",
//                data: 'paciente_id=' + $("#txtNomeid").val() + '&convenio_id=' + $("#convenio").val() + '&procedimento_id=' + $("#procedimento").val(),
//                dataType: 'json',
//                async: false,
//                success: function (retorno) {
//                    if(retorno.length > 0){
//                        var mensagem = "Este paciente ja fez ";
//                        
//                        if (retorno[0].tipo = "EXAME") { mensagem += "esse exame"; }
//                        else { mensagem += "essa consulta"; }
//                        
//                        mensagem += " nos ultimos 30 dias. Deseja prosseguir?";
//                        var escolha = confirm(mensagem);
//                        
//                        if(escolha) document.form_exametemp.submit(); 
//                    }
//                    else{
//                        document.form_exametemp.submit(); 
//                    }
//                },
//                error: function(erro){
//                    return true;
//                }
//            });
//            
//            return false;
//        }
//        else{
//            return true;
//        }
//        
//    }
</script>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacienteconsultatemp/<?= $agenda_exames_id ?>" method="post">
        <fieldset>
            <legend>Marcar Consulta</legend>

            <div>
                <label>Nome</label>
                <input type="hidden" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                <input type="text" id="txtNome" required name="txtNome" class="texto10" onblur="calculoIdade(document.getElementById('nascimento').value)"  />
                <input type="hidden" id="agendaid" name="agendaid" class="texto_id" value="<?= $agenda_exames_id; ?>"/>
                <input type="hidden" id="inicio" name="inicio" class="texto_id" value="<?= $consultas[0]->inicio; ?>"/>
                <input type="hidden" id="medicoid" name="medicoid" class="texto_id" value="<?= $consultas[0]->medico_agenda; ?>"/>
                <input type="hidden" id="data_agendamento" name="data_agendamento" class="texto_id" value="<?= $consultas[0]->data; ?>"/>
            </div>
            <div>
                <label>Dt de nascimento</label>

                <input type="text" name="nascimento" id="nascimento" class="texto02" alt="date"  maxlength="10"  onkeypress="mascara3(this)" onblur="calculoIdade(this.value)"/>
            </div>
            <div>
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>

            </div>
            <div>
                <label>Idade</label>
                <input type="text" name="idade2" id="idade2" class="texto01" readonly/>
            </div>
            <div>
                <label>Telefone</label>


                <input type="text" id="txtTelefone" class="texto02" name="txtTelefone"/>
            </div>
            <div>
                <label>Celular</label>


                <input type="text" id="txtCelular" class="texto02" name="txtCelular"/>
            </div>
            
             <div>
                <label>WhatsApp</label>
                <input type="text" id="txtwhatsapp" class="texto02" name="txtwhatsapp" value=""/>
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio" id="convenio" class="size4" required>
                    <option  value="0">Selecione</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <?
            if($empresapermissoes == 't'){
            ?>
            <div>
                <label>Origem</label>
                <select  name="origem" id="origem" class="size1" >
                    <option value="">Selecione</option>
                    <?
                    foreach ($origem as $item) :
                        ?>
                        <option value="<?= $item->exame_sala_id; ?>"  >
                            <?= $item->nome; ?>
                        </option>
                    <? endforeach; ?>
                </select>
            </div>
            <?
            }
            ?>

            
            <div>
                <label>Procedimento</label>
<!--                <select  name="procedimento" id="procedimento" class="size1" required >
                    <option value="">Selecione</option>
                </select>-->
                <select name="procedimento" id="procedimento" class="size4 chosen-select" data-placeholder="Selecione" tabindex="1"  required="">
                    <option value="">Selecione</option>
                </select>

            </div>
            <div>
                <label>Observacoes</label>


                <input type="text" id="observacoes" class="texto10" name="observacoes" />
            </div>


            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar" onclick="javascript: return consultasAnteriores()">
                    Enviar
                </button>
            </div>
    </form>
</fieldset>

<fieldset>
    <? ?>
    <table id="table_agente_toxico" border="0">
        <thead>

            <tr>
                <th class="tabela_header">Data</th>
                <th class="tabela_header">Hora</th>
                <th class="tabela_header">Exame</th>
                <th class="tabela_header">Observa&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <?
        $estilo_linha = "tabela_content01";
        foreach ($consultas as $item) {
            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
            ?>
            <tbody>
                <tr>
                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                </tr>

            </tbody>
            <?
        }
        ?>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 

</fieldset>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    /*    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 130px; }*/
</style>
<script>
                    function mascaraTelefone(campo) {

                        function trata(valor, isOnBlur) {

                            valor = valor.replace(/\D/g, "");
                            valor = valor.replace(/^(\d{2})(\d)/g, "($1)$2");

                            if (isOnBlur) {

                                valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
                            } else {

                                valor = valor.replace(/(\d)(\d{3})$/, "$1-$2");
                            }
                            return valor;
                        }

                        campo.onkeypress = function (evt) {

                            var code = (window.event) ? window.event.keyCode : evt.which;
                            var valor = this.value

                            if (code > 57 || (code < 48 && code != 8)) {
                                return false;
                            } else {
                                this.value = trata(valor, false);
                            }
                        }

                        campo.onblur = function () {

                            var valor = this.value;
                            if (valor.length < 13) {
                                this.value = ""
                            } else {
                                this.value = trata(this.value, true);
                            }
                        }

                        campo.maxLength = 14;
                    }


</script>
<script type="text/javascript">
    jQuery("#txtTelefone")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });
jQuery("#txtwhatsapp")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });
    jQuery("#txtCelular")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

    $(function () {
        $("#data_ficha").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function () {
        $('#exame').change(function () {
            if ($(this).val()) {
                $('#horarios').hide();
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/horariosambulatorio', {exame: $(this).val(), teste: $("#data_ficha").val()}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '-' + j[i].nome + '-' + j[i].medico_agenda + '</option>';
                    }
                    $('#horarios').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#horarios').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#convenio').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioconsulta', {convenio1: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
//                                    $('#procedimento').html(options).show();
                    $('#procedimento option').remove();
                    $('#procedimento').append(options);
                    $("#procedimento").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento option').remove();
                $('#procedimento').append('');
                $("#procedimento").trigger("chosen:updated");
            }
        });
    });



    $(function () {
        $('#procedimento').change(function () {
            if ($(this).val()) {

                $('.carregando').show();

//                $("#submitButton").attr('disabled', 'disabled');
<? if ($desabilitar_trava_retorno == 'f') { ?>

                    var txtpaciente_id = $("#txtNomeid").val();
                    $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimento', {procedimento_id: $(this).val(), paciente_id: txtpaciente_id, ajax: true}, function (r) {
                        //                      alert(r.grupo);
                        if (r.qtdeConsultas == 0 && r.grupo == "RETORNO") {
                            //                            alert(r.qtdeConsultas);
                            alert("Erro ao selecionar retorno. Esse paciente não executou o procedimento associado a esse retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
                            $("select[name=procedimento1]").val($("select[name=procedimento1] option:first-child").val(''));
                        } else if (r.qtdeConsultas > 0 && r.grupo == "RETORNO" && r.retorno_realizado > 0) {
                            alert("Erro ao selecionar retorno. Esse paciente já realizou o retorno associado a esse procedimento no tempo cadastrado");
                            $("select[name=procedimento1]").val($("select[name=procedimento1] option:first-child").val(''));
                        }
                    });


                    $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimentoinverso', {procedimento_id: $(this).val(), paciente_id: txtpaciente_id, ajax: true}, function (r) {
                        if (r.qtdeConsultas > 0 && r.retorno_realizado == 0) {
                            alert("Este paciente tem direito a um retorno associado ao procedimento escolhido");
                            $("#procedimento").val(r.procedimento_retorno);
                        }
                    });

<? } ?>

          $.getJSON('<?= base_url() ?>autocomplete/verificarquantidaderetorno', {agenda_exames_id:$("#agendaid").val(),inicio:$("#inicio").val(),medicoid:$("#medicoid").val(),data:$("#data_agendamento").val(),procedimento_convenio_id:$(this).val(),empresa_id:<?= $consultas[0]->empresa_id; ?>,  ajax: true}, function (j) {
                     if(j != "ok"  && j != ""){ 
                          alert(j);
                    }
                   console.log(j);
            });

            }

        });
    });




    $(function () {
        $("#txtNome").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 10, // Todas as telas de agendamento eu coloquei esse comentario. Quando for alterar esse valor, basta ir em "Localizar em Projetos" e pesquisar por ele.
            focus: function (event, ui) {
                $("#txtNome").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#txtTelefone").val(ui.item.itens);
                $("#txtwhatsapp").val(ui.item.whatsapp);
                $("#txtCelular").val(ui.item.celular);
                $("#nascimento").val(ui.item.valor);
                buscarfaixaetaria(ui.item.id);
                return false;
            }
        });
    });





    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_exametemp').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

//    function calculoIdade() {
//        var data = document.getElementById("nascimento").value;
//        var ano = data.substring(6, 12);
//        var idade = new Date().getFullYear() - ano;
//        document.getElementById("idade2").value = idade;
//    }
    function calculoIdade() {
        var data = document.getElementById("nascimento").value;

        if (data != '' && data != '//') {

            var ano = data.substring(6, 12);
            var idade = new Date().getFullYear() - ano;

            var dtAtual = new Date();
            var aniversario = new Date(dtAtual.getFullYear(), parseInt(data.substring(3, 5)) - 1, data.substring(0, 2));

            if (dtAtual < aniversario) {
                idade--;
            }

            document.getElementById("idade2").value = idade + " ano(s)";
        }
    }

    jQuery("#nascimento").mask("99/99/9999");


function buscarfaixaetaria(paciente_id){ 
    $.getJSON('<?= base_url() ?>autocomplete/buscarfaixaetaria', {paciente_id: paciente_id,medicoid:$("#medicoid").val(),empresa_id:<?= $consultas[0]->empresa_id; ?>, ajax: true}, function (j) {      
        if(j != ""){
          alert(j); 
             $("#txtNome").val("");
             $("#txtNomeid").val("");
             $("#telefone").val("");
             $("#txtCelular").val("");
             $("#nascimento").val("");
             $("#txtwhatsapp").val("");
             $("#txtcpf").val("");
             $("#sexo").empty(); 
        }
        console.log(j);
    }); 
}

</script>