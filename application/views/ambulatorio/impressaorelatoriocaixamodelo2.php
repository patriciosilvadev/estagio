  
<meta charset="UTF-8">

<title>Relatorio Caixa</title>
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>RELATÓRIO DE CAIXA</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <? if (count(@$_POST['operador']) > 0 && !in_array('0', @$_POST['operador'])) { ?>
        <h3>ATENDENTE: <?
            foreach ($operador as $value) {

                echo $value->nome;
                echo ",";
            }
            ?></h3>
    <? } ?>
    <? if (count(@$_POST['operador']) == 0 || in_array('0', @$_POST['operador'])) { ?>
        <h3>ATENDENTE: TODOS</h3>
    <? } ?>
    <? if (count($medico) != 0) { ?>
        <h3>MÉDICO: <?= $medico[0]->nome; ?></h3>
    <? } ?>    
    <? if (count($medico) == 0) { ?>
        <h3>MÉDICO: TODOS</h3>
    <? } ?>
    <hr>
    <?
    $empresapermissoes = $this->guia->listarempresapermissoes();
    ?>
    <style>

        a:hover{
            color:red;
        }
        .bold{
            font-weight: bolder;
        }
        .grey{
            background-color: grey;
        }
        .circulo {
            height: 25px;
            width: 25px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
        }
        .tabelaPagamentos{
            /* font-size: 5pt; */
            border-collapse: collapse;
            border-spacing: 5px;
        }

        .tabelaPagamentos td{
            font-size: 12px;
            padding: 7px;
            /*vertical-align: top;*/

        }
        .tabelaPagamentos th{
            font-size: 13px;
            padding: 7px;
            border: 1px solid black;
            /*vertical-align: top;*/

        }
        .tabelaGeral{
            /* font-size: 5pt; */
            border-collapse: separate;
            border-spacing: 5px;
        }

        .tabelaGeral td{
            font-size: 10px;
            /*vertical-align: top;*/

        }
        .alignTop{
            vertical-align: top;
        }

        .alignBottom{
            vertical-align: bottom;
        }
        .alignLeft{
            text-align: left;
        }
        .thOperador{
            text-align: left;

        }

        .tabelaFormas{
            /* font-size: 13pt; */
            border-collapse: collapse;

            width: 100%;
        }
        .tabelaFormas th{
            font-size: 8pt;
            /* width: 100px; */
        }
        .tabelaFormas td{
            /* padding-left: 5px; */
            /* padding-right: 5px; */
            /* text-align: center; */
            font-size: 7pt;
            /* width: 100px; */
            /* max-width: 100px; */
        }
        .tdNomeForma{
            text-align: center;
            width: 100px;
            /* max-width: 100px; */
        }
        .thNomeForma{
            text-align: center;
            width: 110px;
            /* max-width: 100px; */
        }
        .tabelaFormasValor{
            /* margin-bottom: 30px; */
            width: 70px;
            text-align: left;
        }
        .tabelaFormasParcelas{
            /* margin-bottom: 30px; */
            width: 50px;
            text-align: center;
        }
    </style>
    <? if((count($relatorio) > 0)){

    }else{
        $relatorio = array(); 
    } 
    //if (count($relatorio) > 0) { ?>
        <table class="tabelaGeral" cellspacing=1 cellpadding=1>
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Atendimento</th>
                    <th class="tabela_header"><font size="-1">Emissao</th>
                    <th class="tabela_header"><font size="-1">Paciente</th>
                    <th class="tabela_header"><font size="-1">Procedimento</th>
                    <th class="tabela_header"><font size="-1">Qtde</th>
                    <th class="tabela_header" title="Data de Atendimento"><font size="-1">Data Ate.</th>
                    <th class="tabela_header"><font size="-1">Data Pag.</th>
                    <th class="tabela_header"><font size="-1">F. Pagamento</th>
                    <th class="tabela_header"><font size="-1">Valor Tot.</th>
                    <th class="tabela_header"><font size="-1">Valor Pag.</th>
                    <th class="tabela_header"><font size="-1">Desconto Tot.</th>
                    <th class="tabela_header"><font size="-1">Observação</th>
                    <!--<th class="tabela_teste" width="80px;"style="text-align: right"><font size="-1">Total Geral</th>-->
                </tr>
                <tr>
                    <td colspan="6" class="tabela_header"></td>

                    <td colspan="3" class="tabela_header"></td>
                    <!--<th class="tabela_teste" width="80px;"style="text-align: right"><font size="-1">Total Geral</th>-->
                </tr>

            </thead>

            <?
            
            foreach($formapagamentocomcredito as $value){
                 @$formasCredito = $value->nome; 
             
            }
            // print_r($formapagamentocomtcd);
            foreach($formapagamentocomtcd as $value){
                 @$formasTcd = $value->nome;  
             
            } 
            
            foreach ($formapagamento as $value) {
                $formasValor[$value->nome] = 0;
                $formasCont[$value->nome] = 0;
                $formasDes[$value->nome] = 0;
                $formasCartao[$value->nome] = $value->cartao;
            }

            $guia_idTeste = 0;
            $operadorAtual = '';
            $data_inicio = $txtdata_inicio;
            $data_fim = $txtdata_fim;
            $agenda_exames_id = 0;
            $valor_total = 0;
            $contador_geral = 0;
            $teste_operador = 0;
            $contador_operador = 0;
            $contadorDinheiro = 0;
            $contadorCartao = 0;
            $valor_totalOperador = 0;
            $contadorGeralFormas = 0;
            $valorDinheiro = 0;
            $valorCartao = 0;
            $valorGeralFormas = 0;
            $valorTotalRelatorio = 0;
            $botaoFechar = false;
            $pendencia = false;
            $textoBotaoFechar = 'Caixa Fechado';
            $contador_teste = 0;
            $corPagamento = '';
            // Se houver pelo menos uma coisa a ser mandada pro financeiro, ele deixa o botao pra fechar caixa
            $i = 0;
            $asterisco = '(*)';


            foreach($inadimplenciaspagas as $value){
                // echo '<pre>';
                //  print_r($inadimplenciaspagas);
                $forma_pagamento_p = "";
                $ativo_array_p = "";
                $desconto_array_p = "";
                $parcelas_array = "";
                
                 $forma_pagamento_p = "{";
                 $ativo_array_p = "{";
                 $desconto_array_p = "{";
                 $parcelas_array ="{";
                if ($value->forma_pagamento != "" ) {
                    $forma_pagamento_p .= $value->forma_pagamento;
                    $ativo_array_p .="t";
                    $desconto_array_p .= "0";
                    $parcelas_array .="1";
                }
                if ($value->forma_pagamento_2 != "") {
                    $virgula= "";
                    if ($value->forma_pagamento != ""   ) {
                        $virgula = ",";
                    }
                    $forma_pagamento_p  .= $virgula.$value->forma_pagamento_2;          
                    
                    $ativo_array_p .=$virgula."t";
                    $desconto_array_p .= $virgula."0";
                    $parcelas_array .=$virgula."1";
                }
                if ($value->forma_pagamento_3 != "") {
                      $virgula= "";
                    if ($value->forma_pagamento != "" || $value->forma_pagamento_2 != "") {
                        $virgula = ",";
                    }
                    $forma_pagamento_p  .=  $virgula.$value->forma_pagamento_3;
                    $ativo_array_p .=$virgula."t";
                    $desconto_array_p .= $virgula."0";
                    $parcelas_array .=$virgula."1";
                }
                if ($value->forma_pagamento_4 != "" ) {
                      $virgula= "";
                    if ($value->forma_pagamento_3 != "" || $value->forma_pagamento_2 != "" || $value->forma_pagamento != "" ) {
                        $virgula = ",";
                    }
                    
                    $forma_pagamento_p  .=  $virgula.$value->forma_pagamento_4;
                    $ativo_array_p .= $virgula."t";
                    $desconto_array_p .= $virgula."0";
                    $parcelas_array .= $virgula."1";
                }
                $parcelas_array .="}";
                $desconto_array_p .= "}";
                $ativo_array_p .= "}";
                $forma_pagamento_p .= "}";
                
                if($value->agenda_exames_id != ''){
                    continue;
                }
            array_push($relatorio, json_decode(json_encode(array(
                "operador_autorizacao"=>"INADIMPLÊNCIAS PAGAS",
                "data"=>$value->data,
                "guia_id"=>$value->paciente_id."(Prontuário)",
                "paciente"=>$value->paciente,
                "procedimento_tuss_id"=>$value->procedimento_tuss_id,
                "agenda_exames_id"=>-$value->paciente_inadimplencia_id,
                "valor_ajustado_array"=>"{".$value->valor1.",".$value->valor2.",".$value->valor3.",".$value->valor4."}",
                "realizada"=>$value->faturado,
                "operador_editar"=>"",
                "procedimento"=>$value->procedimento,
                "quantidade"=>1,
                "codigo"=>$value->codigo,
                "valor_total"=>$value->valor,
                "data_faturar"=>$value->data_atualizacao,
                "forma_pagamento_array"=>$forma_pagamento_p,
                "ativo_array"=>$ativo_array_p,
                "valor_bruto_array"=>"{".$value->valor1.",".$value->valor2.",".$value->valor3.",".$value->valor4."}",
                "desconto_array"=>"{0,0,0,0}",
                "parcelas_array"=>$parcelas_array,
                "ajuste_array"=>"{0,0,0,0}",
                "financeiro_array"=>"{".$value->financeiro_fechado."}",
                "tipo_desconto"=>-1,
                "observacao"=>$value->observacaoinadimplencia,
                "inadimplencia"=>'t',
                "nao_constar_financeiro"=>'f')))); 
            }

               
