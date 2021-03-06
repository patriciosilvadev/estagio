<? 
$recomendacao_obrigatorio = $this->session->userdata('recomendacao_obrigatorio');
$empresa_id = $this->session->userdata('empresa_id');
$empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);
$setores = $empresapermissoes[0]->setores;
?>
<style>
    .custom-combobox {
        position: relative;
        display: inline-block;
    }
    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
    }
    .custom-combobox-input {
        margin: 0;
        /*padding: 5px 10px;*/
    }
    .custom-combobox a {
        display: inline-block;        
    }
</style>
<script>
    
    $(function () {
        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);

                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },

            _createAutocomplete: function () {
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
                
                var wasOpen = false;
//                console.log(value);

                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", "")
                        <? if ($recomendacao_obrigatorio == 't'){ ?>
                        .attr("required", "")
                        <? } ?>
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left input-recomendacao-combobox")
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy(this, "_source")
                        })
                        .tooltip({
                            classes: {
                                "ui-tooltip": "ui-state-highlight"
                            }
                        });

                this._on(this.input, {
                    autocompleteselect: function (event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option.text
                        });
                    },

                    autocompletechange: "_removeIfInvalid"
                });
            },

            _createShowAllButton: function () {
                var input = this.input,
                        wasOpen = false;

                input.on("click", function () {
                    input.trigger("focus");

                    // Close if already visible
                    if (wasOpen) {
                        return;
                    }

                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete("search", "");
                });
            },

            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },

            _removeIfInvalid: function (event, ui) {

                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function () {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if (valid) {
                    return;
                }

                // Remove invalid value
                this.input
                        .val("")
                        .tooltip("open");
                this.element.val("");
                this._delay(function () {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },

            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });
        <? for($i = 1; $i <= count($exames); $i++) { ?>
            $("#indicacao<?= $i ?>").combobox();
        <? } ?>
    });
