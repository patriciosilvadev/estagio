<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">

        <?
        $data = @$obj->_data;
        $data = substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4);
        ?>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Saida</a></h3>
        <div>
            <form name="form_contaspagar" id="form_contaspagar" action="<?= base_url() ?>cadastros/contaspagar/confirmar/<?= @$obj->_financeiro_contaspagar_id; ?>" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Valor *</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="financeiro_contaspagar_id" class="texto_id" name="financeiro_contaspagar_id" value="<?= @$obj->_financeiro_contaspagar_id; ?>" />
                        <input type="text" name="valor" alt="decimal" class="texto04" value="<?= @$obj->_valor; ?>"/>
                    </dd>
                    <dt>
                        <label>Data*</label>
                    </dt>
                    <dd>
                        <input type="text" name="inicio" id="inicio" class="texto04" value="<?= $data; ?>"/>
                    </dd>
                    <dt>
                        <label>Data de Pagamento</label>
                    </dt>
                    <dd>
                        <input type="text" name="data_pagamento" id="data_pagamento" class="texto04" alt="date" value="<?=(@$obj->_data_pagamento != '') ? substr(@$obj->_data_pagamento, 8, 2) . '/' . substr(@$obj->_data_pagamento, 5, 2) . '/' . substr(@$obj->_data_pagamento, 0, 4) : '';  ?>"/>
                    </dd>
                    <dt>
                        <label>Pagar a:</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="credor" class="texto_id" name="credor" value="<?= @$obj->_credor; ?>" />
                        <input type="text" id="credorlabel" class="texto09" name="credorlabel" value="<?= @$obj->_razao_social; ?>" readonly="true"/>
                    </dd>
                    <dt>
                        <label>Tipo *</label>
                    </dt>
                    <dd>
                        <input type="text" name="tipo" id="tipo"  class="texto04" value="<?= @$obj->_tipo; ?>" readonly="true"/>
                    </dd>
                    <dt>
                        <label>Classe *</label>
                    </dt>
                    <dd>
                        <input type="text" name="classe" id="classe"  class="texto04" value="<?= @$obj->_classe; ?>" readonly="true"/>
                    </dd>
                    <dt>
                        <label>Tipo numero</label>
                    </dt>
                    <dd>
                        <input type="text" name="tiponumero" id="tiponumero" class="texto04" value="<?= @$obj->_tipo_numero; ?>" readonly="true"/>
                    </dd>
                    <dt>
                        <label>Conta *</label>
                    </dt>
                    <dd>
                        <select name="conta_id" id="conta_id" class="size4" required="">
                            <option value="">Selecione</option>
                            <? foreach ($conta as $value) : ?>
                                <option value="<?= $value->forma_entradas_saida_id; ?>"<?
                                if (@$obj->_conta_id == $value->forma_entradas_saida_id):echo'selected';
                                endif;
                                ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Repetir </label>
                    </dt>
                    <dd>
                        <input type="text" name="repitir" alt="integer" class="texto02" value="<?= @$obj->_numero_parcela; ?>" readonly="true"/> nos proximos meses
                    </dd>
                    <dt>
                        <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="70" rows="3" name="Observacao" id="Observacao" ><?= @$obj->_observacao; ?></textarea><br/>
                    </dd>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });


    $(function () {
        $("#credorlabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=credordevedor",
            minLength: 1,
            focus: function (event, ui) {
                $("#credorlabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#credorlabel").val(ui.item.value);
                $("#credor").val(ui.item.id);
                return false;
            }
        });
    });


    $(function () {
        $("#inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(document).ready(function () {
        jQuery('#form_emprestimo').validate({
            rules: {
                valor: {
                    required: true
                },
                contaspagar: {
                    required: true
                },
                inicio: {
                    required: true
                }
            },
            messages: {
                valor: {
                    required: "*"
                },
                contaspagar: {
                    required: "*"
                },
                inicio: {
                    required: "*"
                }
            }
        });
    });
</script>