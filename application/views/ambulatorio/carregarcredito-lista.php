<?
$perfil_id = $this->session->userdata('perfil_id');
?>
<div class="content  " > <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/exametemp/carregarcredito/<?= $paciente_id ?>">
            Novo Crédito
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Crédito</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/exametemp/listarcredito/<?= $paciente_id ?>">
                                <tr>
                                    <th class="tabela_title">Procedimento</th>
                                    <th class="tabela_title">Convênio</th>
                                    <th class="tabela_title"></th>
                                </tr>
                                <tr>
                                    <th class="tabela_title">
                                        <input type="text" name="procedimento" value="<?php echo @$_GET['procedimento']; ?>" />
                                    </th>
                                    <th class="tabela_title">
                                        <input type="text" name="convenio" value="<?php echo @$_GET['convenio']; ?>" />
                                    </th>
                                    <th class="tabela_title">
                                        <button type="submit" id="enviar">Pesquisar</button>
                                    </th>
                                </tr>
                            </form>
            </table>
            <table>
                <tr>
                    <th class="tabela_header">Paciente</th>
                    <th class="tabela_header">Data</th>

                    <? if (@$permissoes[0]->associa_credito_procedimento == 't') { ?>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Convênio</th>
                    <? } ?>

                    <th class="tabela_header">Valor (R$)</th>
                    <th class="tabela_header">Transferência</th>
                    <th class="tabela_header">Observação</th>
                    <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exametemp->listarcredito($paciente_id);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->exametemp->listarcredito($paciente_id)->orderby('pt.nome, c.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)); ?></td>

                                <? if (@$permissoes[0]->associa_credito_procedimento == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ",", ""); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= (@$item->paciente_transferencia != '') ? @$item->paciente_transferencia : ''; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= @$item->observacaocredito; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exametemp/gerarecibocredito/<?= $item->paciente_credito_id ?>/<?= $paciente_id ?>">Recibo</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exametemp/trasnferircredito/<?= $item->paciente_credito_id ?>/<?= $paciente_id ?>">Transferir</a></div>
                                </td>
                                <?// $gerente_recepcao_top_saude = $this->session->userdata('gerente_recepcao_top_saude'); ?>
                                <? if ($perfil_id == 1 || ($gerente_recepcao_top_saude && $perfil_id == 5)) { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                            <a onclick="confirmarEstorno(<?= $item->paciente_credito_id ?>,<?= $paciente_id ?>)" href="#">Estornar</a></div>
                                    </td>    
                                <? } ?>
                                <!--
                                <? if ($item->faturado == 'f') { ?>
                                                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                                                        <a target="_blank" href="<?= base_url() ?>ambulatorio/exametemp/faturarcreditos/<?= $item->paciente_credito_id ?>/<?= $paciente_id ?>">Faturar</a></div>
                                                                </td>   
                                <? } else { ?>
                                                                <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                                                        Faturado
                                                                </td>  

                                <? } ?>
                                -->

                            </tr>
                        <? } ?>
                        <tr id="tot">
                            <td class="<?php echo $estilo_linha; ?>" id="textovalortotal" colspan="4">
                                <span id="spantotal"> Saldo:</span> 
                            </td>
                            <td class="<?php echo $estilo_linha; ?>" colspan="3">
                                <span id="spantotal">
                                    R$ <?= number_format($valortotal[0]->saldo, 2, ',', '') ?>
                                </span>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>" id="textovalortotal" colspan="3">
                                <!--                                <div class="bt_link" style="float: right">
                                                                    <a href="<?= base_url() ?>ambulatorio/exametemp/gerasaldocredito/<?= $paciente_id ?>">Saldo</a>
                                                                </div>-->
                            </td>
                        </tr>

                    </tbody>
                <? } ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="10">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>


            <?php
            $creditosusados = $this->exametemp->listarcreditosusados($paciente_id)->orderby('pt.nome, c.nome')->limit($limit, $pagina)->get()->result();
            $totalusados = count($creditosusados);
            $estilo_linha2 = "tabela_content01"; 
            if ($totalusados > 0) {
                ?>
                <br>
                <hr>

                <fieldset style="border:1px solid silver;border-radius: 3px;" >
                    <h1 style="font-size:15px;">Histórico Créditos Utilizados</h1> 
                    <table style="margin:7px;">
                        <tr>
                            <th class="tabela_header">Paciente</th>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">Valor</th>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Operador</th>                    
                        </tr>

                        <?php
                        foreach ($creditosusados as $item) {
                            ($estilo_linha2 == "tabela_content01") ? $estilo_linha2 = "tabela_content02" : $estilo_linha2 = "tabela_content01";
                            @$totalusadocredito += ($item->valor * -1);
                            ?>

                            <tr>
                                <td class="<?php echo @$estilo_linha2; ?>"> <?= @$item->paciente; ?></td>
                                <td class="<?php echo @$estilo_linha2; ?>"><?= @$item->procedimento; ?></td>
                                <td class="<?php echo @$estilo_linha2; ?>"><?= number_format($item->valor * -1, 2, ",", ""); ?></td>
                                <td class="<?php echo @$estilo_linha2; ?>"><?= date("d/m/Y", strtotime($item->data_cadastro)); ?></td>
                                <td class="<?php echo @$estilo_linha2; ?>"><?= $item->operador_cadastro; ?></td>

                            </tr>

                            <?
                        }
                        ?>

                        <tr id="tot">
                            <td class="<?php echo @$estilo_linha2; ?>" id="textovalortotal" colspan="4">
                                <span id="spantotal"> Total de Crédito utilizado.:</span> 
                            </td>
                            <td class="<?php echo @$estilo_linha2; ?>" colspan="3">
                                <span id="spantotal">
                                    R$ <?= number_format(@$totalusadocredito, 2, ',', '') ?>
                                </span>
                            </td>
                            <td class="<?php echo @$estilo_linha2; ?>" id="textovalortotal" colspan="3">
                                <!--                                <div class="bt_link" style="float: right">
                                                                    <a href="<?= base_url() ?>ambulatorio/exametemp/gerasaldocredito/<?= $paciente_id ?>">Saldo</a>
                                                                </div>-->
                            </td>
                        </tr>

                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="10">
                                    <?php 
//                                    $this->utilitario->paginacao($url, $totalusados, $pagina, $limit); 
                                    ?>
                                    Total de registros: <?php echo $totalusados; ?>
                                </th>
                            </tr>
                        </tfoot>  
                    </table>
                </fieldset>
                <?php
            }
            ?>
        </div>



    </div>

</div> <!-- Final da DIV content -->


<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    function confirmarEstorno(credito_id, paciente_id) {
//        alert('<?= base_url() ?>ambulatorio/exametemp/excluircredito/'+credito_id+'/'+paciente_id+'?justificativa=');
        var resposta = prompt("Informe o motivo do estorno.");
        if (resposta == null || resposta == "") {
            return false;
        } else {
            window.open('<?= base_url() ?>ambulatorio/exametemp/excluircredito/' + credito_id + '/' + paciente_id + '?justificativa=' + resposta, '_self');
//            alert(resposta);
        }
    }
</script>
<style>
    #spantotal{

        color: black;
        font-weight: bolder;
        font-size: 18px;
    }
    #textovalortotal{
        text-align: right;
    }
    #tot td{
        background-color: #bdc3c7;
    }

    #form_solicitacaoitens div{
        margin: 3pt;
    }
</style>