</script>

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <!--<div class="clear"></div>-->
    <div class="bt_link_new" style="width: 150pt">
        <a style="width: 150pt" onclick="javascript:window.open('<?= base_url() ?>seguranca/operador/novorecepcao');">
            Novo Medico Solicitante
        </a>
    </div>
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/novo/<?= $paciente_id ?>');">
            Nova guia
        </a>
    </div>

    <div>
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>cadastros/pacientes/autorizarambulatoriotemp/<?= $paciente_id; ?>" method="post">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <input name="sexo" id="txtSexo" class="size2" 
                           value="<?
                            if ($paciente['0']->sexo == "M"):echo 'Masculino';
                            endif;
                            if ($paciente['0']->sexo == "F"):echo 'Feminino';
                            endif;
                            if ($paciente['0']->sexo == "O"):echo 'Outro';
                            endif;
                           ?>" readonly="true">
                </div>

                <div>
                    <label>Nascimento</label>


                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                </div>

                <div>

                    <label>Idade</label>
                    <input type="text" name="txtIdade" id="txtIdade" class="texto01" readonly/>

                </div>

                <div>
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto09" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
            </fieldset>
            <input type="hidden" name="paciente_id" value="<?= $paciente_id; ?>" />

            <fieldset>
                <legend>Autorizar exames</legend>
                <table id="table_justa">
                    <thead>

                        <tr>
                            <th class="tabela_header">Hora</th>
                            <th class="tabela_header">Sala</th>
                            <th class="tabela_header">Qtde</th>
                            <th class="tabela_header">Solicitante</th>
                            <th class="tabela_header">Convenio</th>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">Autorizacao</th>
                            <th class="tabela_header">Guia Convênio</th>
                            <th class="tabela_header">V. Unit</th>
                            <th class="tabela_header">Pagamento</th>
                            <th class="tabela_header">Promotor</th>
                            <? if($setores == 't'){?>
                                <th class="tabela_header">Setores</th>
                                <?}else{?>
                                <th class="tabela_header">Entrega</th>
                                <?}?>

                            <th class="tabela_header">ordenador</th>
                            <th class="tabela_header">Confir.</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    $i = 0;
                    foreach ($exames as $item) {
                        $i++;
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        $agenda_exame_id = $item->agenda_exames_id;
                        ?>
                        <input type="hidden" name="medicoexecutante[<?= $i; ?>]" value="<?= $item->medico_agenda; ?>" class="size1"/>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->inicio, 0, 5); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?= $item->sala; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="number" name="qtde[<?= $i; ?>]" id="qtde<?= $i; ?>"  alt="" min="1" value="1" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="medico[<?= $i; ?>]" id="medico<?= $i; ?>" class="size1"/>
                                    <input type="hidden" name="crm[<?= $i; ?>]" id="crm<?= $i; ?>" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="convenio[<?= $i; ?>]" id="convenio<?= $i; ?>" class="size1" >
                                        <option value="">Selecione</option>
                                        <? foreach ($convenio as $value) :
                                            if($empresapermissoes[0]->convenio_paciente == 't' && $paciente[0]->convenio_id != $value->convenio_id && $value->dinheiro == 'f'){
                                                continue;
                                            }
                                            $operador_id = $this->session->userdata('operador_id');
                                            if($empresapermissoes[0]->travar_convenio_paciente == 't' && $paciente[0]->convenio_id != $item->convenio_id && $operador_id != 1){
                                                continue;
                                            }
                                            ?>
                                            <option value="<?= $value->convenio_id; ?>" <? if ($value->convenio_id == $item->convenio_agenda) echo'selected'; ?>><?= $value->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="grupo[<?= $i; ?>]" id="grupo<?= $i; ?>" class="size1" >
                                        <option value="">Selecione</option>
                                        <?
                                        foreach ($grupos as $gp) :
                                            ?>
                                            <option value="<?= $gp->nome; ?>" <? if ($item->grupo == $gp->nome) echo 'selected'; ?>>
                                                <?= $gp->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="procedimento[<?= $i; ?>]" id="procedimento<?= $i; ?>" class="size1" >
                                        <option value="">-- Escolha um procedimento --</option>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="autorizacao[<?= $i; ?>]" id="autorizacao<?= $i; ?>" class="size1"/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="guiaconvenio[<?= $i; ?>]" id="guianumero<?= $i; ?>" class="size1"/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="valor[<?= $i; ?>]" id="valor<?= $i; ?>" class="texto01" readonly=""/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="formapamento[<?= $i; ?>]" id="formapamento<?= $i; ?>" class="size1" >
                                        <option value="0">Selecione</option>
                                        <? // foreach ($forma_pagamento as $item) : ?>
                                                <!--<option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>-->
                                        <? // endforeach;  ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select name="indicacao[<?= $i; ?>]" id="indicacao<?= $i ?>" class="size1 ui-widget" >
                                        <option value='' >Selecione</option>
                                        <?php
                                        $indicacao = $this->paciente->listaindicacao($_GET);
                                        foreach ($indicacao as $item) {
                                            ?>
                                            <option value="<?php echo $item->paciente_indicacao_id; ?>"> <?php echo $item->nome . ( ($item->registro != '' ) ? " - " . $item->registro : '' ); ?></option>
                                            <?php
                                        }
                                        ?> 
                                    </select>
                                </td>
                                 <? if($setores == 't'){?>
                        <td class="<?php echo $estilo_linha; ?>"> 
                            <select  name="setores[<?= $i; ?>]" id="setores" class="size1" required="" >
                                <option value="">Selecione</option>
                                <? foreach ($setor as $item) : ?>
                                    <option value="<?= $item->setor_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                            </select></td>

                                <?}else{?>
                        <td class="<?php echo $estilo_linha; ?>"><input type="text" id="data" name="data" class="size1"/></td>
                                <?}?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                    <select name="ordenador" id="ordenador" class="size1" >
                                        <option value='1' >Normal</option>
                                        <option value='2' >Prioridade</option>
                                        <option value='3' >Urgência</option>

                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" ><input type="checkbox" name="confimado[<?= $i; ?>]" id="checkbox<?= $i; ?>" <?= "checked"; ?> /><input type="hidden" name="agenda_exames_id[<?= $i; ?>]" value="<?= $agenda_exame_id; ?>" /></td>

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
                <hr/>
                <button type="submit" name="btnEnviar" id="submitButton">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" name="liberarAdmin" id="liberarAdmin">Liberaração Admin</button>
                <hr/>
                <div id="divSenha">
                    <label for="senhaAdmin">Senha Admin</label>
                    <input type="password" name="senhaAdmin" id="senhaAdmin">
                    <button type="button" name="enviarAdmin" id="enviarAdmin">Liberar</button>
                </div>
            </fieldset>
        </form>
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
        $("#divSenha").hide();
        $("#liberarAdmin").hide();
        $.getJSON('<?= base_url() ?>autocomplete/listarinadimplenciautocomplete', {paciente_id: <?=$paciente_id?>}, function (j) {
            // console.log(j);
            if(j == 'true'){
                alert('Foram encontradas inadimplências no paciente');  
                $('#submitButton').prop("disabled", true);  
                
                $("#liberarAdmin").show();
            }else{

            }
        });
        $('#liberarAdmin').click(function(){
            $("#divSenha").show();
        });
        $('#enviarAdmin').click(function(){
            var senha = $("#senhaAdmin").val();
            // alert($("#convenio1").val());
            $.ajax({
                type: "POST",
                data: {senha: senha},
                //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
                url: "<?= base_url() ?>autocomplete/listarusuarioSenhaAdmin",
                success: function (data) {
                    alert('Liberação efetuada com sucesso');
                    $('#submitButton').prop("disabled", false); 
                    $("#liberarAdmin").hide();
                    $("#divSenha").hide();
                },
                error: function (data) {
                    // console.log(data);
                    alert('Senha inválida');
                        
                }
            });

        });


                        $(document).ready(function () {
                            var convenio_agendado = new Array();
                            var proc_agendado = new Array();

<? for ($b = 1; $b <= $i; $b++) { ?>

    <? $it = ($b == 1) ? '' : $b; ?>
        <? if(@$exames[$b - 1]->convenio_agenda != ''){?>
            convenio_agendado[<?= $b - 1 ?>] = <?= @$exames[$b - 1]->convenio_agenda ?>;
        <?}else{?>
             convenio_agendado[<?= $b - 1 ?>] = '';
       <? }?>
           
        <? if(@$exames[$b - 1]->procedimento_tuss_id != ''){?>
           proc_agendado[<?= $b - 1 ?>] = <?= @$exames[$b - 1]->procedimento_tuss_id ?>;
        <?}else{?>
             proc_agendado[<?= $b - 1 ?>] = '';
       <? }?>
                                
                                

                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio<?= $it ?>', {convenio<?= $b ?>: convenio_agendado[<?= $b - 1 ?>], ajax: true}, function (t) {
        //                      alert(proc_agendado);
                                                var opt = '<option value=""></option>';
                                                var slt = '';
                                                for (var c = 0; c < t.length; c++) {
                                                    if (proc_agendado[<?= $b - 1 ?>] == t[c].procedimento_convenio_id) {
                                                        slt = "selected='true'";
                                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor<?= $it ?>', {procedimento<?= $b ?>: t[c].procedimento_convenio_id, ajax: true}, function (a) {
                                                                                var valor = a[0].valortotal;
                                                                                var qtde = a[0].qtde;
                                                                                document.getElementById("valor<?= $b ?>").value = valor;
                                                                                document.getElementById("qtde<?= $b ?>").value = qtde;
                                                                                $('.carregando').hide();
                                                        });
                                                                            
                                                        $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento<?= $b ?>', {procedimento<?= $b ?>: t[c].procedimento_convenio_id, ajax: true}, function (j) {
                                                                        var options = '<option value="0">Selecione</option>';
                                                                        for (var c = 0; c < j.length; c++) {
                                                                            if (j[c].forma_pagamento_id != null) {
                                                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                            }
                                                                        }
                                                                        $('#formapamento<?= $b ?>').html(options).show();
                                                                        $('.carregando').hide();
                                                        });
                                                    }
                                                    opt += '<option value="' + t[c].procedimento_convenio_id + '"' + slt + '>' + t[c].procedimento + ' - ' + t[c].codigo + '</option>';
                                                    slt = '';
                                                }
                                                $('#procedimento<?= $b ?>').html(opt).show();
                                                $('.carregando').hide();
                                            });

