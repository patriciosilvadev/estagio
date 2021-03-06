<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Nova Solicitação</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarnovasolicitacao" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Convenio *</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="texto04" required>
                            <option value="">Selecione</option>
                            <? foreach ($convenio as $value) { ?>
                                <option value="<?= $value->convenio_id; ?>"><?= $value->nome; ?></option>
                            <? } ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Paciente *</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="ambulatorio_laudo_id" id="ambulatorio_laudo_id" class="texto02" value="<?= @$laudo_id; ?>"/>
                        <input type="hidden" name="txtNomeid" id="txtNomeid" class="texto02" value="<?= @$laudo[0]->paciente_id; ?>"/>
                        <input type="text" name="txtNome" id="txtNome" class="texto10" value="<?= @$laudo[0]->nome; ?>"/>
                    </dd>
                    
                    <dt>
                        <label>Telefone</label>
                    </dt>
                    <dd>                       
                        <input type="text" name="telefone" id="telefone" class="texto04" value=""/>
                    </dd>
                    <? // var_dump($expression);die;?>
                    <dt>
                        <label>Idade</label>
                    </dt>
                    <dd>                        
                        <input type="text" name="idade" id="idade" class="texto02" value=""/>
                    </dd>

                    <dt>
                        <label>Médico Solicitante </label>
                    </dt>
                    <dd>
                        <select  name="medicoagenda" id="medicoagenda" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($medicos as $item) : ?>
                                <option value="<?= $item->operador_id; ?>" <?= ( @$laudo[0]->medico_parecer1 == $item->operador_id ) ? 'selected' : '' ?>>
                                    <?= $item->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Médico Cirurgião </label>
                    </dt>
                    <dd>
                        <select  name="medicocirurgia" id="medicocirurgia" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($medicos as $item) : ?>
                                <option value="<?= $item->operador_id; ?>" <?= ( @$laudo[0]->medico_parecer1 == $item->operador_id ) ? 'selected' : '' ?>>
                                    <?= $item->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Sala</label>
                    </dt>
                    <dd>
                        <select  name="sala" id="sala" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($salas as $item) : ?>
                                <option value="<?= $item->exame_sala_id; ?>" <?= ( @$laudo[0]->sala_agendada == $item->exame_sala_id ) ? 'selected' : '' ?>>
                                    <?= $item->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Data da Cirurgia *</label>
                    </dt>
                    <dd>
                        <input type="text" name="data_prevista" id="data_prevista" class="texto02" value="" required=""/>
                    </dd>
                    <dt>
                        <label>Hora de Inicio *</label>
                    </dt>
                    <dd>
                        <input type="text" name="hora_inicio" alt="99:99" id="hora_inicio" class="texto02" required value=""/>
                    </dd>
                    <dt>
                        <label>Hora de fim *</label>
                    </dt>
                    <dd>
                        <input type="text" name="hora_fim" alt="99:99" id="hora_fim" class="texto02" required value=""/>
                    </dd>

                    <dt>
                        <label>Hospital *</label>
                    </dt>
                    <dd>
                        <select name="hospital_id" id="hospital_id" class="size2"  required="">
                            <option value="">Selecione</option>
                            <? foreach (@$hospitais as $item) : 
                                $selected = '';
                                if(count($hospitais) == 1){
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?= $item->hospital_id; ?>" <?=$selected?>><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>

                    <dt>
                        <label>Leito *</label>
                    </dt>
                    <dd>
                        <div>
                            <input type="radio" name="leito" id="enf" value="ENFERMARIA" required/> <label for="enf">Enfermaria</label>
                            <input type="radio" name="leito" id="apt" value="APARTAMENTO" required/> <label for="apt">Apartamento</label>
                        </div>
                    </dd>
                    <dt>
                        <label>Pós-Operatório *</label>
                    </dt>
                    <dd>
                        <div>
                            <input type="radio" name="operatorio" id="enf" value="PQA" required/> <label for="enf">PQA</label>
                            <input type="radio" name="operatorio" id="apt" value="INTERNACAO" required/> <label for="apt">Internação</label>
                        </div>
                    </dd>



                    <dt>
                        <label for="orcamento">Orçamento</label>
                    </dt>
                    <dd>
                        <input type="checkbox" id="orcamento" name="orcamento"/>
                    </dd>
                    
                    <dt>
                        <label>Observação</label>
                    </dt>
                    <dd style="height: 130px;">
                        <textarea  cols="" rows="8" name="observacao" class="texto_area"></textarea>
                        
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">


    jQuery("#telefone")
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
        $("#accordion").accordion();
    });


    $(function () {
        $("#data_prevista").datepicker({
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
        $("#procedimento").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentoconveniocirurgia",
            minLength: 3,
            focus: function (event, ui) {
                $("#procedimento").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#procedimento").val(ui.item.value);
                $("#procedimentoID").val(ui.item.id);
                return false;
            }
        });
    });


    $(function () {
        $("#txtNome").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 10,
            focus: function (event, ui) {
                $("#txtNome").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                if (ui.item.leito == 'ENFERMARIA') {
                    $("#enf").attr('checked', true);
                    $("#apt").attr('checked', false);
                } else if (ui.item.leito == 'APARTAMENTO') {
                    $("#apt").attr('checked', true);
                    $("#enf").attr('checked', false);
                }

                return false;
            }
        });
    });


    $(document).ready(function () {
        jQuery('#form_sala').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
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
    
//    $(function () {
                        $('#txtNome').blur(function () {
                            if ($(this).val()) {

                                $.getJSON('<?= base_url() ?>autocomplete/pacientesinternacao', {paciente_id: $('#txtNomeid').val()}, function (j) {
//                            console.log(j[1]);
                               
                                    telefone = j[0];// 
                                    idade = j[1];
                                    if ($('#txtNomeid').val() == "") {
                                        telefone = ""; 
                                        idade = "";
                                    }                             
                                    $('#telefone').val(telefone);  
                                    $('.carregando').hide();  
                                    $('#idade').val(idade); 
                                    
//                                    
                                });

                            } 
                        });
//                    });

</script>
