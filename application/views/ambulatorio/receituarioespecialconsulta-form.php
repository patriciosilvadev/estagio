<head>
    <title>Receituário Especial</title>
</head>
<div >
    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');


    if (count($receita) == 0) {
        $receituario_id = 0;
        $texto = "";
        $medico = "";
    } else {
        $texto = $receita[0]->texto;
        $receituario_id = $receita[0]->ambulatorio_receituario_especial_id;
        $medico = $receita[0]->medico_parecer1;
    }
    $operador_id = $this->session->userdata('operador_id');
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarreceituarioespecial/<?= $ambulatorio_laudo_id ?>" method="post">
            <div >
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr><td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>
                            <td>Solicitante: <?= @$obj->_solicitante ?></td>
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                            <td>Sala:<?= @$obj->_sala ?></td>
                        </tr>
                    </table>

                </fieldset>
                <table>
                    <tr>
                        <td>
                            <div class="bt_link_new" style="width: 200px; margin: 5px">
                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/modeloreceitaespecial');" style="width: 200px; margin: 5px">
                                    M. Receituario Especial</a></div>
                        </td>
                        <td>
                            <div class="bt_link_new" style="width: 200px; margin: 5px">
                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/modelomedicamento');" style="width: 250px; margin: 5px">
                                    Modelo Medicamento</a></div>
                        </td>
                    </tr>
                </table> 
                <div>
                    <div>
                        <div> 
                            <fieldset>
                                <legend>Receituario Especial</legend>
                                <div>
                                    <label>Modelos</label>
                                    <select name="exame" id="exame" class="size2" >
                                        <option value='' >selecione</option>
                                        <?php foreach ($lista as $item) { ?>
                                            <option value="<?php echo $item->ambulatorio_modelo_receita_especial_id; ?>" ><?php echo $item->nome; ?></option>
                                        <?php } ?>
                                    </select>  
                                    <label>Medicamento</label>
                                    <input type="text" id="medicamento" class="texto02" name="medicamento"/> 
                                    <label>Carimbo</label>
                                    <input type="checkbox" id="carimbo"  name="carimbo"/> 
                                    <label>Assinatura</label>
                                    <input type="checkbox" id="assinatura" name="assinatura"/>
                                </div>
                                <div>
                                    <input type="hidden" id="receituario_id" name="receituario_id" value="<?= $receituario_id ?>"/>
                                    <input type="hidden" id="ambulatorio_laudo_id" name="ambulatorio_laudo_id" value="<?= $ambulatorio_laudo_id ?>"/>
                                    <input type="hidden" id="medico" name="medico" value="<?= $operador_id ?>"/>
                                </div>
                                <div>
                                    <textarea id="laudo" name="laudo" rows="20" cols="80" style="width: 80%"></textarea></td>
                                </div> 
                                <hr>
                                <button type="submit" name="btnEnviar">Salvar</button>
                            </fieldset>
                            </form> 
                        </div> 
                    </div> 
                </div> 
                <?if (count($receita) > 0) {
                    ?>
                    <table id="table_agente_toxico" border="0">
                        <thead>
                            <tr>
                                <th class="tabela_header">Data</th>
                                <th class="tabela_header">Descri&ccedil;&atilde;o</th>
                                <th colspan="2" class="tabela_header">&nbsp;</th>
                            </tr>
                        </thead>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($receita as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data_cadastro)); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->texto; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoreceitaespecial/<?= $item->ambulatorio_receituario_especial_id; ?>');">Imprimir
                                            </a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/editarcarregarreceituarioespecial/<?= $ambulatorio_laudo_id ?>/<?= $item->ambulatorio_receituario_especial_id; ?>');">Editar
                                            </a></div>
                                    </td>

                                </tr>

                            </tbody>
                            <?
                        }
                    }
                    ?>

                </table> 

                </fieldset>

            </div> 
    </div> 
</div> <!-- Final da DIV content -->
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 1300px; }
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
</style>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce2/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui.js" ></script>

