<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Modelo Medicamento</a></h3>
        <div>
            <form name="form_novomedicamento" id="form_novomedicamento" action="<?= base_url() ?>ambulatorio/modelomedicamento/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtmedicamentoID" id="txtmedicamentoID" class="texto09" value="<?=@$obj->_ambulatorio_modelo_medicamento_id?>">
                        <input type="text" name="txtmedicamento" id="txtmedicamento" class="texto09" value="<?=@$obj->_nome?>">
                    </dd>

                    <dt>
                        <label>Quantidade</label>
                    </dt>
                    <dd>
                        <input type="text" name="qtde" id="qtde" class="texto02" alt="integer" value="<?=@$obj->_quantidade?>">
                    </dd>

                    <dt>
                        <label>Unidade</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="unidadeid" id="unidadeid" class="texto02" style="display: none;" value="<?=@$obj->_unidade_id?>">
                        <input type="text" name="unidade" id="unidade" class="texto02" value="<?=@$obj->_unidade?>">
                    </dd>

                    <dt>
                        <label>Posologia</label>
                    </dt>
                    <dd>
                        <input type="text" name="posologia" id="posologia" class="texto09" value="<?=@$obj->_posologia?>">
                    </dd>

                    <dt>
                        <label>R. Especial ?</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="r_especial" id="r_especial" <?if(@$obj->_r_especial == 't'){ echo 'checked';}?>>
                    </dd>


                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(document).ready(function () {
        $(function () {
            $("#unidade").autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicamentounidade",
                minLength: 1,
                focus: function (event, ui) {
                    $("#unidade").val(ui.item.label);
                    return false;
                },
                select: function (event, ui) {
                    $("#unidadeid").val(ui.item.id);
                    $("#unidade").val(ui.item.value);
                    return false;
                }
            });
        });

        jQuery('#form_novomedicamento').validate({
            rules: {
                txtmedicamento: {
                    required: true,
                    minlength: 3
                } 
            },
            messages: {
                txtmedicamento: {
                    required: "*",
                    minlength: "!"
                } 
            }
        });
    });

</script>