//            print_r($inadimplencias);
            
            foreach($inadimplencias as $value){
                 
                $forma_pagamento_p = "";
                $ativo_array_p = "";
                $desconto_array_p = "";
                $parcelas_array = "";
                
                 $forma_pagamento_p = "{";
                 $ativo_array_p = "{";
                 $desconto_array_p = "{";
                 $parcelas_array ="{";
                if ($value->forma_pagamento != "" ) {
                    $forma_pagamento_p .= $value->forma_pagamento;
                    $ativo_array_p .="t";
                    $desconto_array_p .= "0";
                    $parcelas_array .="1";
                }
                if ($value->forma_pagamento_2 != "") {
                    $virgula= "";
                    if ($value->forma_pagamento != ""   ) {
                        $virgula = ",";
                    }
                    $forma_pagamento_p  .= $virgula.$value->forma_pagamento_2;          
                    
                    $ativo_array_p .=$virgula."t";
                    $desconto_array_p .= $virgula."0";
                    $parcelas_array .=$virgula."1";
                }
                if ($value->forma_pagamento_3 != "") {
                      $virgula= "";
                    if ($value->forma_pagamento != "" || $value->forma_pagamento_2 != "") {
                        $virgula = ",";
                    }
                    $forma_pagamento_p  .=  $virgula.$value->forma_pagamento_3;
                    $ativo_array_p .=$virgula."t";
                    $desconto_array_p .= $virgula."0";
                    $parcelas_array .=$virgula."1";
                }
                if ($value->forma_pagamento_4 != "" ) {
                      $virgula= "";
                    if ($value->forma_pagamento_3 != "" || $value->forma_pagamento_2 != "" || $value->forma_pagamento != "" ) {
                        $virgula = ",";
                    }
                    
                    $forma_pagamento_p  .=  $virgula.$value->forma_pagamento_4;
                    $ativo_array_p .= $virgula."t";
                    $desconto_array_p .= $virgula."0";
                    $parcelas_array .= $virgula."1";
                }
                $parcelas_array .="}";
                $desconto_array_p .= "}";
                $ativo_array_p .= "}";
                $forma_pagamento_p .= "}";
                
                if($value->agenda_exames_id != ''){
                    continue;
                }

            array_push($relatorio, json_decode(json_encode(array(
                "operador_autorizacao"=>"INADIMPLÊNCIAS LANÇADOS",
                "data"=>$value->data,
                "guia_id"=>$value->paciente_id."(Prontuário)",
                "paciente"=>$value->paciente,
                "procedimento_tuss_id"=>$value->procedimento_tuss_id,
                "agenda_exames_id"=>-$value->paciente_inadimplencia_id,
                "valor_ajustado_array"=>"{".$value->valor1.",".$value->valor2.",".$value->valor3.",".$value->valor4."}",
                "realizada"=>'$value->faturado',
                "operador_editar"=>"",
                "procedimento"=>$value->procedimento,
                "quantidade"=>1,
                "codigo"=>$value->codigo,
                "valor_total"=>$value->valor,
                "data_faturar"=>$value->data_atualizacao,
                "forma_pagamento_array"=>$forma_pagamento_p,
                "ativo_array"=>$ativo_array_p,
                "valor_bruto_array"=>"{".$value->valor1.",".$value->valor2.",".$value->valor3.",".$value->valor4."}",
                "desconto_array"=>"{0,0,0,0}",
                "parcelas_array"=>$parcelas_array,
                "ajuste_array"=>"{0,0,0,0}",
                "financeiro_array"=>"{".$value->financeiro_fechado."}",
                "tipo_desconto"=>-1,
                "observacao"=>$value->observacaoinadimplencia,
                "inadimplencia"=>'t',
                "nao_constar_financeiro"=>'t')))); 
            }


            foreach($tcdpagos as $value){
                // echo '<pre>';
                // print_r($tcdpagos);
                // die;
            array_push($relatorio, json_decode(json_encode(array(
                "operador_autorizacao"=>"TCDs PAGOS",
                "data"=>$value->data,
                "guia_id"=>$value->paciente_id."(Prontuário)",
                "paciente"=>$value->paciente,
                "procedimento_tuss_id"=> 0,
                "agenda_exames_id"=> $value->paciente_tcd_id,
                "valor_ajustado_array"=> $value->valor_ajustado_array,
                "realizada"=>'t',
                "operador_editar"=>"",
                "procedimento"=> $value->procedimento,
                "quantidade"=> $value->quantidade,
                "codigo"=> 0 ,
                "valor_total"=> $value->valor_total,
                "data_faturar"=>$value->data_atualizacao,
                "forma_pagamento_array"=> $value->forma_pagamento_array,
                "ativo_array"=> $value->ativo_array,
                "valor_bruto_array"=>$value->valor_bruto_array,
                "desconto_array"=>$value->desconto_array,
                "parcelas_array"=>$value->parcelas_array,
                "ajuste_array"=>$value->ajuste_array,
                "financeiro_array"=>$value->financeiro_array,
                "tipo_desconto"=>-1,
                "observacao"=>$value->observacao,
                "nao_constar_financeiro"=>'f')))); 
            }

            // echo '<pre>';
            // print_r($relatorio);
            // die;
            foreach ($relatorio as $key => $item) {
                ?>
                <?
//           $valorTotalRelatorio += $valor_totalOperador;
                if ($contador_teste == 106) {
                    // break;
                }
                $contador_teste++;
                $contador_operadorAnt = $contador_operador;
                $valor_totalOperadorAnt = $valor_totalOperador;
                // Quantidade de procedimentos e valor do último operador
                if ($item->operador_autorizacao != $operadorAtual) {
                    $operadorAtualD = true;
                    $contador_operador = 0;
                    $valor_totalOperador = 0;
//               $valorTotalRelatorio += $valor_totalOperador;
                } else {
                    $operadorAtualD = false;
                }
                $data = date("d/m/Y", strtotime($item->data));
                // Se for uma guia diferente da anterior
                if ($guia_idTeste != $item->guia_id) {
                    $guia_id = $item->guia_id;
                    $paciente = $item->paciente;
                    $dataD = $data;
                } else {
                    $guia_id = '';
                    $paciente = '';
                    $dataD = '';
                }
                $corPR = 'black';
                $corPagamento = '';
                // Cor do procedimento
                if ($item->realizada == 'f') {
                    $corPR = 'blue';
                }
                if ($item->realizada == 'f' && $empresapermissoes[0]->faturar_parcial == 'f') {
                    $pendencia = true;
                }



                $operadorEditar = $item->operador_editar;
                $operadorAtual = $item->operador_autorizacao;
                $procedimento = $item->procedimento;
                $qtdePro = $item->quantidade;
                $codigoTUSS = $item->codigo;
                $valor_totalProc = $item->valor_total;
                $valor_descontoTotal = 0;
                $valor_totalFormas = 0;




                //    if($guia_idTeste == 3093867){
                //     echo "<tr><td>AAAAAeee</td></tr>";
                //    }
                //    $guia_id = $item->guia_id; 
                //    $paciente = $item->paciente; 
                if ($operadorEditar != '') {
                    $editado = $asterisco;
                } else {
                    $editado = '';
                }


                if ($item->data_faturar != '') {
                    $data_faturar = date("d/m/Y", strtotime($item->data_faturar));
                } else {
                    $data_faturar = '';
                }


                
                 // Como o agenda_exames se repete,  o contador do relatório só conta caso o agenda_exames seja diferente do ultimo
                // E soma valor total da mesma forma
                if ($agenda_exames_id != $item->agenda_exames_id) {
                    $contador_geral++;
//                    foreach ($array_formas as $forma) {
                            //   print_r($forma);
                            //   print_r($formapagamentocomtcd[0]->nome);
                            //  || @$forma == $formapagamentocomtcd[0]->nome

                            // print_r($valor_totalProc);
                            // echo ' - ';
                           

                            // $arrayVerificarrayVerificarCredito = $item->forma_pagamento_array;
                            // $arrayVerificarrayVerificarCredito = str_replace('{', '', str_replace('}', '', $arrayVerificarrayVerificarCredito));
                            // if ($arrayVerificarrayVerificarCredito != 'NULL') {
                            //     $arraycredito_atualizacao = explode(',', $arrayVerificarrayVerificarCredito);
                            // } else {
                            //     $arraycredito_atualizacao = array();
                            // }


                            $valor_total += $valor_totalProc;  

                            // if(count($arraycredito_atualizacao) > 0){
                            //     $nao_repetir = 1;
                            //     foreach($arraycredito_atualizacao as $numerochave => $pagamento){
                            //         // print_r($pagamento);
                            //         // echo ' - ';
                            //             if($pagamento == $formapagamentocomcredito[0]->nome || @$item->nao_constar_financeiro == 't'){

                            //             }else{
                            //                 if($nao_repetir == 1){
                            //                     $valor_total += $valor_totalProc; 
                            //                 }else{

                            //                 }
                            //                 $nao_repetir = 2;
                            //                 // print_r($valor_total); 
                            //             }

                            //         }
                                //}else{
                                   // if($item->nao_constar_financeiro == 't'){

                                   // }else{
                                        // $valor_total += $valor_totalProc;  
                                  //  }
                                // print_r($valor_total);
                           // }

                            // echo '<br>';


                        // if (@$forma == $formapagamentocomcredito[0]->nome || @$item->nao_constar_financeiro == 't') {
                           
                        // } else {  
                        //     $valor_total += $valor_totalProc;  
                        // }

                        
                //    }
 
                    $contador_operador ++;
                    $valor_totalOperador += $valor_totalProc;
                }
                
                
                $agenda_exames_id = $item->agenda_exames_id;
                
                

                // Tratando os arrays com os pagamentos;
                // É só pra tirar as chavinhas e fazer ele virar um array mesmo, nada de mirabolante
             
           $array_formasPG = $item->forma_pagamento_array;
//              print_r($array_formasPG);
                $array_formasStr = str_replace('{', '', str_replace('}', '', $array_formasPG));
                if ($array_formasStr != 'NULL') {
                    $array_formas = explode(',', $array_formasStr);
                } else {
                    $array_formas = array();
                }


               




                // ATENCAO A ESSA PARTE, ELA VAI FAZER UM ARRAY PRA SABER QUAIS PAGAMENTOS ESTAO ATIVOS
                $array_ativoPG = $item->ativo_array;
                $array_ativoStr = str_replace('{', '', str_replace('}', '', $array_ativoPG));
                $array_ativo = explode(',', $array_ativoStr);

                if ($data_faturar != '') {
                    // echo '<pre>';
                    // var_dump($array_ativo); die;
                    if (!in_array('t', $array_ativo)) {
                        continue;
                    }
                }

                $guia_idTeste = $item->guia_id;
                //    echo '<pre>'; 
                //    var_dump($array_ativo); 
                //    die;
                // Valor
                $array_valorPG = $item->valor_bruto_array;
                $array_valorStr = str_replace('{', '', str_replace('}', '', $array_valorPG));
                $array_valor = explode(',', $array_valorStr);
                // Valor ajustado
                $array_valorAjustadoPG = $item->valor_ajustado_array;
                $array_valorAjustadoStr = str_replace('{', '', str_replace('}', '', $array_valorAjustadoPG));
                $array_valorAjustado = explode(',', $array_valorAjustadoStr);
                // Desconto
                $array_descontoPG = $item->desconto_array;
                $array_descontoStr = str_replace('{', '', str_replace('}', '', $array_descontoPG));
                $array_desconto = explode(',', $array_descontoStr);
                // Parcelas
                $array_parcelasPG = $item->parcelas_array;
                $array_parcelasStr = str_replace('{', '', str_replace('}', '', $array_parcelasPG));
                $array_parcelas = explode(',', $array_parcelasStr);
                // Ajuste
                $array_ajustePG = $item->ajuste_array;
                $array_ajusteStr = str_replace('{', '', str_replace('}', '', $array_ajustePG));
                $array_ajuste = explode(',', $array_ajusteStr);
                // Financeiro = Se já foi fechado o caixa com esse pagamento 
                $array_financeiroPG = $item->financeiro_array;
                $array_financeiroStr = str_replace('{', '', str_replace('}', '', $array_financeiroPG));
                $array_financeiro = explode(',', $array_financeiroStr);
   
                // Contador usado pra atribuir valores as formas
                $contf = 0;
                ?>
                <? if ($operadorAtualD) { ?>

                    <? if ($teste_operador > 0) {// Se for zero é porque é o primeiro operador, então não mostra a tabelinha?>

                    <? } ?>
                    <tr>
                        <th colspan="7" class="thOperador">
                                  <?php if (@$item->inadimplencia == "t") {
                                        echo $operadorAtual;
                                    }else{?>
                            Operador: <?= $operadorAtual ?>
                                    <?php }?>
                        </th>
                        <td class="tabela_header">
                            <table  class="tabelaFormas" cellspacing=0 cellpadding=1>
                                <tr>
                                    <th class="thNomeForma">
                                        F. Pag   
                                    </th>
                                    <th class="tabelaFormasParcelas">
                                        Parcelas   
                                    </th>
                                    <th class="tabelaFormasValor">
                                        Valor Pag
                                    </th>
                                    <th class="tabelaFormasValor">
                                        Ajuste
                                    </th >
                                    <th class="tabelaFormasValor">
                                        Desconto 
                                    </th>

                                </tr>
                            </table>

                        </td>
                    </tr>
                <? } ?> 
                <tr>
                    <td class="alignTop"><?= $guia_id ?></td>
                    <td class="alignTop"><?= $dataD ?></td>
                    <td class="alignTop"><?= $paciente ?></td>
                      <?php if (@$item->inadimplencia == "t") {
                                    if ($item->realizada == "f") {
                                        $corPR = "red";
                                    }
                      ?>
                   <td class="alignTop" style="color: <?= $corPR ?>">                        
                              <?= $procedimento ?>                         
                    </td>
                    <td class="alignTop">                       
                            <?= $qtdePro ?> <?= $editado ?>                        
                    </td>
                            <?
                        }else{?>
                    <td class="alignTop" style="color: <?= $corPR ?>">
                        <a class="aHover" style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarmodelo2/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>', '_blank', 'width=1000,height=900');">
                            <?= $agenda_exames_id ?> - <?= $procedimento ?>
                        </a>
                    </td>
                    <td class="alignTop">
                        <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarmodelo2/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>', '_blank', 'width=1000,height=900');">
                            <?= $qtdePro ?> <?= $editado ?>
                        </a>   
                    </td>
                        <? }?>
                    <td class="alignTop"><?= $data ?></td>
                    <td class="alignTop"><?= $data_faturar ?></td>
                    <td style="text-align: center;">

                        <table  class="tabelaFormas" cellspacing=0 cellpadding=1>
                            
                            <?
                            foreach ($array_formas as $forma) {


                                // AQUI EU VERIFICO SE A FORMA NAO ESTA EXCLUIDA
                                $forma = str_replace('"', '', $forma);
                                if ($array_ativo[$contf] == 'f') {
                                    // echo '<tr><td>AAaA</td></tr>';
                                    $contf++;
                                    continue;
                                }
                                // print_r($array_valorAjustado[$contf]);
                                // print_r($item->nao_constar_financeiro);
                                $parcelas = $array_parcelas[$contf];
                                $valor_totalFormas += $array_valorAjustado[$contf];
                                $valor_descontoTotal += $array_desconto[$contf];

                                if($item->nao_constar_financeiro != 't')
                                @$formasValor[$forma] += $array_valorAjustado[$contf];
                                @$formasDes[$forma] += $array_desconto[$contf];
                                @$formasCont[$forma] ++;


                                if (@$formasCartao[$forma] == 't') {
                                    if(@$item->nao_constar_financeiro == 't'){

                                    }else{
                                    $contadorCartao++;
                                    $valorCartao += $array_valorAjustado[$contf];
                                    }
                                } elseif (@$forma ==  @$formasCredito || @$item->nao_constar_financeiro == 't') {
                                    
                                } else {
                                    $contadorDinheiro++;
                                    $valorDinheiro += $array_valorAjustado[$contf];
                                }
                                // || @$forma ==  @$formasTcd
                                if (@$forma ==  @$formasCredito || @$item->nao_constar_financeiro == 't') {
                                    
                                } else {
                                    $valorGeralFormas += $array_valorAjustado[$contf];
                                    $contadorGeralFormas++;
                                }
 

                                if (@$array_financeiro[$contf] == 't'  || @$forma == $formasCredito ) {
                                    $corForma = 'green';
                                } else {
                                    $corForma = 'black';
                                    $botaoFechar = true;
                                }
                                ?>
                                <tr style="color: <?= $corForma ?>">
                                    <td class="tdNomeForma">
                                        <?= $forma ?>
                                    </td>

                                    <td class="tabelaFormasParcelas">
                                        <?= $parcelas ?>
                                    </td>

                                    <td class="tabelaFormasValor">
                                        R$: <?= number_format(@$array_valorAjustado[$contf], 2, ',', '.') ?>
                                    </td>
                                    <td class="tabelaFormasValor">
                                        <?= $array_ajuste[$contf] ?>%
                                    </td>
                                    <td class="tabelaFormasValor">
                                        R$: <?= number_format($array_desconto[$contf], 2, ',', '.') ?>
                                    </td>
                                    
                                </tr>
                                <?
                                $contf++;
                            }
                            ?>

                        </table>

                    </td>
                    <?
                    if ($valor_totalProc > ($valor_descontoTotal + $valor_totalFormas) && $empresapermissoes[0]->faturar_parcial == 'f') {
                        $corPagamento = 'red';
                        $pendencia = true;  
                       
                    } 
                    
                    if($item->tipo_desconto != ''){
                        if ($item->tipo_desconto == 'medico') {
                            $tipo_desconto = 'Desconto com Permissão do Médico';
                        }
                        if ($item->tipo_desconto == 'clinica') {
                            $tipo_desconto = 'Desconto com Permissão da Clinica';
                        }
                        if ($item->tipo_desconto == 'medico_clinica') {
                            $tipo_desconto = 'Desconto do Médico e da Clinica';
                        }
                    }else{
                        $tipo_desconto = '';
                    }
                    ?>
                    <td class="alignBottom">R$: <?= number_format($valor_totalProc, 2, ',', '.'); ?></td>
                    <td class="alignBottom" style="color: <?= $corPagamento ?>">R$: <?= number_format($valor_totalFormas, 2, ',', '.') ?></td>
                    <td class="alignBottom" <?=(@$tipo_desconto != '')? 'style="color: darkorange;"': ''?> title="<?=@$tipo_desconto?>">R$: <?= number_format($valor_descontoTotal, 2, ',', '.') ?></td>
                    <td class="alignBottom">


                        <?
                        if ($item->observacao != "") {
                            echo @$item->observacao;
                        } else {
//                           echo  $item->observacaomod1 ;
                        }
                        ?>



                    </td>
<!--<td class="tabelaFormasValor">
    <a 
onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/listarnotasfiscais/" . $item->guia_id; ?> ', '_blank', 'width=1000,height=600');"
>GERAR NOTA FISCAL</a>
                                    </td>-->



                                        <!--<th class="tabela_teste" width="80px;"style="text-align: right"><font size="-1">Total Geral</th>-->
                </tr>    



                <?
                // Listinha do Operador
                // É caso o próximo operador seja diferente ou o foreach tenha chegado no fim
                if (isset($relatorio[$key + 1]->operador_autorizacao) && $operadorAtual != $relatorio[$key + 1]->operador_autorizacao || !isset($relatorio[$key + 1])) {
                    ?>
                    <tr>
                        <td colspan="10"></td>
                        <td colspan="2"><b>TOTAL</b></td>
                    </tr>
                    <tr>
                        <td colspan="10"></td>
                        <td colspan="2"><b>Nr. Procedimentos: <?= $contador_operador; ?></b></td>
                        <?
                        $contador_operadorAnt = 0;
                        ?>
                    </tr>
                    <tr>
                        <td colspan="10"></td>
                        <td colspan="2"><b>VALOR TOTAL: <?= number_format($valor_totalOperador, 2, ',', '.'); ?></b></td>
                    </tr>
                    <?
                }

                $i++;
            } // Fim do Loop dos procedimentos  
            ?>
            <?
            // Form pra fechar o caixa
            ?>


            <tr>
            <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fecharcaixamodelo2" method="post">

                <?
                //para pegar a quantidade de creditos
                foreach ($creditos as $item) {
                    foreach ($formapagamento as $value) {
                        if ($item->forma_pagamento == $value->nome) {
                            @$datacredito2[$value->nome] = $datacredito2[$value->nome] + $item->valor1;
                            @$numerocredito2[$value->nome] ++;
                        }

                        if ($item->forma_pagamento_2 == $value->nome) {
                            @$datacredito2[$value->nome] = $datacredito2[$value->nome] + $item->valor2;
                            @$numerocredito2[$value->nome] ++;
                        }

                        if ($item->forma_pagamento_3 == $value->nome) {
                            @$datacredito2[$value->nome] = $datacredito2[$value->nome] + $item->valor3;
                            @$numerocredito2[$value->nome] ++;
                        }

                        if ($item->forma_pagamento_4 == $value->nome) {
                            @$datacredito2[$value->nome] = $datacredito2[$value->nome] + $item->valor4;
                            @$numerocredito2[$value->nome] ++;
                        }
                    }
                }
                    // print_r($creditos);
                foreach ($formapagamento as $value) {

                    //Caso seja forma de pagamento CREDITO não será processado no fechar caixa da mesma forma que os outros
                    if ($value->forma_pagamento_id == 1000) {
                        continue;
                    }

                    @$w++;
                    /*
                     * Obs: O codigo abaixo foi feito pois o CodeIgniter não aceita certos caracteres
                     * tais como '-', ' ', entre outros ao se fazer isso:
                     * name="qtde['<?= $value->nome; ?>']
                     */
                    $nomeForma2 = str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $value->nome);
                    $nomeForma2 = strtolower($nomeForma2);

                    ?>

                    
                    

                    <input type="hidden" class="texto3" name="qtdecredito[<?= @$nomeForma2; ?>]" value="<?= number_format(@$datacredito2[$value->nome], 2, ',', '.'); ?>"/>
                    <?
                }
                ?>



                <input type="hidden" class="texto3" name="data1" value="<?= $txtdata_inicio; ?>"/>
                <input type="hidden" class="texto3" name="data2" value="<?= $txtdata_fim; ?>"/>    
                <input type="hidden" class="texto3" name="empresa" value="<?= (count($empresa) > 0) ? $empresa[0]->empresa_id : ''; ?>"/>
                <input type="hidden" class="texto3" name="empresaNome" value="<?= (count($empresa) > 0) ? $empresa[0]->nome : ''; ?>"/>
                <input type="hidden" class="texto3" name="grupo" value="<?= $_POST['grupo'] ?>"/>
                <input type="hidden" class="texto3" name="procedimentos" value="<?= (@$_POST['procedimentos'] > 0) ? $_POST['procedimentos'] : '' ?>"/>
                <?
                if (count(@$_POST['operador']) > 0 && !in_array('0', @$_POST['operador'])) {
                    $array_operador = json_encode(@$_POST['operador']);
                } else {
                    $array_operador = '';
                }
                // var_dump($array_operador); die;
                ?>                      
                <input type="hidden" class="texto3" name="operador" value='<?= $array_operador ?>'/> 
                <input type="hidden" class="texto3" name="operadorNome" value="<?= (count(@$_POST['operador']) > 0 && !in_array('0', @$_POST['operador'])) ? $operador[0]->nome : '' ?>"/>
                <input type="hidden" class="texto3" name="medico" value="<?= $_POST['medico'] ?>"/>
                <input type="hidden" class="texto3" name="medicoNome" value="<?= (@$_POST['medico'] > 0) ? $medico[0]->nome : '' ?>"/>
                <td colspan="9" style="padding-top: 40px;"></td>
                <?
                 
                if ($pendencia) { 
                    $botaoFechar = false;
                    $textoBotaoFechar = 'Pendente';  
                    
                }
             
                ?>
                <? if ($_POST['medico'] > 0 || $_POST['grupo'] != '0') { ?>
                    <td colspan="2" style="padding-top: 40px;color: #b31b1b"><h3>Retire o filtro de "Médico" e "Especialidade" para fechar o caixa</h3></td>
                <? } else { ?>
                    <? if ($botaoFechar) { ?>
                        <td colspan="2" style="padding-top: 40px;"><button type="submit" name="btnEnviar">Fechar Caixa</button></td>
                    <? } else { ?>
                        <td colspan="2" style="padding-top: 40px;"><button disabled="" ><?= $textoBotaoFechar ?></button></td>
                    <? } ?>
                <? } ?>

            </form>
            </tr>
        </table>






        <hr>
        <br>

        <div style="">
            <? if (count($creditos) > 0) { ?>
                <?
                $contador_creditos = 0;
                foreach ($creditos as $item) {
                    $contador_creditos++;
                    if ($item->faturado == 'f') {
                        $faturado = 'f';
                    }
                    if ($item->financeiro_fechado == 't') {
                        $financeiro = 't';
                    }
                }
                ?>
                <table  border="1" class="tabelaPagamentos "  style="magin-right: 12pt;display: inline-block;">
                    <thead>
                        <tr>
                            <th colspan="13" class="grey"><font size="-1"> CRÉDITOS LANÇADOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="grey"><font size="2"><b>PACIENTE</b></th>
                            <th class="grey"><font size="2"><b>DATA</b></th>
                            <th class="grey"><font size="2"><b>VALOR</b></th>
                            <th class="grey"><font size="2"><b>F.Pagamento 1</b></th>
                            <th class="grey"><font size="2"><b>Valor 1</b></th>
                            <th class="grey"><font size="2"><b>F.Pagamento 2</b></th>
                            <th class="grey"><font size="2"><b>Valor 2</b></th>
                            <th class="grey"><font size="2"><b>F.Pagamento 3</b></th>
                            <th class="grey"><font size="2"><b>Valor 3</b></th>
                            <th class="grey"><font size="2"><b>F.Pagamento 4</b></th>
                            <th class="grey"><font size="2"><b>Valor 4</b></th>
                            <th class="grey"><font size="2"><b>Observação</b></th>
                            <th class="grey"><font size="2"><b>Operador Responsável</b></th>
                        </tr>
                        <?
                        @$valorcreditototal = 0;
                        foreach ($creditos as $item) {
                            ?>
                            <?
                            $valorcreditototal = $valorcreditototal + ($item->valor1 + $item->valor2 + $item->valor3 + $item->valor4);
                            ?>
                            <tr <? if ($item->faturado == 'f') { ?> style="color: red;" <? } ?>>
                                <td><font size="-2"><?= @$item->paciente ?></td>
                                <td><font size="-2"><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                <td><font size="-2"><?= number_format($item->valor, 2, ',', '') ?></td>
                                <td><font size="-2"><?= @$item->forma_pagamento ?></td>
                                <td><font size="-2"><?= number_format($item->valor1, 2, ',', '') ?></td>
                                <td><font size="-2"><?= @$item->forma_pagamento_2 ?></td>
                                <td><font size="-2"><?= number_format($item->valor2, 2, ',', '') ?></td>
                                <td><font size="-2"><?= @$item->forma_pagamento_3 ?></td>
                                <td><font size="-2"><?= number_format($item->valor3, 2, ',', '') ?></td>
                                <td><font size="-2"><?= @$item->forma_pagamento_4 ?></td>
                                <td><font size="-2"><?= number_format($item->valor4, 2, ',', '') ?></td>
                                <td><font size="-2"><?= @$item->observacaocredito ?></td>
                                <td><font size="-2"><?= @$item->operador ?></td>
                            </tr>

                            <?
                        }
                        ?>
                    </tbody>
                </table> 
            <? } ?>
        </div>

        <hr>
        <br>

        <div style="">
            <? if (count($inadimplencias) > 0) { ?>
                
                <table  border="1" class="tabelaPagamentos "  style="magin-right: 12pt;display: inline-block;">
                    <thead>
                        <tr>
                            <th colspan="13" class="grey"><font size="-1"> INADIMPLÊNCIAS LANÇADOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="grey"><font size="2"><b>PACIENTE</b></th>
                            <th class="grey"><font size="2"><b>DATA</b></th>
                            <th class="grey"><font size="2"><b>PROCEDIMENTO</b></th>
                            <th class="grey"><font size="2"><b>VALOR INADIMPLENTE</b></th>
                            <th class="grey"><font size="2"><b>OPERADOR RESPONSÁVEL</b></th>
                        </tr>
                        <?
//                        @$valorcreditototal = 0;
                        foreach ($inadimplencias as $item) {
                            ?>
                            
                            <tr <? if ($item->faturado == 'f') { ?> style="color: red;" <? } ?>>
                                <td><font size="-2"><?= @$item->paciente ?></td>
                                <td><font size="-2"><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                <td><font size="-2"><?= @$item->procedimento ?></td>
                                <td><font size="-2"><?= number_format($item->valor, 2, ',', '') ?></td>
                                
                                <!-- <td><font size="-2"><?= @$item->observacaoinadimplencia ?></td> -->
                                <td><font size="-2"><?= @$item->operador ?></td>
                            </tr>

                            <?
                        }
                        ?>
                    </tbody>
                </table> 
            <? } ?>
        </div>
        <br>
        <hr>
        <br>



        <table border="1" class="tabelaPagamentos " style="display: inline-block;margin-top:-10px;" >
                <!--<thead>-->
            <tr class="grey">
                <th colspan="3">Forma de Pagamento</th>
                <th>Desconto</th>
                <!--<th>Desconto</th>-->
            </tr>
            <tr class="grey">
                <th >Nome</th>
                <th >Qtde</th>
                <th colspan="1">Valor</th>
                <th colspan="1"></th>

            </tr>
            <!--</thead>-->
            <tbody>
                <?
                // echo '<pre>';
                // print_r($formasValor);
                foreach ($formasValor as $nomeForma => $valor) {
                    if ($formasCont[$nomeForma] == 0) {
                        continue;
                    }
                    ?>
                    <tr>
                        <td><?= $nomeForma ?></td>
                        <td><?= $formasCont[$nomeForma] ?></td>
                        <td class="alignLeft">R$ <?= number_format($valor, 2, ',', '.') ?></td>
                        <td class="alignLeft">R$ <?= number_format($formasDes[$nomeForma], 2, ',', '.') ?></td>
                    </tr>
                <? }
                ?>

                <tr>
                    <td class="bold">Total Cartão</td>
                    <td ><?= $contadorCartao ?></td>
                    <td colspan="2">R$ <?= number_format($valorCartao, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="bold">Total Dinheiro</td>
                    <td ><?= $contadorDinheiro ?></td>
                    <td class="alignLeft" colspan="2">R$ <?= number_format($valorDinheiro, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="bold">Total Pago</td>
                    <td ><?= $contadorGeralFormas ?></td>
                    <td class="alignLeft" colspan="2">R$ <?= number_format($valorGeralFormas, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="bold">Total Geral</td>
                    <td class="alignLeft" colspan="3">R$ <?= number_format($valor_total, 2, ',', '.') ?></td>
                </tr>
    <!--                    <tr>
                    <td class="bold">Pendente</td>
                    <td class="alignLeft" colspan="3">R$ <?= number_format($valor_total - $valorGeralFormas, 2, ',', '.') ?></td>
                </tr>-->
            </tbody>
        </table>
                    <br><br>
        <? if (count($sangria)) { ?>
                <div>
                    <table border="1" class="tabelaPagamentos " style="display: inline-block;margin-top:-10px;">
                        <thead>
                            <tr class="grey">
                                <th colspan="2">Sangria</th>
                            </tr>
                            <tr class="grey">
                                <th >Caixa</th>
                                <th >Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            $valorsangria = 0;
                            $resumoTotal = 0;
                            foreach ($sangria as $item) :
                                $valorsangria = $valorsangria + $item->valor;
                                ?>
                                <tr>
                                    <td><?= ($item->operador_caixa); ?></td>
                                    <td><?= number_format($item->valor, 2, ',', '.'); ?></td>
                                </tr>
                            <? endforeach; ?>
                            <tr>
                                <th colspan="2" class="grey">Total de Sangria</th>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Total</td>
                                <td><?= number_format($valorsangria, 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th colspan="2" class="grey">Total Apurado Menos Sangria</th>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Total</td>
                                <td><?= number_format($valorGeralFormas - $valorsangria, 2, ',', '.'); ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            <? } ?>




        <? if (count($creditos) > 0) { ?> 

            <div  style="display: inline-block;">
                <table border="1" class="tabelaPagamentos "  style="display: inline-block;">
                    <tbody>
                        <tr class="grey">
                            <th colspan="3"  ><center><font size="-1"><b>Forma de Pagamento Crédito</b></center></th>
                    <!--<td colspan="1" bgcolor="#C0C0C0"><center><font size="-1">DESCONTO</center></td>-->
                    </tr>
                    <?
                    foreach ($creditos as $item) {
                        foreach ($formapagamento as $value) {
                            if ($item->forma_pagamento == $value->nome) {
                                $datacredito[$value->nome] = @$datacredito[$value->nome] + $item->valor1;
                                @$numerocredito[$value->nome] ++;
                            }
//                        }
//                        foreach ($formapagamento as $value) {
                            if ($item->forma_pagamento_2 == $value->nome) {
                                $datacredito[$value->nome] = @$datacredito[$value->nome] + $item->valor2;
                                @$numerocredito[$value->nome] ++;
                            }
//                        }
//                        foreach ($formapagamento as $value) {
                            if ($item->forma_pagamento_3 == $value->nome) {
                                $datacredito[$value->nome] = @$datacredito[$value->nome] + $item->valor3;
                                @$numerocredito[$value->nome] ++;
                            }
//                        }
//                        foreach ($formapagamento as $value) {
                            if ($item->forma_pagamento_4 == $value->nome) {
                                $datacredito[$value->nome] = @$datacredito[$value->nome] + $item->valor4;
                                @$numerocredito[$value->nome] ++;
                            }
                        }
                    }





                    foreach ($formapagamento as $value) {
                        if (@$numerocredito[$value->nome] > 0) {
                            ?>
                            <tr>
                                <td ><font size="-1"><?= $value->nome ?></td>
                                <td ><font size="-1"><?= @$numerocredito[$value->nome]; ?></td>
                                <td ><font size="-1"><?= number_format(@$datacredito[$value->nome], 2, ',', '.'); ?></td>
                                <!--<td><font size="-1"><?= number_format($desconto[$value->nome], 2, ',', '.'); ?></td>-->
                            </tr>    


                            <?
                        }
                    }
                    ?>

                    <?
                    $TOTALCARTAO = 0;
                    $QTDECARTAO = 0;
                    $valorDinheiroCredito = 0;
                    $valorCartaoCredito = 0;
                    $qtdeDinheiroCredito = 0;
                    $qtdeCartaoCredito = 0;
                    foreach ($formapagamento as $value) {
                        /* A linha abaixo era a condiçao do IF antigamente. Agora tudo que nao for cartao sera DINHEIRO */
                        //                ($value->nome != 'DINHEIRO' && $value->nome != 'DEBITO' && $value->nome != 'CHEQUE') 
                        if ($value->cartao != 'f') {
                            $TOTALCARTAO = @$TOTALCARTAO + @$datacredito[$value->nome];
                            $QTDECARTAO = @$QTDECARTAO + @$numerocredito[$value->nome];
                            $valorCartaoCredito += @$datacredito[$value->nome];
                            $qtdeCartaoCredito += @$numerocredito[$value->nome];
                        }else{
                            $valorDinheiroCredito += @$datacredito[$value->nome];
                            $qtdeDinheiroCredito += @$numerocredito[$value->nome];
                        }
                    }
                    ?>
                    <tr>
                        <td><font size="-1">TOTAL CARTAO</td>
                        <td><font size="-1"> <?= $QTDECARTAO; ?></td>
                        <td colspan="2"><font size="-1"><?= number_format($TOTALCARTAO, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td><font size="-1">TOTAL GERAL</td>
                        <td><font size="-1"><?= @$contador_creditos; ?></td>
                        <td colspan="2"><font size="-1"><?= number_format(@$valorcreditototal, 2, ',', '.'); ?></td>
                    </tr>
                    </tbody>

                </table>
            </div>

            <table border="1" class="tabelaPagamentos " style="display: inline-block;margin-top:-10px;" >
                    <!--<thead>-->
                <tr class="grey">
                    <th colspan="3">Forma de Pagamento + Créditos</th>
                    
                    <!--<th>Desconto</th>-->
                </tr>
                <tr class="grey">
                    <th >Nome</th>
                    <th >Qtde</th>
                    <th colspan="1">Valor</th>
                    

                </tr>
                <!--</thead>-->
                <tbody>
                    <?
                    foreach ($formapagamento as $value) {
                        if(!@$numerocredito[$value->nome] > 0){
                            continue;
                        }
                        if(array_key_exists($value->nome, $formasValor)){
                            $formasValor[$value->nome] += @$datacredito[$value->nome];
                            $formasCont[$value->nome] += @$numerocredito[$value->nome];
                         
                        }else{
                            $formasValor[$value->nome] = @$datacredito[$value->nome];
                            $formasCont[$value->nome] = @$numerocredito[$value->nome];
                        }
                    }
                    // echo '<pre>';
                    // var_dump(@$datacredito); die;
                    // As variaveis que vão ser usadas abaixo são as mesmas que são utilizadas para mostrar os valores anteriores, porém, somadas as do crédito
                    foreach ($formasValor as $nomeForma => $valor) {
                        if ($formasCont[$nomeForma] == 0) {
                            continue;
                        }
                        
                        ?>
                        <tr>
                            <td><?= $nomeForma ?></td>
                            <td><?= $formasCont[$nomeForma] ?></td>
                            <td class="alignLeft">R$ <?= number_format($valor, 2, ',', '.') ?></td>
                        </tr>
                    <? }
                    ?>
              
                    <tr>
                        <td class="bold">Total Cartão</td>
                        <td ><?= $contadorCartao + $qtdeCartaoCredito ?></td>
                        <td colspan="1">R$ <?= number_format($valorCartao + $valorCartaoCredito, 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Total Dinheiro</td>
                        <td ><?= $contadorDinheiro + $qtdeDinheiroCredito ?></td>
                        <td class="alignLeft" colspan="1">R$ <?= number_format($valorDinheiro + $valorDinheiroCredito, 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Total Pago</td>
                        <td ><?= $contadorGeralFormas + $contador_creditos ?></td>
                        <td class="alignLeft" colspan="1">R$ <?= number_format($valorGeralFormas + $valorcreditototal, 2, ',', '.') ?></td>
                    </tr>
                     
                </tbody>
            </table>
            <?
        }
        ?>

        <h4>(*) Procedimento Editado.</h4>
        <!--<br>-->
        <br>
        <table border="1" class="tabelaPagamentos">
            <tr class="grey">
                <th colspan="3">Legenda</th>

            </tr>
            <tr >
                <td >Sala de Espera</td>
                <!--<td >Azul</td>-->
                <td>
                    <div class="circulo" style="color: blue; background-color: blue;">

                    </div>
                </td>
            </tr>
            <?
            if ($empresapermissoes[0]->faturar_parcial == 'f') {
                ?>
                <tr>
                    <td >Pendente</td>
                    <!--<td >Azul</td>-->
                    <td>
                        <div class="circulo" style="color: red; background-color: red;">

                        </div>
                    </td>
                </tr>
            <? } ?>
            <tr >
                <td >Fechado</td>
                <!--<td >Verde</td>-->
                <td>
                    <div class="circulo" style="color: blue; background-color: green;">

                    </div>
                </td>
            </tr>
            <tr>
                <td>Desconto Especial</td>
                <!--<td >Verde</td>-->
                <td>
                    <div class="circulo" style="color: blue; background-color: darkorange;">

                    </div>
                </td>
            </tr>
            <tbody>

            </tbody>
        </table>

    <? //} ?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