<script type="text/javascript">




                                        // NOVO TINYMCE
                                        tinymce.init({
                                            selector: "#laudo",
                                            setup : function(ed)
                                            {
                                                ed.on('init', function() 
                                                {
                                                    this.getDoc().body.style.fontSize = '12pt';
                                                    this.getDoc().body.style.fontFamily = 'Arial';
                                                });
                                            },
                                            theme: "modern",
                                            skin: "custom",
                                            language: 'pt_BR',
                                            
                                            // forced_root_block : '',
                                            <?if(@$empresa[0]->impressao_laudo == 33){?>
                                                forced_root_block : '',
                                            <?}?>
                                        //                                                            browser_spellcheck : true,
                                        //                                                            external_plugins: {"nanospell": "<?= base_url() ?>js/tinymce2/nanospell/plugin.js"},
                                        //                                                            nanospell_server: "php",
                                        //                                                            nanospell_dictionary: "pt_br" ,
                                            height: 450,
                                            
                                            plugins: [
                                                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
                                                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking help",
                                                "table directionality emoticons template textcolor paste fullpage colorpicker spellchecker"
                                            ],

                                            toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
                                            toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor | table | removeformat",
                                            toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft help",

                                            menubar: false,
                                            toolbar_items_size: 'small',

                                            style_formats: [{
                                                    title: 'Bold text',
                                                    inline: 'b'
                                                }, {
                                                    title: 'Red text',
                                                    inline: 'span',
                                                    styles: {
                                                        color: '#ff0000'
                                                    }
                                                }, {
                                                    title: 'Red header',
                                                    block: 'h1',
                                                    styles: {
                                                        color: '#ff0000'
                                                    }
                                                }, {
                                                    title: 'Example 1',
                                                    inline: 'span',
                                                    classes: 'example1'
                                                }, {
                                                    title: 'Example 2',
                                                    inline: 'span',
                                                    classes: 'example2'
                                                }, {
                                                    title: 'Table styles'
                                                }, {
                                                    title: 'Table row 1',
                                                    selector: 'tr',
                                                    classes: 'tablerow1'
                                                }],
                                                fontsize_formats: 'xx-small x-small 8pt 10pt 12pt 14pt 18pt 24pt 36pt 48pt',    

                                                templates: [{
                                                        title: 'Test template 1',
                                                        content: 'Test 1'
                                                    }, {
                                                        title: 'Test template 2',
                                                        content: 'Test 2'
                                                    }],

                                            init_instance_callback: function () {
                                                window.setTimeout(function () {
                                                    $("#div").show();
                                                }, 1000);
                                            }
                                        });

                                        $(function () {
                                            $('#exame').change(function () {
                                                if ($(this).val()) {
                                                    //$('#laudo').hide();
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/modelosreceitaespecial', {exame: $(this).val(), ajax: true}, function (j) {
                                                        options = "";

                                                        options += j[0].texto;
                                                        //                                                document.getElementById("laudo").value = options

                                                        $('#laudo').val(options)
                                                        var ed = tinyMCE.get('laudo');
                                                        ed.setContent($('#laudo').val());

                                                        //$('#laudo').val(options);
                                                        //$('#laudo').html(options).show();
                                                        //                                                $('.carregando').hide();
                                                        //history.go(0) 
                                                    });
                                                } else {
                                                    $('#laudo').html('value=""');
                                                }
                                            });
                                        });

                                        $(function () {
                                            $('#linha').change(function () {
                                                if ($(this).val()) {
                                                    //$('#laudo').hide();
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/modeloslinhas', {linha: $(this).val(), ajax: true}, function (j) {
                                                        options = "";

                                                        options += j[0].texto;
                                                        //                                                document.getElementById("laudo").value = $('#laudo').val() + options
                                                        $('#laudo').val() + options
                                                        var ed = tinyMCE.get('laudo');
                                                        ed.setContent($('#laudo').val());
                                                        //$('#laudo').html(options).show();
                                                    });
                                                } else {
                                                    $('#laudo').html('value=""');
                                                }
                                            });
                                        });

                                        $(function () {
                                            $("#medicamento").autocomplete({
                                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicamentolaudo",
                                                minLength: 1,
                                                focus: function (event, ui) {
                                                    $("#medicamento").val(ui.item.label);
                                                    return false;
                                                },
                                                select: function (event, ui) {
                                                  var texto_antigo2 = tinyMCE.get('laudo').getContent();
                                                  var texto_adicional_html2 = "</html>";
                                                  var texto_adicional_body2 = "</body>";
                                                   //aqui ele tira todas as tags html e body
                                                  texto_antigo2 = texto_antigo2.replace(texto_adicional_html2, "");
                                                  texto_antigo2 = texto_antigo2.replace(texto_adicional_body2, "");
                                                     //pegando o texto antigo do textarea e somando com o texto buscado ao selecionar
                                                   var colocartexto = texto_antigo2 + ui.item.id;
                                                   var ed = tinyMCE.get('laudo');
                                                   ed.setContent(colocartexto); 
                                                   $("#medicamento").val("");  
                                                    return false;
                                                }
                                            });
                                        });

                                        $(function () {
                                            $("#linha2").autocomplete({
                                                source: "<?= base_url() ?>index.php?c=autocomplete&m=linhas",
                                                minLength: 1,
                                                focus: function (event, ui) {
                                                    $("#linha2").val(ui.item.label);
                                                    return false;
                                                },
                                                select: function (event, ui) {
                                                    $("#linha2").val(ui.item.value);
                                                    tinyMCE.triggerSave(true, true);
                                                    document.getElementById("laudo").value = $('#laudo').val() + ui.item.id
                                                    $('#laudo').val() + ui.item.id
                                                    var ed = tinyMCE.get('laudo');
                                                    ed.setContent($('#laudo').val());
                                                    //$( "#laudo" ).val() + ui.item.id;
                                                    document.getElementById("linha2").value = ''
                                                    return false;
                                                }
                                            });
                                        });

                                        $(function (a) {
                                            $('#anteriores').change(function () {
                                                if ($(this).val()) {
                                                    //$('#laudo').hide();
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/laudosanteriores', {anteriores: $(this).val(), ajax: true}, function (i) {
                                                        option = "";

                                                        option = i[0].texto;
                                                        tinyMCE.triggerSave();
                                                        document.getElementById("laudo").value = option
                                                        //$('#laudo').val(options);
                                                        //$('#laudo').html(options).show();
                                                        $('.carregando').hide();
                                                        history.go(0)
                                                    });
                                                } else {
                                                    $('#laudo').html('value="texto"');
                                                }
                                            });
                                        });
                                        //bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
                                        $('.jqte-test').jqte();








</script>