//                                                            if ($('#convenio<?= $b ?>').val() != -1) {
//                                                                //                                                    $('.carregando').show();
//                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $('#convenio1').val(), ajax: true}, function (j) {
//                                                                    options = '<option value="">Escolha um Procedimento</option>';
//                                                                    for (var c = 0; c < j.length; c++) {
//                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
//                                                                    }
//                                                                    //                                                        $('#procedimento1').html('<option value="">Escolha um Procedimento</option>').show();
//                                                                    $('#procedimento<?= $b ?>').html(options).show();
//                                                                    $('.carregando').hide();
//                                                                });
//                                                            } else {
//                                                                $('#procedimento<?= $b ?>').html('<option value="">Escolha um Convênio</option>');
//                                                            }

                                                            


                                                            //                                alert(convenio_agendado, proc_agendado);
                                                            $('#checkbox<?= $b ?>').change(function () {
                                                                if ($(this).is(":checked")) {
                                                                    $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: convenio_agendado[<?= $b - 1 ?>]}, function (j) {
                                                                        if (j[0].carteira_obrigatoria == 't') {
                                                                            $("#autorizacao<?= $b; ?>").prop('required', true);
                                                                        } else {
                                                                            $("#autorizacao<?= $b; ?>").prop('required', false);
                                                                        }
                                                                    });
                                                                    $("#medico_id<?= $b; ?>").prop('required', true);
                                                                    $("#medico<?= $b; ?>").prop('required', true);
                                                                    $("#sala<?= $b; ?>").prop('required', true);
                                                                    $("#convenio<?= $b; ?>").prop('required', true);
                                                                    $("#procedimento<?= $b; ?>").prop('required', true);
                                                                    <? if ( $recomendacao_obrigatorio == 't' ){ ?>
                                                                        $("#indicacao<?= $b; ?>").prop('required', true);
                                                                    <? } ?>
                                                                    
                                                                } else {
                                                                    $("#medico_id<?= $b; ?>").prop('required', false);
                                                                    $("#medico<?= $b; ?>").prop('required', false);
                                                                    $("#sala<?= $b; ?>").prop('required', false);
                                                                    $("#convenio<?= $b; ?>").prop('required', false);
                                                                    $("#procedimento<?= $b; ?>").prop('required', false);
                                                                    $("#autorizacao<?= $b; ?>").prop('required', false);
                                                                    <? if ( $recomendacao_obrigatorio == 't' ){ ?>
                                                                        $("#indicacao<?= $b; ?>").prop('required', false);
                                                                    <? } ?>
                                                                    //                                        $("#autorizacao<?= $b; ?>").prop('required', false);
                                                                }
                                                            });
                                                            
                                                            
