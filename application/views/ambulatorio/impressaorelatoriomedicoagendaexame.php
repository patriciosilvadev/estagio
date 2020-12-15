
<meta charset="utf-8">

<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Agenda Consultas</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    
    <h4>Medico: <?= (count(@$medico) > 0) ? $medico[0]->operador : 'Todos'; ?></h4>
    <h4>Sala: <?= (count(@$salas) > 0) ? $salas[0]->nome : 'Todos'; ?></h4>

    <?
    @$empresa_id = $this->session->userdata('empresa_id');
    @$data['retorno'] = $this->exame->permisoesempresa($empresa_id);
    @$agenda_modificada = $data['retorno'][0]->agenda_modificada;
    // var_dump($agenda_modificada); die;
    ?>
    <hr>
    <table border="1">
        <thead>
            <tr>
             <?
                if (@$agenda_modificada == 't') {
                    ?>

                    <th class="tabela_header" width="20px;">Nº</th>
                    <?
                } else {
                    ?>
                    <th class="tabela_header" width="70px;">Status</th>

                    <?
                }
                ?>
                <th class="tabela_header" width="250px;">Nome</th>
                <th class="tabela_header" width="70px;">Resp.</th>
                
             <?
        if (@$data['retorno'][0]->agenda_modificada == 't') {
            
        } else {
            ?>
            <? if ($_POST['procedimento'] == 'SIM') { ?>
                <th class="tabela_header" width="150px;">Procedimentos</th>
                <? } ?>



            <?
        }
        ?>
                
                
                
                <th class="tabela_header" width="70px;">Data</th>
             <?
                if (@$agenda_modificada == 't') {
                    
                } else {
                    ?>
                    <th class="tabela_header" width="70px;">Dia</th>

                    <?
                }
                ?>

                   <?
                if (@$data['retorno'][0]->agenda_modificada == 't') {
                    ?>

                    <th class="tabela_header" width="70px;">Horário</th>
                    <?
                } else {
                    ?>
                    <th class="tabela_header" width="70px;">Agenda</th>   

                    <?
                }
                ?>
                <th class="tabela_header" width="150px;">Medico</th>
                <th class="tabela_header" width="150px;">Convenio</th>
                <th class="tabela_header">Telefone</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $paciente = "";
            $contador = 0;
            if (count($relatorio) > 0) {
                foreach ($relatorio as $item) {
                    $dataFuturo = date("Y-m-d H:i:s");
                    $dataAtual = $item->data_atualizacao;

                    if ($item->celular != "") {
                        $telefone = $item->celular;
                    } elseif ($item->telefone != "") {
                        $telefone = $item->telefone;
                    } else {
                        $telefone = "";
                    }

                    $date_time = new DateTime($dataAtual);
                    $diff = $date_time->diff(new DateTime($dataFuturo));
                    $teste = $diff->format('%H:%I:%S');

                    if ($item->paciente == "" && $item->bloqueado == 't') {
                        $situacao = "Bloqueado";
                        $paciente = "Bloqueado";
                        $verifica = 5;
                    } else {
                        $paciente = "";

                        if ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') {
                            $situacao = "Aguardando";
                            $verifica = 2;
                        } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                            $situacao = "Finalizado";
                            $verifica = 4;
                        } elseif ($item->confirmado == 'f') {
                            $situacao = "agenda";
                            $verifica = 1;
                        } else {
                            $situacao = "espera";
                            $verifica = 3;
                        }
                    }
                    if ($item->paciente == "" && $item->bloqueado == 'f') {
                        $paciente = "vago";
                    }
                    $data = $item->data;
                    $dia = strftime("%A", strtotime($data));

                    switch ($dia) {
                        case"Sunday": $dia = "Domingo";
                            break;
                        case"Monday": $dia = "Segunda";
                            break;
                        case"Tuesday": $dia = "Terça";
                            break;
                        case"Wednesday": $dia = "Quarta";
                            break;
                        case"Thursday": $dia = "Quinta";
                            break;
                        case"Friday": $dia = "Sexta";
                            break;
                        case"Saturday": $dia = "Sabado";
                            break;
                    }
                    ?>
                    <tr>
                        <td ><b>   <?
                                if (@$agenda_modificada == 't') {
                                    echo @$numero = 1 + $numero;
                                } else {
                                    echo @$situacao;
                                }
                                ?>
                            </b></td>
                        
                        
                        
                        
                        
                        
                        
                        
                        <? if ($item->paciente != '') { ?>
                        <td <b><?= ($item->paciente); ?></b></td>
                        <? 
                        $contador++;
                        } else { ?>
                            <td >&nbsp;</td>
                        <? } ?>
                        <? if ($item->secretaria != '') { ?>
                            <td ><?= substr($item->secretaria, 0, 9); ?></td>
                        <? } else { ?>
                            <td >&nbsp;</td>
                        <? } ?>
                        <?if($_POST['procedimento'] == 'SIM'){?>
                              
                        <?
                        if (@$agenda_modificada == 't') {
                            
                        } else {
                            ?>      
                            <? if ($_POST['procedimento'] == 'SIM') {
                                ?>

 
                                <td ><?=$item->procedimento; ?></td>  


                                <?
                            }
                        }
                        ?>
                        
                        
                        
                        <?}?>
                        <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
 <?
                        if (@$agenda_modificada == 't') {
                            
                        } else {
                            ?>


                            <?
                            echo "<td>";



                            echo substr($dia, 0, 3);

                            echo " </td>";
                        }
                        ?>  
                        
                        
                        
                        
                        
                        
                        <td ><?= $item->inicio; ?></td>
                        <td  width="150px;">
                            <?
                             if (@$agenda_modificada == 't') {
                                
                            } else {
                                if ($_POST['sala'] == 'SIM') {
                                    echo $item->sala . " - ";
                                }
                            }
                            
                            
                            echo substr($item->medicoagenda, 0, 15);
                            
                            
                            ?></td>
                        <? if ($item->convenio != '') { ?>
                            <td ><?= ($item->convenio); ?></td>
                        <? } else { ?>
                            <td >&nbsp;</td>
                        <? } ?>
                        <? if ($telefone != '') { ?>
                            <td ><?= $telefone; ?></td>
                        <? } else { ?>
                            <td >&nbsp;</td>
                        <? } ?>

                    </tr>

                </tbody>
                <?php
            }
        }
        ?>

    </table>
     <h4>Total de exames marcados <?= $contador; ?></h4>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>
