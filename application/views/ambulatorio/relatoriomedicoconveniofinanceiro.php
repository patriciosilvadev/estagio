<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Produção Médica</a></h3>
        <div>
            <form name="form_paciente" id="form_paciente"  method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriomedicoconveniofinanceiro">
                <dl>
                    <dt>
                        <label>Medico</label>
                    </dt>
                    <dd>
                        <select name="medicos" id="medicos" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Revisor</label>
                    </dt>
                    <dd>
                        <select name="revisor" id="revisor" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size2">
                            <option value='0' >TODOS</option>
                            <option value="" >SEM PARTICULAR</option>
                            <option value="1" >PARTICULARES</option>
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Grupo Convenio</label>
                    </dt>
                    <dd>
                        <select name="grupoconvenio" id="convenio" class="size2">
                            <option value='0' >TODOS</option>
                            <? foreach ($grupoconvenio as $value) : ?>
                                <option value="<?= $value->convenio_grupo_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Sala</label>
                    </dt>
                    <dd>
                        <select name="sala_id" id="sala_id" class="size2">
                            <option value='0' >TODOS</option>
                            <? foreach ($salas as $value) : ?>
                                <option value="<?= $value->exame_sala_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <dt>
                        <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                    </dd>

                    <dt>
                        <label>Data De Pesquisa</label>
                    </dt>
                    <dd>
                        <select name="data_atendimento" id="data_atendimento" class="size2" >
                            <option value='1' >DATA DE ATENDIMENTO</option>
                            <option value='0' >DATA DE FATURAMENTO</option>

                        </select>
                    </dd>
                    <!-- <br> -->
                    <dt>
                        <label>Especialidade</label>
                    </dt>
                    <dd>
                        <select name="grupo[]" id="grupo" class="chosen-select" data-placeholder="Selecione as especialidades (Todos ou vázio trará todos)..." multiple>
                            <option value='0' >TODOS</option>
                            <option value='1' >SEM RM</option>
                            <? foreach ($grupos as $grupo) { ?>                                
                                <option value='<?= $grupo->nome ?>' <?
                                if (@$obj->_grupo == $grupo->nome):echo 'selected';
                                endif;
                                ?>><?= $grupo->nome ?></option>
                                    <? } ?>
                        </select>
                    </dd>
                    <br>
                    <br>
                    <dt>
                        <label>Faturamento</label>
                    </dt>
                    <dd>
                        <select name="faturamento" id="faturamento" class="size1" >
                            <option value='' >TODOS</option>
                            <option value='t' >Faturado</option>
                            <option value='f' >Não Faturado</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Clinica</label>
                    </dt>
                    <dd>
                        <select name="clinica" id="clinica" class="size1" >
                            <option value='SIM' >SIM</option>
                            <option value='NAO' >NÃO</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Valor Líquido</label>
                    </dt>
                    <dd>
                        <select name="valor_liquido" id="valor_liquido" class="size1" >
                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Produção Ambulatorial</label>
                    </dt>
                    <dd>
                        <select name="producao_ambulatorial" id="producao_ambulatorial" class="size1">
                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Desconto Especial</label>
                    </dt>
                    <dd>
                        <select name="tipo_desconto" id="tipo_desconto" class="size1">
                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Promotor</label>
                    </dt>
                    <dd>
                        <select name="promotor" id="promotor" class="size1" >
                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Laboratório</label>
                    </dt>
                    <dd>
                        <select name="laboratorio" id="laboratorio" class="size1" >
                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Somar Crédito</label>
                    </dt>
                    <dd>
                        <select name="somarcredito" id="somarcredito" class="size1" >
                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Forma de Pagamento</label>
                    </dt>
                    <dd>
                        <select name="forma_pagamento" id="forma_pagamento" class="size1" >
                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Situação</label>
                    </dt>
                    <dd>
                        <select name="situacao" id="situacao" class="size1" >
                            <option value='' >TODOS</option>
                            <option value='1'>FINALIZADO</option>
                            <option value='0' >ABERTO</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Solicitante</label>
                    </dt>
                    <dd>
                        <select name="solicitante" id="solicitante" class="size1" >
                            <option value='NAO' selected="">NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Taxa de administração</label>
                    </dt>
                    <dd>
                        <select name="mostrar_taxa" id="mostrar_taxa" class="size1" >
                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Recibo</label>
                    </dt>
                    <dd>
                        <select name="recibo" id="recibo" class="size1" >

                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Previsão de recebimento</label>
                    </dt>
                    <dd>
                        <select name="tabela_recebimento" id="recibo" class="size1" >

                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Ordem do Relatório</label>
                    </dt>
                    <dd>
                        <select name="ordem" id="recibo" class="size1" >

                            <option value='0' >NORMAL</option>
                            <option value='1' >ATENDIMENTO</option>
                        </select>
                    </dd>
                    <? $empresa_id = $this->session->userdata('empresa_id'); ?>
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" <? if ($empresa_id == $value->empresa_id) { ?>selected<? } ?>><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="0">TODOS</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Gerar PDF</label>
                    </dt>
                    <dd>
                        <select name="gerarpdf" id="gerarpdf" class="size2">
                            <option value="NAO">NÃO</option>
                            <option value="SIM">SIM</option>
                        </select>
                    </dd>
                    <dt>
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#txtdata_inicio").datepicker({
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
        $("#txtdata_fim").datepicker({
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
        $("#accordion").accordion();
    });

</script>