<? }
?>

                                                    });
<? for ($b = 1; $b <= $i; $b++) { ?>
                                                        $(function () {
                                                            $('#convenio<?= $b; ?>').change(function () {
//                                                                alert('asdasd');
                                                                if ($(this).val()) {
                                                                    $('.carregando').show();
                                                                    $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: $(this).val()}, function (j) {
                                                                        options = '<option value=""></option>';
                                                                        <? if (@$empresapermissoes[0]->valor_convenio_nao == 't') { ?>
                                                                         if (j[0].dinheiro == 't') {
//                                                                            $("#valor<?= $b; ?>").show();
//                                                                          $("#valortd<?= $b; ?>").show();
                                                                              $("#valor<?= $b; ?>").attr("type", "text");
                                                                          } else {
                                                                              $("#valor<?= $b; ?>").attr("type", "hidden");
//                                                                            $("#valor<?= $b; ?>").hide();
//                                                                      $("#valortd<?= $b; ?>").hide();
                                                                         }
                                                                         <?}?>
                                                                        if (j[0].carteira_obrigatoria == 't') {
                                                                            $("#autorizacao<?= $b; ?>").prop('required', true);
                                                                        } else {
                                                                            $("#autorizacao<?= $b; ?>").prop('required', false);
                                                                        }

                                                                    });
                                                                }
                                                            });
                                                        });
                                                        
                                                        if ($('#convenio<?= $b; ?>').val()) {
                                                            $('.carregando').show();
                                                            $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: $('#convenio<?= $b; ?>').val()}, function (j) {
                                                                options = '<option value=""></option>';
                                                                <? if (@$empresapermissoes[0]->valor_convenio_nao == 't') { ?>
                                                                        if (j[0].dinheiro == 't') {
//                                                                            $("#valor<?= $b; ?>").show();
//                                                                            $("#valortd<?= $b; ?>").show();
                                                                              $("#valor<?= $b; ?>").attr("type", "text");
                                                                          } else {
                                                                              $("#valor<?= $b; ?>").attr("type", "hidden");
//                                                                            $("#valor<?= $b; ?>").hide();
//                                                                            $("#valortd<?= $b; ?>").hide();
                                                                        }
                                                                <?}?>
                                                                if (j[0].carteira_obrigatoria == 't') {
                                                                    $("#autorizacao<?= $b; ?>").prop('required', true);
                                                                } else {
                                                                    $("#autorizacao<?= $b; ?>").prop('required', false);
                                                                }

                                                            });
                                                        }
                                                        
                                                            
                                                    $(function () {
                                                        $('#grupo<?= $b ?>').change(function () {
                    //                                                if ($(this).val()) {
                                                            $('.carregando').show();
                                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupo', {grupo1: $(this).val(), convenio1: $('#convenio<?= $b ?>').val()}, function (j) {
                                                                options = '<option value=""></option>';
                                                                for (var c = 0; c < j.length; c++) {
                                                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                }
                                                                $('#procedimento<?= $b ?>').html(options).show();
                                                                $('.carregando').hide();
                                                            });
                    //                                                } else {
                    //                                                    $('#procedimento1').html('<option value="">Selecione</option>');
                    //                                                }
                                                        });
                                                    });


