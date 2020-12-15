

<html>
    <div class="content"> <!-- Inicio da DIV content -->

        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <table>
            <thead>

                <? if (count($empresa) > 0) { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                    </tr>
                <? } else { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                    </tr>
                <? } ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONFERENCIA DOS CONVENIOS</th>
                </tr>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
                </tr>
                <? if (isset($_POST['filtro_hora'])) { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">DE <?= $_POST['horario_inicio']; ?>hrs as <?= $_POST['horario_fim']; ?>hrs</th>
                    </tr>
                <? } ?>
                <? if (count(@$_POST['grupo']) == 0 || in_array('0', @$_POST['grupo'])) { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                    </tr>
                <? } else { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: 
                            <?
                            foreach ($_POST['grupo'] as $item) {
                                if ($item == '1') {
                                    echo 'SEM RM/TOMOGRAFIA' . ', ';
                                } else {
                                    echo $item . ', ';
                                }
                            }
                            ?></th>
                    </tr>
                <? } ?>
                <? if ($procedimentos == "0") { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PROCEDIMENTO: TODOS</th>
                    </tr>
                <? } else { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PROCEDIMENTO: <?= $procedimentos[0]->nome; ?></th>
                    </tr>
                <? } ?>



                <? if ($medico == "0") { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: TODOS</th>
                    </tr>
                <? } else { ?>

                    <?
                    foreach ($medico as $item) {
                        $medicos_array[] = $item->operador;
                    }
                    $medicos = array_unique($medicos_array);
                    $medicos = implode(', ', $medicos);
//                $medicos = $medico;
//                var_dump($medicos);
//                die;
                    ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: <?= $medicos; ?></th>
                    </tr>
                <? } ?>
                <? if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PACIENTE: <?= $_POST['nome'] ?></th>
                    </tr>
                <? } ?>
                <? if ($convenio == "0") { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS CONVENIOS</th>
                    </tr>
                <? } elseif ($convenio == "-1") { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PARTICULARES</th>
                    </tr>
                <? } elseif ($convenio == "") { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIOS</th>
                    </tr>
                <? } else { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= $convenios[0]->nome; ?></th>
                    </tr>
                <? } ?>

                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="8">&nbsp;</th>
                </tr>
                <? if (count($relatorio) > 0) {
                    ?>
                    <tr>
                        <th class="tabela_teste" width="80px;">Atend.</th>
                        <th class="tabela_teste" >Emissao</th>
                        <th class="tabela_teste" width="350px;">Paciente</th>
                        <th class="tabela_teste" >Autorizacao</th>
                        <? if ($_POST['mostrar_medico'] == 'SIM') { ?>
                            <th class="tabela_teste" >Médico</th>
                        <? } ?>
                        <th class="tabela_teste" >Procedimentos</th>
                        <th class="tabela_teste" >Codigo</th>
                        <th class="tabela_teste" >QTDE</th>
                        <? if ($_POST['aparecervalor'] == '1') { ?>
                            <th class="tabela_teste" width="80px;">V. UNIT</th>
                            <th class="tabela_teste" width="80px;">V. Total</th>
                            <th class="tabela_teste" width="80px;">Total Geral</th>                        
                        <? }
                        ?> 
                    </tr>
                    <tr>
                        <th style='width:10pt;border:solid windowtext 1.0pt;
                            border-bottom:none;mso-border-top-alt:none;border-left:
                            none;border-right:none;' colspan="8">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $i = 0;
                    $qtde = 0;
                    $qtdetotal = 0;
                    $valor = 0;
                    $valortotal = 0;
                    $medicamento = 0;
                    $convenio = "";
                    $paciente = "";
                    $totalpaciente = 0;
                    $maximo = 0;
                    $contadorpaciente = "";
                    $contadorpacientetotal = "";
                    $guia_id = '';
                    $grupos = array();
                    $valor_previsto = 0;
                    foreach ($relatorio as $key => $value) {
                        $maximo = $key;
                    }
//                 echo "<pre>";print_r($relatorio);die;
                    foreach ($relatorio as $item) :
                        $p = $i + 1;
                        if ($item->grupo == 'MEDICAMENTO' || $item->grupo == 'MATERIAL') {
                            $medicamento = $medicamento + $item->quantidade;
                        }
                        $i++;
                        if ($p > $maximo) {
                            $p = $maximo;
                        }
                        if (!array_key_exists($item->grupo, $grupos)) {
                            $grupos[$item->grupo] = 1;
                        } else {
                            $grupos[$item->grupo] += $item->quantidade;
                        }
                        if ($item->numero_sessao > 1 && $item->dinheiro == 't') {
                            $item->valor1 = 0;
                            $item->valor2 = 0;
                            $item->valor3 = 0;
                            $item->valor4 = 0;
                            $item->valor = 0;
                            $item->valor_total = 0;
                        }
//                        $totalpaciente = $totalpaciente + $item->valor_total;

//                        if ($item->valor1 != 0 || $item->valor2 != 0 || $item->valor3 != 0 || $item->valor4 != 0) {
//                           $totalpaciente += $item->valor1 + $item->valor2 + $item->valor3 + $item->valor3;
//                        } else {
//                            $totalpaciente += $item->valor * $item->quantidade;
//                        }
                          $totalpaciente = $totalpaciente + $item->valor_total;
 
                        if ($i == 1 || $item->convenio == $convenio) {

                            $valortotal = $valortotal + ($item->valor * $item->quantidade);
                            $valor = $valor + ($item->valor * $item->quantidade);

                            $qtde += $item->quantidade;
                            $qtdetotal = $qtdetotal + $item->quantidade;

                            if ($i == 1) {
                                ?>
                                <tr>
                                    <td colspan="8"><font ><b>Convenio:&nbsp;<?= $item->convenio; ?></b></td>
                                </tr>
                            <? } ?>
                            <tr>

                                <? if ($paciente == $item->paciente) { ?>

                                    <? if ($guia_id == $item->guia_id) { ?>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    <? } else { ?>
                                        <td><?= $item->guia_id; ?></td>
                                        <td>
                                            <?
                                            if ($item->data_antiga != "")
                                                echo " ** ";

                                            if (isset($_POST['filtro_hora'])) {
                                                echo date("d/m/Y H:i", strtotime($item->data . " " . $item->inicio));
                                            } else {
                                                echo date("d/m/Y", strtotime($item->data));
                                            }

                                            if ($item->data_antiga != "")
                                                echo " ** ";
                                            ?>
                                        </td>
                                    <? } ?>   


                                    <td>&nbsp;</td>
                                <? } else { ?>
                                    <td><?= $item->guia_id; ?></td>
                                    <td>
                                        <?
                                        if ($item->data_antiga != "")
                                            echo " ** ";

                                        if (isset($_POST['filtro_hora'])) {
                                            echo date("d/m/Y H:i", strtotime($item->data . " " . $item->inicio));
                                        } else {
                                            echo date("d/m/Y", strtotime($item->data));
                                        }

                                        if ($item->data_antiga != "")
                                            echo " ** ";
                                        ?>
                                    </td>
                                    <td><?= $item->paciente; ?></td>
                                    <?
                                    $contadorpaciente++;
                                    $contadorpacientetotal++;
                                }
                                ?>
                                <td><?= $item->autorizacao; ?></td>
                                <? if ($_POST['mostrar_medico'] == 'SIM') { ?>
                                    <td><?= $item->medico; ?></td>
                                <? } ?>
                                <td><?= $item->exame; ?></td>
                                <td><?= $item->codigo; ?></td>
                                <td><?= $item->quantidade; ?></td>
                                <? if ($_POST['aparecervalor'] == '1') { ?>
                                    <td ><?= number_format($item->valor, 2, ',', '.') ?></td>
                                    <td <? if ($item->ajuste_cbhpm == 't' && $item->valor != $item->valor_total) { ?>style="color: blue;" title="Ajustado" <? } ?>>
                                        <?                                      
                                        if ($item->numero_sessao > 1 && $item->dinheiro == 't') {
                                            $item->valor1 = 0;
                                            $item->valor2 = 0;
                                            $item->valor3 = 0;
                                            $item->valor4 = 0;
                                            $item->valor = 0;
                                            $item->valor_total = 0;
                                        }     
                                        $valor_previsto = $valor_previsto + $item->valor_total;                                     
//                                        echo $item->valor1 ;
//                                        echo number_format($item->valor_total, 2, ',', '.');                                        
//                                         if ($item->valor1 != 0 || $item->valor2 != 0 || $item->valor3 != 0 || $item->valor4 != 0) {
//                                            $valortotgeral = $item->valor1 + $item->valor2 + $item->valor3 + $item->valor4;
                                            echo number_format($item->valor_total, 2, ',', '.');
//                                        } else {
//                                            echo number_format($item->valor_mais_quantidade, 2, ',', '.');
//                                        }
                                        ?>   

                                    </td>
                                    <? if ($item->paciente != $relatorio[$p]->paciente || $p == $maximo) { ?>
                                        <td><b><?= number_format($totalpaciente, 2, ',', '.') ?></b></td>
                                        <?
                                        $totalpaciente = 0;
                                    } else {
                                        ?>
                                        <td></td>
                                    <? } ?>
                                <? } ?>
                            </tr>


                            <?
                            $paciente = $item->paciente;
                            $convenio = $item->convenio;
                            $guia_id = $item->guia_id;
                        } else {
                            $convenio = $item->convenio;
                            ?>
                            <? if ($_POST['aparecervalor'] == '1') { ?>

                                <tr>
                                    <td width="200px;" align="Right" colspan="9"><b>Valor Previsto <?= number_format($valor_previsto, 2, ',', '.'); ?></b></td>
                                    <? $valor_previsto = 0;?>
                                </tr>
                            <? } ?>
                            <tr>
                                <td width="2000px;" align="Right" colspan="9"><b>Nr. Pacientes: <?= $contadorpaciente; ?></b></td>
                            </tr>
                            <tr>
                                <td width="140px;" align="Right" colspan="9"><b>Nr. Procedimentos: <?= $qtde; ?></b></td>
                            </tr>
                            <? if ($_POST['aparecervalor'] == '1') { ?>
                                <tr>
                                    <td width="140px;" align="Right" colspan="9"><b>Valor do Contrato: </b></td>
                                </tr>
                            <? } ?>
                            <tr>
                                <td width="140px;" align="Right" colspan="9"><b>Valor do Contrato: </b></td>
                            </tr>
                            <?
                            if ($item->numero_sessao > 1 && $item->dinheiro == 't') {
                                $item->valor1 = 0;
                                $item->valor2 = 0;
                                $item->valor3 = 0;
                                $item->valor4 = 0;
                                $item->valor = 0;
                                $item->valor_total = 0;
                            }     
                            
                            $valor_previsto = $valor_previsto + $item->valor_total; 
                            
                            
                            $paciente = "";
                            $guia_id = '';
                            $valor = 0;
                            $qtde = 0;
                            $contadorpaciente = 0;
                            $valortotal = $valortotal + $item->valor * $item->quantidade;


                            $valor = $valor + $item->valor_total;


                            $qtde += $item->quantidade;

                            $qtdetotal = $qtdetotal + $item->quantidade;
                            ?>
                            <tr>
                                <td colspan="8"><font ><b>Convenio:&nbsp;<?= $item->convenio; ?></b></td>
                            </tr>
                            <tr>
                                <? if ($paciente == $item->paciente) { ?>
                                    <? if ($guia_id == $item->guia_id) { ?>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    <? } else { ?>
                                        <td><?= $item->guia_id; ?></td>
                                        <td>
                                            <?
                                            if ($item->data_antiga != "")
                                                echo " ** ";

                                            if (isset($_POST['filtro_hora'])) {
                                                echo date("d/m/Y H:i", strtotime($item->data . " " . $item->inicio));
                                            } else {
                                                echo date("d/m/Y", strtotime($item->data));
                                            }

                                            if ($item->data_antiga != "")
                                                echo " ** ";
                                            ?>
                                        </td>
                                    <? } ?>   

                                    <td>&nbsp;</td>
                                <? } else { ?>
                                    <td><?= $item->guia_id; ?></td>
                                    <td><?
                                        if ($item->data_antiga != "") {
                                            echo " ** ";
                                        }
                                        ?><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?><?
                                        if ($item->data_antiga != "") {
                                            echo " ** ";
                                        }
                                        ?></td>
                                    <td><?= $item->paciente; ?></td>
                                    <?
                                    $contadorpaciente++;
                                    $contadorpacientetotal++;
                                }
                                ?>
                                <td><?= $item->autorizacao; ?></td>
                                <td><?= $item->exame; ?></td>
                                <td><?= $item->codigo; ?></td>
                                <td><?= $item->quantidade; ?></td>
                                <? if ($_POST['aparecervalor'] == '1') { ?> 
                                    <td><?= number_format($item->valortotal, 2, ',', '.') ?></td>
                                    <td><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                                <? } ?>
                                <? if ($item->paciente != $relatorio[$p]->paciente || $p == $maximo) { ?>
                                    <? if ($_POST['aparecervalor'] == '1') { ?>
                                        <td><b><?= number_format($totalpaciente, 2, ',', '.') ?></b></td>
                                    <? } ?>
                                    <?
                                    $totalpaciente = 0;
                                } else {
                                    ?>
                                    <td></td>
                                <? } ?>
                            </tr>
                            <?
                            $guia_id = $item->guia_id;
                            $paciente = $item->paciente;
                        }
                    endforeach;
                    ?>
                    <? if ($_POST['aparecervalor'] == '1') { ?>
                        <tr>
                            <td width="200px;" align="Right" colspan="9"><b>Valor Previsto <?= number_format($valor_previsto, 2, ',', '.'); ?></b></td>
                        </tr>
                    <? } ?>
                    <tr>
                        <td width="2000px;" align="Right" colspan="9"><b>Nr. Pacientes: <?= $contadorpaciente; ?></b></td>
                    </tr>
                    <tr>
                        <td width="140px;" align="Right" colspan="9"><b>Nr. Procedimentos: <?= $qtde; ?></b></td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <?
            $qtdetotal = $qtdetotal - $medicamento;
            ?>
            <style>
                .alignBottom{
                    vertical-align: bottom;
                }
            </style>
            <table >
                <tbody>
                    <tr>
                        <? // echo '<pre>'; var_dump($_POST);die;?>
                        <? if ($_POST['aparecervalor'] == '1') { ?>
                            <td width="140px;" align="Right" class="alignBottom"><b>TOTAL GERAL</b></td>
                        <? } ?>
                        <td width="200px;" align="Right" class="alignBottom"><b>Nr. Pacientes: <?= $contadorpacientetotal; ?></b></td>
                        <td width="250px;" align="Right" >
                            <table>


                                <? foreach ($grupos as $key => $value) { ?>

                                    <tr>
                                        <td style="text-align:right">
                                            <b><?= $key ?>: </b>
                                        </td>
                                        <td>
                                            <b><?= $value ?></b>
                                        </td>

                                    </tr>
                                <? }
                                ?>

                            </table>

                        </td>
                        <td width="250px;" align="Right" class="alignBottom"><b>Nr. Procedimentos: <?= $qtdetotal; ?></b></td>
                        <td width="140px;" align="Right" class="alignBottom"><b>Nr. Mat/Med: <?= $medicamento; ?></b></td>
                        <? if ($_POST['aparecervalor'] == '1') { ?>
                            <td width="200px;" align="Right" colspan="3" class="alignBottom"><b>Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></b></td>
                        <? } ?>
                        <? if ($_POST['convenio'] > 0) { ?>
                            <? $valor_contrato = $this->convenio->listarvalorcontrato($_POST['convenio']); ?>
                            <td width="300px;" align="Right" colspan="3" class="alignBottom"><b>Contrato de Valor Fixo: <?= number_format($valor_contrato[0]->valor_contrato, 2, ',', '.'); ?></b></td>
                        <? } ?>
                    </tr>

                </tbody>

            </table>
        <? } else {
            ?>
           
        <? }
        ?>
        <?php if(count($centrocirurgico) > 0){?>
            <br>
            <h3>Procedimentos cirurgicos</h3>
            <table border=1 cellspacing=0 cellpadding=2 >
                <tr>
                    <th>Nome</th>
                    <th>Procedimento</th>
                </tr>
                <?
                $nome_aux = "";
                foreach($centrocirurgico as $item){ ?>
                <tr>
                    <td><? if ($nome_aux != $item->paciente) {
                                echo $item->paciente;
                            } 
                            $nome_aux =  $item->paciente;
                          ?>
                    </td>
                    <td><?= $item->procedimento; ?></td>
                </tr>
                <?php }?>
            </table>
        <?php }?>
             <? if (count($centrocirurgico) == 0 && count($relatorio) == 0) { ?>
              <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
             <?}?> 
    </div> <!-- Final da DIV content -->
</html>