<? }
?>


                                                    $(function () {
                                                        $("#data1").datepicker({
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
                                                        $("#data2").datepicker({
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
                                                        $("#data3").datepicker({
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
                                                        $("#data4").datepicker({
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
                                                        $("#data5").datepicker({
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
                                                        $("#data6").datepicker({
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
                                                        $("#data7").datepicker({
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
                                                        $("#data8").datepicker({
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
                                                        $("#data9").datepicker({
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
                                                        $("#data10").datepicker({
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
                                                        $("#medico1").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico1").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico1").val(ui.item.value);
                                                                $("#crm1").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $("#medico2").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico2").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico2").val(ui.item.value);
                                                                $("#crm2").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $("#medico3").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico3").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico3").val(ui.item.value);
                                                                $("#crm3").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $("#medico4").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico4").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico4").val(ui.item.value);
                                                                $("#crm4").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $("#medico5").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico5").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico5").val(ui.item.value);
                                                                $("#crm5").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $("#medico6").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico6").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico6").val(ui.item.value);
                                                                $("#crm6").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $("#medico7").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico7").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico7").val(ui.item.value);
                                                                $("#crm7").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $("#medico8").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico8").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico8").val(ui.item.value);
                                                                $("#crm8").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $("#medico9").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico9").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico9").val(ui.item.value);
                                                                $("#crm9").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $("#medico10").autocomplete({
                                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                            minLength: 3,
                                                            focus: function (event, ui) {
                                                                $("#medico10").val(ui.item.label);
                                                                return false;
                                                            },
                                                            select: function (event, ui) {
                                                                $("#medico10").val(ui.item.value);
                                                                $("#crm10").val(ui.item.id);
                                                                return false;
                                                            }
                                                        });
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
                                                        $('#convenio1').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento1').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento1').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $("#submitButton").attr('disabled', 'disabled');
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor1").value = options;
                                                                    $("#submitButton").removeAttr('disabled');
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor1').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio2').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio2', {convenio2: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento2').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento2').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento2').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $("#submitButton").attr('disabled', 'disabled');
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor2', {procedimento2: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor2").value = options;
                                                                    $("#submitButton").removeAttr('disabled');
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor2').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio3').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio3', {convenio3: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento3').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento3').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento3').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $("#submitButton").attr('disabled', 'disabled');
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor3', {procedimento3: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor3").value = options;
                                                                    $("#submitButton").removeAttr('disabled');
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor3').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio4').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio4', {convenio4: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento4').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento4').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento4').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $("#submitButton").attr('disabled', 'disabled');
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor4', {procedimento4: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor4").value = options;
                                                                    $("#submitButton").removeAttr('disabled');
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor4').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio5').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio5', {convenio5: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento5').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento5').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento5').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor5', {procedimento5: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor5").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor5').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio6').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio6', {convenio6: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento6').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento6').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento6').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor6', {procedimento6: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor6").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor6').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio7').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio7', {convenio7: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento7').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento7').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento7').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor7', {procedimento7: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor7").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor7').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio8').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio8', {convenio8: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento8').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento8').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento8').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor8', {procedimento8: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor8").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor8').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio9').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio9', {convenio9: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento9').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento9').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento9').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor9', {procedimento9: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor9").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor9').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio10').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio10', {convenio10: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                    }
                                                                    $('#procedimento10').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#procedimento10').html('<option value="">-- Escolha um exame --</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento10').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor10', {procedimento10: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor10").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor10').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento1').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento1').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento1').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento2').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento2', {procedimento2: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento2').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento2').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento3').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento3', {procedimento3: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento3').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento3').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento4').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento4', {procedimento4: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento4').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento4').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento5').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento5', {procedimento5: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento5').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento5').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento6').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento6', {procedimento6: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento6').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento6').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento7').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento7', {procedimento7: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento7').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento7').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento8').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento8', {procedimento8: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento8').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento8').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento9').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento9', {procedimento9: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento9').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento9').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#procedimento10').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento10', {procedimento10: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value="0">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        if (j[c].forma_pagamento_id != null) {
                                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                        }
                                                                    }
                                                                    $('#formapamento10').html(options).show();
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#formapamento10').html('<option value="0">Selecione</option>');
                                                            }
                                                        });
                                                    });
//            $(function(){
//        $('#procedimento2').change(function(){
//            if( $(this).val() ) {
//                $('.carregando').show();
//                $.getJSON('<?= base_url() ?>autocomplete/listarautocompleteprocedimentosforma',{procedimento2:$(this).val(), ajax:true}, function(j){
//                    var options = '<option value=""></option>';	
//                    for (var c = 0; c < j.length; c++) {
//                        options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
//                    }	
//                    $('#formapamento2').html(options).show();
//                    $('.carregando').hide();
//                });
//            } else {
//                $('#formapamento2').html('<option value="0">Selecione</option>');
//            }
//        });
//    });

                                                    //$(function(){     
                                                    //    $('#exame').change(function(){
                                                    //        exame = $(this).val();
                                                    //        if ( exame === '')
                                                    //            return false;
                                                    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
                                                    //            var option = new Array();
                                                    //            $.each(data, function(i, obj){
                                                    //                console.log(obl);
                                                    //                option[i] = document.createElement('option');
                                                    //                $( option[i] ).attr( {value : obj.id} );
                                                    //                $( option[i] ).append( obj.nome );
                                                    //                $("select[name='horarios']").append( option[i] );
                                                    //            });
                                                    //        });
                                                    //    });
                                                    //});





                                                    $(function () {
                                                        $("#accordion").accordion();
                                                    });


                                                    $(document).ready(function () {
                                                        jQuery('#form_exametemp').validate({
                                                            rules: {
                                                                txtNome: {
                                                                    required: true,
                                                                    minlength: 3
                                                                },
                                                                nascimento: {
                                                                    required: true
                                                                },
                                                                idade: {
                                                                    required: true
                                                                }
                                                            },
                                                            messages: {
                                                                txtNome: {
                                                                    required: "*",
                                                                    minlength: "!"
                                                                },
                                                                nascimento: {
                                                                    required: "*"
                                                                },
                                                                idade: {
                                                                    required: "*"
                                                                }
                                                            }
                                                        });
                                                    });

//                                                    function calculoIdade() {
//                                                        var data = document.getElementById("txtNascimento").value;
//                                                        var ano = data.substring(6, 12);
//                                                        var idade = new Date().getFullYear() - ano;
//                                                        document.getElementById("txtIdade").value = idade;
//                                                    }
                                                    function calculoIdade() {
                                                        var data = document.getElementById("txtNascimento").value;

                                                        if (data != '' && data != '//') {

                                                            var ano = data.substring(6, 12);
                                                            var idade = new Date().getFullYear() - ano;

                                                            var dtAtual = new Date();
                                                            var aniversario = new Date(dtAtual.getFullYear(), parseInt(data.substring(3, 5)) - 1, data.substring(0, 2));

                                                            if (dtAtual < aniversario) {
                                                                idade--;
                                                            }

                                                            document.getElementById("txtIdade").value = idade + " ano(s)";
                                                        }
                                                    }
                                                    calculoIdade();

</script>
